<?php
// app/Http\Controllers/CheckoutController.php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Rental;
use App\Models\DetailRental;
use App\Models\Buy;
use App\Models\DetailBuy;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    // Show checkout form
    public function show()
    {
        $cartItems = CartItem::with('item')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'Keranjang kosong. Silakan tambah produk terlebih dahulu.');
        }

        $rentalItems = $cartItems->where('type', 'rent');
        $purchaseItems = $cartItems->where('type', 'buy');

        $hasRentalItems = $rentalItems->count() > 0;
        $hasPurchaseItems = $purchaseItems->count() > 0;

        // Calculate base total amount (without delivery)
        $totalAmount = $cartItems->sum(function($item) {
            return $item->total_price;
        });

        // Default rental dates untuk form
        $defaultRentalDates = [
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays($rentalItems->max('days') ?? 1)->format('Y-m-d'),
            'days' => $rentalItems->max('days') ?? 1
        ];

        return view('checkout.show', compact(
            'rentalItems',
            'purchaseItems', 
            'hasRentalItems',
            'hasPurchaseItems',
            'totalAmount',
            'defaultRentalDates'
        ));
    }

    // Process checkout (CLEAN VERSION)
    public function process(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                
                $cartItems = CartItem::with('item')
                    ->where('user_id', Auth::id())
                    ->get();

                if ($cartItems->isEmpty()) {
                    return redirect()->route('cart.index')
                                   ->with('error', 'Keranjang kosong. Silakan tambah produk terlebih dahulu.');
                }

                $rentalItems = $cartItems->where('type', 'rent');
                $purchaseItems = $cartItems->where('type', 'buy');
                $hasRental = $rentalItems->count() > 0;
                $hasPurchase = $purchaseItems->count() > 0;

                // Validate request
                $validationRules = [
                    'payment_method' => 'required|in:qris,transfer,cash',
                    'delivery_option' => 'required|in:pickup,delivery',
                ];

                // Add shipping address validation if delivery is selected
                if ($request->delivery_option === 'delivery') {
                    $validationRules['shipping_address'] = 'required|string|min:10';
                }

                // Validasi untuk rental items
                if ($hasRental) {
                    $validationRules['identity_type'] = 'required|in:ktp,ktm,sim';
                    $validationRules['identity_file'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
                    $validationRules['rental_start_date'] = 'required|date';
                    $validationRules['rental_days'] = 'required|integer|min:1';
                }

                $validated = $request->validate($validationRules);

                // Manual date validation
                if ($hasRental) {
                    $startDate = \Carbon\Carbon::parse($validated['rental_start_date']);
                    $today = \Carbon\Carbon::today();
                    
                    if ($startDate->lt($today)) {
                        return redirect()->back()
                            ->withErrors(['rental_start_date' => 'Tanggal mulai sewa tidak boleh di masa lalu'])
                            ->withInput();
                    }
                }

                // Calculate delivery fee
                $deliveryFee = $validated['delivery_option'] === 'delivery' ? 18000 : 0;

                // Process file upload for rental
                $identityPath = null;
                if ($hasRental && $request->hasFile('identity_file')) {
                    $identityPath = $request->file('identity_file')->store('identities', 'public');
                }

                // Hitung total
                $rentalTotal = $hasRental ? $rentalItems->sum('total_price') : 0;
                $purchaseTotal = $hasPurchase ? $purchaseItems->sum('total_price') : 0;
                $totalAmount = $rentalTotal + $purchaseTotal + $deliveryFee;

                // Buat transaction
                $transaction = Transaction::create([
                    'user_id' => Auth::id(),
                    'total_amount' => $totalAmount,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'menunggu_pembayaran',
                ]);

                // Process rental items
                if ($hasRental) {
                    $startDate = $validated['rental_start_date'];
                    $rentalDays = $validated['rental_days'];
                    $endDate = date('Y-m-d', strtotime($startDate . ' + ' . $rentalDays . ' days'));

                    $rental = Rental::create([
                        'user_id' => Auth::id(),
                        'rental_start_date' => $startDate,
                        'rental_end_date' => $endDate,
                        'total_price' => $rentalTotal + $deliveryFee,
                        'order_status' => 'menunggu_verifikasi',
                        'delivery_option' => $validated['delivery_option'],
                        'identity_file' => $identityPath,
                        'identity_type' => $validated['identity_type'],
                        'shipping_address' => $validated['shipping_address'] ?? null,
                    ]);

                    // Create rental details
                    foreach ($rentalItems as $cartItem) {
                        DetailRental::create([
                            'rental_id' => $rental->rental_id,
                            'item_id' => $cartItem->item_id,
                            'quantity' => $cartItem->quantity,
                            'penalty' => 0,
                        ]);

                        // Update rental stock
                        $cartItem->item->decrement('rental_stock', $cartItem->quantity);
                    }

                    // Link rental ke transaction
                    TransactionItem::create([
                        'transaction_id' => $transaction->transaction_id,
                        'order_type' => 'rental',
                        'order_id' => $rental->rental_id,
                        'amount' => $rentalTotal + $deliveryFee,
                    ]);
                }

                // Process purchase items
                if ($hasPurchase) {
                    $buy = Buy::create([
                        'user_id' => Auth::id(),
                        'total_price' => $purchaseTotal + $deliveryFee,
                        'order_status' => 'menunggu_verifikasi',
                        'delivery_option' => $validated['delivery_option'],
                        'shipping_address' => $validated['shipping_address'] ?? null,
                    ]);

                    foreach ($purchaseItems as $cartItem) {
                        DetailBuy::create([
                            'buy_id' => $buy->buy_id,
                            'item_id' => $cartItem->item_id,
                            'quantity' => $cartItem->quantity,
                            'total_price' => $cartItem->total_price,
                        ]);

                        $cartItem->item->decrement('sale_stock', $cartItem->quantity);
                    }

                    TransactionItem::create([
                        'transaction_id' => $transaction->transaction_id,
                        'order_type' => 'buy',
                        'order_id' => $buy->buy_id,
                        'amount' => $purchaseTotal + $deliveryFee,
                    ]);
                }

                // Clear cart
                CartItem::where('user_id', Auth::id())->delete();

                // Redirect berdasarkan payment method
                if ($validated['payment_method'] !== 'cash') {
                    return redirect()->route('payment.show', $transaction->transaction_id)
                                   ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
                }

                // For cash payments
                $transaction->update([
                    'payment_status' => 'menunggu_verifikasi',
                    'paid_at' => now()
                ]);

                return redirect()->route('profile.orders')
                   ->with('success', 'Pesanan berhasil dibuat! Silakan tunjukkan bukti ini saat pengambilan di toko.');
            });

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }
}