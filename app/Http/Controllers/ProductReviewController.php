<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function index(Request $request, $productKey)
    {
        $reviews = Review::with('user')
            ->where('product_key', $productKey)
            ->orderByDesc('created_at')
            ->paginate(6);

        $statsQuery = Review::where('product_key', $productKey);
        $avg = round($statsQuery->avg('rating') ?: 0, 1);
        $counts = $statsQuery->selectRaw('rating, count(*) as cnt')->groupBy('rating')->pluck('cnt','rating')->toArray();
        $countsNormalized = [1=>0,2=>0,3=>0,4=>0,5=>0];
        foreach ($counts as $r => $c) $countsNormalized[$r] = $c;

        return response()->json([
            'reviews' => $reviews,
            'stats' => [
                'avg' => $avg,
                'counts' => $countsNormalized,
                'total' => $reviews->total(),
            ],
        ]);
    }

    public function store(Request $request, $productKey)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        // Optional: ownership verification (not implemented here)
        // If you have rentals/orders table, check that user has rented/bought this product.

        $existing = Review::where('user_id', $user->id)->where('product_key', $productKey)->first();
        if ($existing) {
            return response()->json(['message' => 'You have already reviewed this product'], 422);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_key' => $productKey,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'verified' => false,
        ]);

        return response()->json(['message' => 'OK', 'review' => $review], 201);
    }
}
