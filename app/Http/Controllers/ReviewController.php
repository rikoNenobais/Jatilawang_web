<?php
// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Rental;
use App\Models\Buy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function create($type, $id)
    {
        $user = Auth::user();
        
        // Validasi type
        if (!in_array($type, ['rental', 'buy'])) {
            abort(404);
        }
        
        if ($type === 'rental') {
            $order = Rental::with(['details.item', 'transaction'])
                        ->findOrFail($id);
            
            // Validasi: hanya bisa review jika status selesai dan user pemilik
            if ($order->order_status !== 'selesai' || $order->user_id !== $user->user_id) {
                abort(403, 'Anda tidak memiliki akses untuk mereview pesanan ini.');
            }
        } else {
            $order = Buy::with(['detailBuys.item', 'transaction'])
                      ->findOrFail($id);
            
            if ($order->order_status !== 'selesai' || $order->user_id !== $user->user_id) {
                abort(403, 'Anda tidak memiliki akses untuk mereview pesanan ini.');
            }
        }

        return view('reviews.create', compact('order', 'type'));
    }

    public function store(Request $request, $type, $id)
    {
        $user = Auth::user();
        
        // Validasi type
        if (!in_array($type, ['rental', 'buy'])) {
            abort(404);
        }
        
        // Cari order berdasarkan type
        if ($type === 'rental') {
            $order = Rental::with('transaction')->findOrFail($id);
        } else {
            $order = Buy::with('transaction')->findOrFail($id);
        }

        // Validasi ownership dan status
        if ($order->order_status !== 'selesai' || $order->user_id !== $user->user_id) {
            abort(403, 'Pesanan belum selesai atau Anda bukan pemilik pesanan.');
        }

        // Validasi input
        $request->validate([
            'item_id' => 'required|exists:items,item_id',
            'rating_value' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500'
        ]);

        // Cek apakah sudah pernah review item ini di order yang sama
        $existingReview = Rating::where('user_id', $user->user_id)
            ->where('item_id', $request->item_id)
            ->where(function($query) use ($type, $id) {
                if ($type === 'rental') {
                    $query->where('rental_id', $id);
                } else {
                    $query->where('buy_id', $id);
                }
            })
            ->first();

        if ($existingReview) {
            return back()
                ->withInput()
                ->withErrors(['rating_value' => 'Anda sudah memberikan review untuk produk ini pada pesanan yang sama.']);
        }

        // Gunakan transaction database untuk keamanan data
        DB::beginTransaction();
        
        try {
            // Simpan review
            $rating = Rating::create([
                'user_id' => $user->user_id,
                'item_id' => $request->item_id,
                'rental_id' => $type === 'rental' ? $id : null,
                'buy_id' => $type === 'buy' ? $id : null,
                'transaction_id' => $order->transaction_id, // Pastikan transaction_id tersedia
                'rating_value' => $request->rating_value,
                'comment' => $request->comment
            ]);

            DB::commit();

            return redirect()
                ->route('profile.orders')
                ->with('success', 'Review berhasil dikirim! Terima kasih atas feedback Anda.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi.']);
        }
    }

    // Method untuk update review jika diperlukan
    public function update(Request $request, $ratingId)
    {
        $user = Auth::user();
        
        $rating = Rating::where('user_id', $user->user_id)
            ->findOrFail($ratingId);

        $request->validate([
            'rating_value' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500'
        ]);

        $rating->update([
            'rating_value' => $request->rating_value,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Review berhasil diperbarui!');
    }

    // Method untuk delete review
    public function destroy($ratingId)
    {
        $user = Auth::user();
        
        $rating = Rating::where('user_id', $user->user_id)
            ->findOrFail($ratingId);

        $rating->delete();

        return back()->with('success', 'Review berhasil dihapus!');
    }
}