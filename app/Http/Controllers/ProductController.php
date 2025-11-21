<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ================== HOMEPAGE (3 TAB PRODUK) ==================
public function home()
{
    // 1. Terbaru — 8 produk terbaru
    $latest = Item::latest()->take(8)->get();

    // // 2. BESTSELLER — paling banyak disewa + dibeli (fix GROUP BY, pasti jalan!)
    // $bestseller = Item::select('items.*')
    //     ->leftJoin('detail_rentals', 'items.item_id', '=', 'detail_rentals.item_id')
    //     ->leftJoin('detail_buys', 'items.item_id', '=', 'detail_buys.item_id')
    //     ->selectRaw('items.*, 
    //         COALESCE(SUM(detail_rentals.quantity), 0) + COALESCE(SUM(detail_buys.quantity), 0) AS total_sold')
    //     ->groupBy('items.item_id')
    //     ->orderByDesc('total_sold')
    //     ->take(8)
    //     ->get();

    // 3. REKOMENDASI : random aja dari semua item
    $recommended = Item::inRandomOrder()->take(8)->get();

    // return view('home', compact('latest', 'bestseller', 'recommended'));
    return view('home', compact('latest', 'recommended'));
}
    // ================== DAFTAR PRODUK ==================
    public function index(Request $request)
    {
        $items = $this->applyFiltersAndSorting($request);

        $categoryCounts = Item::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('products.index', compact('items', 'categoryCounts'));
    }

    // ================== DETAIL PRODUK ==================
    public function show($item_name)
    {
        // Cari berdasarkan kolom item_id (bukan id!)
        $item = Item::where('item_name', $item_name)->firstOrFail();

        // Produk terkait: kategori sama + item_id beda
        $relatedProducts = Item::where('category', $item->category)
                            ->where('item_id', '!=', $item->item_id)
                            ->inRandomOrder()
                            ->take(6)
                            ->get();

        return view('products.show', compact('item', 'relatedProducts', 'item_name'));
    }

    // ================== FILTER & SORTING (PRIVATE) ==================
    private function applyFiltersAndSorting(Request $request)
    {
        $query = Item::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('item_name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category', $request->categories);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'latest'     => $query->latest('created_at'),
                'price_low'  => $query->orderByRaw('COALESCE(rental_price_per_day, 999999999) ASC'),
                'price_high' => $query->orderByRaw('COALESCE(rental_price_per_day, 0) DESC'),
                'name_asc'   => $query->orderBy('item_name', 'asc'),
                'name_desc'  => $query->orderBy('item_name', 'desc'),
                'popular'    => $query->orderByDesc('rental_stock'),
                default      => $query->latest(),
            };
        } else {
            $query->latest();
        }

        return $query->paginate(20)->withQueryString();
    }
}