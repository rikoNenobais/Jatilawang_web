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


        // ========== FILTER SEWA/BELI (CHECKBOX) ==========
        $hasSewa = $request->boolean('sewa');
        $hasBeli = $request->boolean('beli');

        if ($hasSewa && $hasBeli) {
            // Tampilkan yang bisa sewa ATAU beli
            $query->where(function ($q) {
                $q->where('is_rentable', true)->where('rental_stock', '>', 0)
                ->orWhere('is_sellable', true)->where('sale_stock', '>', 0);
            });
        } 
        elseif ($hasSewa) {
            // Hanya yang bisa disewa
            $query->where('is_rentable', true)
                ->where('rental_stock', '>', 0);
        } 
        elseif ($hasBeli) {
            // Hanya yang bisa dibeli
            $query->where('is_sellable', true)
                ->where('sale_stock', '>', 0);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'latest'     => $query->latest('created_at'),
                'price_low_rent'  => $query->orderByRaw('COALESCE(rental_price_per_day, 999999999) ASC'),
                'price_high_rent' => $query->orderByRaw('COALESCE(rental_price_per_day, 0) DESC'),
                'price_low_buy'  => $query->orderByRaw('COALESCE(sale_price, 999999999) ASC'),
                'price_high_uy' => $query->orderByRaw('COALESCE(sale_price, 0) DESC'),
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


    // public function showArray($item_id)
    // {
    //     // ambil item berdasarkan item_id
    //     $item = Item::where('item_id', $item_id)->firstOrFail();

    //     // mapping ke struktur yang dipakai di Blade sebagai $product
    //     $product = [
    //         'id'            => $item->item_id,
    //         'slug'          => (string) $item->item_id,
    //         'name'          => $item->item_name,
    //         'price'         => $item->rental_price_per_day, // bisa kamu format di Blade
    //         'numeric_price' => (int) ($item->rental_price_per_day ?? 0),
    //         'img_url'       => $item->url_image,
    //         'desc'          => $item->description,
    //         'material'      => $item->material ?? null,  // kalau kolom nggak ada, akan null dan aman
    //         'stock'         => $item->rental_stock ?? 0,
    //         'category'      => $item->category ?? null,
    //     ];

    //     // kalau view kamu juga butuh data produk terkait, bisa ditambah di sini nanti

    //     return view('products.show', compact('product', 'item'));
    // }

}
