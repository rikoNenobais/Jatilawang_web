<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Rental;
use App\Models\DetailRental;
use App\Models\Buy;
use App\Models\DetailBuy; // PASTIKAN INI YANG DIGUNAKAN
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

        return view('checkout.show', compact(
            'rentalItems',
            'purchaseItems', 
            'hasRentalItems',
            'hasPurchaseItems',
            'totalAmount'
        ));
    }

    // Process checkout
    public function process(Request $request)
    {
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

            if ($hasRental) {
                $validationRules['identity_type'] = 'required|in:ktp,ktm,sim';
                $validationRules['identity_file'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
            }

            $validated = $request->validate($validationRules);

            // Calculate delivery fee - Rp 18.000 untuk semua area Jogja
            $deliveryFee = $validated['delivery_option'] === 'delivery' ? 18000 : 0;

            // Process file upload for rental
            $identityPath = null;
            if ($hasRental && $request->hasFile('identity_file')) {
                $identityPath = $request->file('identity_file')->store('identities', 'public');
            }

            $latestRental = null;
            $latestBuy = null;

           // ========== PROCESS RENTAL ITEMS ==========
            if ($hasRental) {
                $rentalTotal = $rentalItems->sum(function($item) {
                    return $item->total_price;
                }) + $deliveryFee;

                // Calculate rental dates
                $startDate = now();
                $endDate = now()->addDays($rentalItems->max('days') ?? 1);

                // Create rental record
                $rental = Rental::create([
                    'user_id' => Auth::id(),
                    'rental_start_date' => $startDate,
                    'rental_end_date' => $endDate,
                    'total_price' => $rentalTotal,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'menunggu_pembayaran',
                    'order_status' => 'menunggu_verifikasi',
                    'delivery_option' => $validated['delivery_option'],
                    'identity_file' => $identityPath,
                    'identity_type' => $validated['identity_type'],
                    'shipping_address' => $validated['shipping_address'] ?? null,
                ]);

                $latestRental = $rental;

                // Create rental details - SESUAI MODEL (TIDAK ADA DAYS)
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
            }

            // ========== PROCESS PURCHASE ITEMS ==========
            if ($hasPurchase) {
                $purchaseTotal = $purchaseItems->sum(function($item) {
                    return $item->total_price;
                }) + $deliveryFee;

                // Create buy record
                $buy = Buy::create([
                    'user_id' => Auth::id(),
                    'total_price' => $purchaseTotal,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'menunggu_pembayaran',
                    'order_status' => 'menunggu_verifikasi',
                    'delivery_option' => $validated['delivery_option'],
                    'shipping_address' => $validated['shipping_address'] ?? null,
                ]);

                $latestBuy = $buy;

                // Create buy details and update stock - GUNAKAN DETAILBUY BUKAN DETAILORDER
                foreach ($purchaseItems as $cartItem) {
                    DetailBuy::create([
                        'buy_id' => $buy->buy_id,
                        'item_id' => $cartItem->item_id,
                        'quantity' => $cartItem->quantity,
                        'total_price' => $cartItem->total_price,
                    ]);

                    // Update sale stock
                    $cartItem->item->decrement('sale_stock', $cartItem->quantity);
                }
            }

            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();

            // Redirect to payment page for non-cash payments
            if ($validated['payment_method'] !== 'cash') {
                // Store order info in session for payment page
                session([
                    'latest_rental' => $latestRental,
                    'latest_buy' => $latestBuy
                ]);

                return redirect()->route('payment.show')
                               ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
            }

            // For cash payments, show success message
            return redirect()->route('profile.orders')
               ->with('success', 'Pesanan berhasil dibuat! Silakan tunjukkan bukti ini saat pengambilan di toko.');
        });
    }
}