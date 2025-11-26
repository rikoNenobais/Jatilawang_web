<?php
// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function cancel(Request $request, Transaction $transaction)
    {
        // Validasi: hanya customer pemilik yang bisa cancel
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        // Validasi: hanya bisa cancel jika status masih menunggu
        if (!in_array($transaction->payment_status, ['menunggu_pembayaran', 'menunggu_verifikasi'])) {
            return redirect()->back()
                ->with('error', 'Tidak bisa membatalkan transaksi yang sudah diproses.');
        }

        DB::transaction(function () use ($transaction) {
            // Kembalikan stock untuk semua items
            foreach ($transaction->rentals as $rental) {
                foreach ($rental->details as $detail) {
                    $detail->item->increment('rental_stock', $detail->quantity);
                }
                $rental->update(['order_status' => 'dibatalkan']);
            }

            foreach ($transaction->buys as $buy) {
                foreach ($buy->detailBuys as $detail) {
                    $detail->item->increment('sale_stock', $detail->quantity);
                }
                $buy->update(['order_status' => 'dibatalkan']);
            }

            // Update status transaction
            $transaction->update([
                'payment_status' => 'dibatalkan',
                'cancelled_at' => now(),
                'cancelled_by' => 'customer',
                'cancellation_reason' => 'Dibatalkan oleh customer'
            ]);
        });

        return redirect()->route('profile.orders')
            ->with('success', 'Transaksi berhasil dibatalkan. Stock produk telah dikembalikan.');
    }
}