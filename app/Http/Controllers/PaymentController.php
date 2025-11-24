<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show()
    {
        // CARI SEMUA ORDER YANG BELUM BAYAR (BUKAN HANYA TERBARU)
        $unpaidRentals = \App\Models\Rental::where('user_id', Auth::id())
            ->where('payment_status', 'menunggu_pembayaran')
            ->whereNull('payment_proof')
            ->where('payment_method', '!=', 'cash')
            ->get();

        $unpaidBuys = \App\Models\Buy::where('user_id', Auth::id())
            ->where('payment_status', 'menunggu_pembayaran')
            ->whereNull('payment_proof')
            ->where('payment_method', '!=', 'cash')
            ->get();

        // JIKA ADA LEBIH DARI 1 ORDER, TAMPILKAN SEMUA
        if ($unpaidRentals->count() > 0 || $unpaidBuys->count() > 0) {
            return view('payment.show', [
                'unpaidRentals' => $unpaidRentals,
                'unpaidBuys' => $unpaidBuys
            ]);
        }

        return redirect()->route('profile.orders')->with('error', 'Tidak ada pesanan yang perlu pembayaran.');
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'order_type' => 'required|in:rental,buy',
            'order_id' => 'required|integer'
        ]);

        // Store payment proof
        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Update order with payment proof
        if ($request->order_type === 'rental') {
            $order = \App\Models\Rental::where('rental_id', $request->order_id)
                                     ->where('user_id', Auth::id())
                                     ->firstOrFail();
        } else {
            $order = \App\Models\Buy::where('buy_id', $request->order_id)
                                  ->where('user_id', Auth::id())
                                  ->firstOrFail();
        }

        $order->update([
            'payment_proof' => $proofPath,
            'payment_status' => 'menunggu_pembayaran'
        ]);

        return redirect()->route('profile.orders')
                       ->with('success', 'Bukti pembayaran berhasil diupload! Mohon menunggu verifikasi admin.');
    }
}