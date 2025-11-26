<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Rating::with(['user', 'item', 'rental', 'buy', 'transaction'])
            ->orderByDesc('created_at');

        // Filter pencarian
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('full_name', 'like', "%{$search}%")
                             ->orWhere('username', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('item', function($itemQuery) use ($search) {
                    $itemQuery->where('item_name', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        // Hanya filter rating saja (hapus filter verified)
        if ($request->has('rating') && $request->rating) {
            $query->where('rating_value', $request->rating);
        }

        $reviews = $query->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Rating $rating)
    {
        $rating->load([
            'user', 
            'item', 
            'rental.details.item', 
            'buy.detailBuys.item', 
            'transaction'
        ]);
        
        return view('admin.reviews.show', compact('rating'));
    }

    public function destroy(Rating $review)
    {
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review berhasil dihapus.');
    }
}