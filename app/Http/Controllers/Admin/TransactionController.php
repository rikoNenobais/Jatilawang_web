<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
}