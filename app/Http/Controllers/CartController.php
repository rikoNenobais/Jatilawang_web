<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('item')
            ->where('user_id', Auth::id())
            ->get();

        // Pisahkan items berdasarkan type
        $rentalItems = $cartItems->filter(function ($item) {
            return $item->isRental();
        });
        
        $purchaseItems = $cartItems->filter(function ($item) {
            return $item->isPurchase();
        });

        // Hitung subtotal per kategori
        $rentalSubtotal = $rentalItems->sum(function ($cartItem) {
            return $cartItem->total_price;
        });
        
        $purchaseSubtotal = $purchaseItems->sum(function ($cartItem) {
            return $cartItem->total_price;
        });

        $totalSubtotal = $rentalSubtotal + $purchaseSubtotal;

        return view('cart.index', [
            'rentalItems' => $rentalItems,
            'purchaseItems' => $purchaseItems,
            'rentalSubtotal' => $rentalSubtotal,
            'purchaseSubtotal' => $purchaseSubtotal,
            'totalSubtotal' => $totalSubtotal,
            'totalItems' => $cartItems->sum('quantity'),
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menambahkan produk ke keranjang.');
        }

        $data = $request->validate([
            'item_id' => ['required', 'exists:items,item_id'],
            'type' => ['required', 'in:rent,buy'],
            'quantity' => ['required', 'integer', 'min:1'],
            'days' => ['nullable', 'integer', 'min:1']
        ]);

        $quantity = (int) $data['quantity'];
        $type = $data['type'];

        // Check item availability
        $item = Item::find($data['item_id']);
        
        if ($type === 'rent' && (!$item->is_rentable || $item->rental_stock < $quantity)) {
            return back()->with('error', 'Stok sewa tidak mencukupi atau produk tidak dapat disewa.');
        }

        if ($type === 'buy' && (!$item->is_sellable || $item->sale_stock < $quantity)) {
            return back()->with('error', 'Stok penjualan tidak mencukupi atau produk tidak dapat dibeli.');
        }

        // Create or update cart item
        CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $data['item_id'],
                'type' => $type
            ],
            [
                'quantity' => $quantity,
                'days' => $type === 'rent' ? (int) ($data['days'] ?? 1) : null
            ]
        );

        $typeLabel = $type === 'rent' ? 'disewa' : 'dibeli';
        return back()->with('success', "Produk berhasil ditambahkan ke keranjang ($typeLabel).");
    }

    public function update(Request $request, $cart_item_id)
    {
        $cartItem = CartItem::findOrFail($cart_item_id);
        
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'days' => ['nullable', 'integer', 'min:1']
        ]);

        // Check stock
        $item = $cartItem->item;
        $newQuantity = (int) $data['quantity'];

        if ($cartItem->isRental() && $item->rental_stock < $newQuantity) {
            return back()->with('error', 'Stok sewa tidak mencukupi.');
        }

        if ($cartItem->isPurchase() && $item->sale_stock < $newQuantity) {
            return back()->with('error', 'Stok penjualan tidak mencukupi.');
        }

        // Update
        $cartItem->update([
            'quantity' => $newQuantity,
            'days' => $cartItem->isRental() ? (int) ($data['days'] ?? $cartItem->days) : null
        ]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy($cart_item_id)
    {
        $cartItem = CartItem::findOrFail($cart_item_id);
        
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}