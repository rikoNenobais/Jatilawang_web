<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        $query = Item::query();

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->get('category')) {
            $query->where('category', 'like', "%{$category}%");
        }

        $sort = $request->get('sort', 'latest');

        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(rental_price_per_day, 999999999) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(rental_price_per_day, 0) DESC');
                break;
            case 'name_asc':
                $query->orderBy('item_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('item_name', 'desc');
                break;
            case 'id_asc':
                $query->orderBy('item_id', 'asc');
                break;
            case 'latest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $items = $query->paginate(20)->withQueryString();

        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'             => ['required', 'integer', 'min:1', 'max:65535', 'unique:items,item_id'],
            'item_name'           => ['required', 'string', 'max:100'],
            'description'         => ['nullable', 'string'],
            'category'            => ['nullable', 'string', 'max:20'],
            'url_image'           => ['nullable', 'url', 'max:255'],
            'rental_price_per_day'=> ['nullable', 'numeric', 'min:0'],
            'sale_price'          => ['nullable', 'numeric', 'min:0'],
            'rental_stock'        => ['nullable', 'integer', 'min:0', 'max:255'],
            'sale_stock'          => ['nullable', 'integer', 'min:0', 'max:255'],
            'penalty_per_days'    => ['nullable', 'numeric', 'min:0'],
            'is_rentable'         => ['required', 'boolean'],
            'is_sellable'         => ['required', 'boolean'],
        ]);

        $item = new Item();
        $item->item_id              = $validated['item_id']; // primary key manual
        $item->item_name            = $validated['item_name'];
        $item->description          = $validated['description'] ?? null;
        $item->category             = $validated['category'] ?? null;
        $item->url_image            = $validated['url_image'] ?? null;
        $item->rental_price_per_day = $validated['rental_price_per_day'] ?? null;
        $item->sale_price           = $validated['sale_price'] ?? null;
        $item->rental_stock         = $validated['rental_stock'] ?? 0;
        $item->sale_stock           = $validated['sale_stock'] ?? 0;
        $item->penalty_per_days     = $validated['penalty_per_days'] ?? 0;
        $item->is_rentable          = $validated['is_rentable'];
        $item->is_sellable          = $validated['is_sellable'];
        $item->save();

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'item_name'           => ['required', 'string', 'max:100'],
            'description'         => ['nullable', 'string'],
            'category'            => ['nullable', 'string', 'max:20'],
            'url_image'           => ['nullable', 'url', 'max:255'],
            'rental_price_per_day'=> ['nullable', 'numeric', 'min:0'],
            'sale_price'          => ['nullable', 'numeric', 'min:0'],
            'rental_stock'        => ['nullable', 'integer', 'min:0', 'max:255'],
            'sale_stock'          => ['nullable', 'integer', 'min:0', 'max:255'],
            'penalty_per_days'    => ['nullable', 'numeric', 'min:0'],
            'is_rentable'         => ['required', 'boolean'],
            'is_sellable'         => ['required', 'boolean'],
        ]);

        $validated['rental_stock'] = $validated['rental_stock'] ?? 0;
        $validated['sale_stock'] = $validated['sale_stock'] ?? 0;
        $validated['penalty_per_days'] = $validated['penalty_per_days'] ?? 0;

        $validated['rental_price_per_day'] = $validated['rental_price_per_day'] ?? null;
        $validated['sale_price'] = $validated['sale_price'] ?? null;

        $item->update($validated);

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
