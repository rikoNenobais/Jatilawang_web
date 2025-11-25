<?php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show($transactionId)
    {
        $transaction = Transaction::with(['rentals', 'buys', 'user'])
            ->where('transaction_id', $transactionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Pastikan transaction masih menunggu pembayaran
        if ($transaction->payment_status !== 'menunggu_pembayaran') {
            return redirect()->route('profile.orders')
                           ->with('error', 'Transaksi ini sudah diproses.');
        }

        return view('payment.show', compact('transaction'));
    }

    public function uploadProof(Request $request, $transactionId)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $transaction = Transaction::where('transaction_id', $transactionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Store payment proof
        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Update transaction
        $transaction->update([
            'payment_proof' => $proofPath,
            'payment_status' => 'menunggu_verifikasi'
        ]);

        return redirect()->route('profile.orders')
                       ->with('success', 'Bukti pembayaran berhasil diupload! Mohon menunggu verifikasi admin.');
    }

    // METHOD LAMA untuk backward compatibility (optional)
    public function showOld()
    {
        // Redirect ke halaman orders kalau ada yang akses route lama
        return redirect()->route('profile.orders')
                       ->with('info', 'Silakan buat pesanan baru untuk melakukan pembayaran.');
    }
}