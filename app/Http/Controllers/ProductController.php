<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->applyFiltersAndSorting($request);

        $categoryCounts = Item::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('products.index', compact('items', 'categoryCounts'));
    }


    private function applyFiltersAndSorting(Request $request)
    {
        $query = Item::query();

        // SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('item_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
                });
        }

        // FILTER KATEGORI
        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category', $request->categories);
        }

        // REKOMENDASI
        if ($request->has('recommended')) {
            $query->where('is_rentable', true)
                  ->orderByDesc('rental_stock');
        }

        // SORTING — SEMUA DI SINI, MUDAH DITAMBAH!
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->latest('created_at');
                    break;
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
                case 'popular':
                    $query->orderByDesc('rental_stock'); // nanti bisa diganti total_order
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest(); // default
        }

        return $query->paginate(20)->withQueryString();
    }

    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('products.show', compact('item'));
    }
}