<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this import for authentication checks

class CartController extends Controller
{
    // KEY session untuk cart
    private const SESSION_KEY = 'cart.items'; // bentuk: [item_id => qty]

    /**
     * Tampilkan isi keranjang (dari session).
     */
    public function index()
    {
        $items = collect(session(self::SESSION_KEY, [])); // [id => qty]
        $dbItems = Item::whereIn('item_id', $items->keys())
            ->get()
            ->keyBy('item_id');

        // susun baris yang siap dipakai di view
        $rows = $items->map(function ($qty, $itemId) use ($dbItems) {
            $p = $dbItems->get($itemId);
            if (!$p) return null;

            return [
                'product' => $p,
                'qty'     => (int) $qty,
                'price'   => (int) ($p->rental_price_per_day ?? 0),
                'total'   => (int) ($p->rental_price_per_day ?? 0) * (int) $qty,
            ];
        })->filter(); // buang null bila ada id yang tidak ditemukan

        $subtotal = (int) $rows->sum('total');

        return view('cart.index', [
            'rows'     => $rows,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Tambah produk ke keranjang (session).
     */
    public function store(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menambahkan produk ke keranjang.');
        }

        $data = $request->validate([
            'item_id' => ['required', 'exists:items,item_id'],
            'qty'        => ['nullable', 'integer', 'min:1'],
        ]);
        $qty = (int) ($data['qty'] ?? 1);

        $items = collect(session(self::SESSION_KEY, []));
        $items[$data['item_id']] = ($items[$data['item_id']] ?? 0) + $qty;

        session([self::SESSION_KEY => $items->toArray()]);

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    /**
     * Ubah jumlah (qty) item tertentu.
     * Route: PATCH /cart/{product}
     */
    public function update(Request $request, Item $item)
    {
        $qty = (int) $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ])['qty'];

        $items = collect(session(self::SESSION_KEY, []));
        if ($items->has($item->item_id)) {
            $items[$item->item_id] = $qty;
            session([self::SESSION_KEY => $items->toArray()]);
        }

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    /**
     * Hapus satu item dari keranjang.
     * Route: DELETE /cart/{product}
     */
    public function destroy(Item $item)
    {
        $items = collect(session(self::SESSION_KEY, []));
        $items->forget($item->item_id);
        session([self::SESSION_KEY => $items->toArray()]);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
