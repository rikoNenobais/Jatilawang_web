<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'rentals', 'buys']);
        
        // Filter pencarian
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('full_name', 'LIKE', "%{$search}%")
                               ->orWhere('username', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter status pembayaran
        if ($request->has('status') && $request->status) {
            $query->where('payment_status', $request->status);
        }

        // Filter bulan
        if ($request->has('month') && $request->month) {
            $monthYear = explode('-', $request->month);
            if (count($monthYear) == 2) {
                $year = $monthYear[0];
                $month = $monthYear[1];
                $query->whereYear('created_at', $year)
                      ->whereMonth('created_at', $month);
            }
        }

        $transactions = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'rentals.details.item', 'buys.detailBuys.item']);

        return view('admin.transactions.show', compact('transaction'));
    }

    public function verify(Request $request, Transaction $transaction)
    {
        // Update transaction status
        $transaction->update([
            'payment_status' => 'terbayar',
            'paid_at' => now()
        ]);

        // Update SEMUA rental orders dalam transaction ini
        foreach ($transaction->rentals as $rental) {
            $rental->update(['order_status' => 'dikonfirmasi']);
        }

        // Update SEMUA buy orders dalam transaction ini  
        foreach ($transaction->buys as $buy) {
            $buy->update(['order_status' => 'dikonfirmasi']);
        }

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Pembayaran berhasil diverifikasi! Semua pesanan terkait telah dikonfirmasi.');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        $transaction->update([
            'payment_status' => 'gagal',
            'payment_proof' => null // Hapus bukti bayar yang ditolak
        ]);

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Pembayaran ditolak!');
    }

    // METHOD BARU: Cancel Transaction (by Admin)
    public function cancel(Request $request, Transaction $transaction)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        // Validasi: hanya bisa cancel jika status masih menunggu
        if (!in_array($transaction->payment_status, ['menunggu_pembayaran', 'menunggu_verifikasi'])) {
            return redirect()->back()
                ->with('error', 'Tidak bisa membatalkan transaksi yang sudah diproses.');
        }

        DB::transaction(function () use ($transaction, $request) {
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
                'cancelled_by' => 'admin',
                'cancellation_reason' => $request->cancellation_reason
            ]);
        });

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil dibatalkan. Stock produk telah dikembalikan.');
    }
}