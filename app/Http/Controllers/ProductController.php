<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Rating;

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

        if ($request->filled('searchCategory')) {
            $query->where(function ($q) use ($request) {
                $q->where('category', 'like', "%{$request->search}%");
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


    public function reviews($productKey)
    {
        // Cari item berdasarkan item_id atau item_name
        $item = Item::where('item_id', $productKey)
                ->orWhere('item_name', $productKey)
                ->first();

        if (!$item) {
            return response()->json([
                'stats' => ['avg' => 0, 'total' => 0, 'counts' => []],
                'reviews' => ['data' => []]
            ]);
        }

        // Ambil reviews untuk item ini
        $reviews = Rating::with('user')
            ->where('item_id', $item->item_id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik
        $totalReviews = $reviews->count();
        $avgRating = $totalReviews > 0 ? $reviews->avg('rating_value') : 0;
        
        // Hitung distribusi rating
        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = $reviews->where('rating_value', $i)->count();
        }

        return response()->json([
            'stats' => [
                'avg' => round($avgRating, 1),
                'total' => $totalReviews,
                'counts' => $ratingCounts
            ],
            'reviews' => [
                'data' => $reviews->map(function($review) {
                    return [
                        'id' => $review->rating_id,
                        'rating' => $review->rating_value,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at->toISOString(),
                        'user' => [
                            'name' => $review->user->full_name ?? $review->user->username ?? 'User',
                            'email' => $review->user->email
                        ]
                    ];
                })
            ]
        ]);
    }

    // ================== HALAMAN REVIEWS LENGKAP ==================
    public function reviewsPage($item_name)
    {
        // Cari produk
        $product = Item::where('item_name', $item_name)->firstOrFail();

        // Ambil reviews dengan pagination
        $reviews = Rating::with('user')
            ->where('item_id', $product->item_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung statistik
        $totalReviews = Rating::where('item_id', $product->item_id)->count();
        $avgRating = $totalReviews > 0 ? Rating::where('item_id', $product->item_id)->avg('rating_value') : 0;
        
        // Hitung distribusi rating
        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = Rating::where('item_id', $product->item_id)
                                    ->where('rating_value', $i)
                                    ->count();
        }

        $stats = [
            'avg' => round($avgRating, 1),
            'total' => $totalReviews,
            'counts' => $ratingCounts
        ];

        return view('products.reviews', compact('product', 'reviews', 'stats'));
    }

}
