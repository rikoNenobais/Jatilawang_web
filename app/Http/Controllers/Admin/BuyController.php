<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buy;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BuyController extends Controller
{
    public function index(Request $request)
    {
        $query = Buy::with('user', 'detailBuys.item');
        
        // Filter pencarian
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('buy_id', 'LIKE', "%{$search}%")
                  ->orWhere('user_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('full_name', 'LIKE', "%{$search}%")
                               ->orWhere('username', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter status
        if ($request->has('status') && $request->status) {
            $query->where('order_status', $request->status);
        }

        $buys = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.buys.index', compact('buys'));
    }

    public function show(Buy $buy)
    {
        $buy->load('user', 'detailBuys.item');

        return view('admin.buys.show', compact('buy'));
    }

    public function update(Request $request, Buy $buy)
{
    $validated = $request->validate([
        'order_status' => ['required', 'in:menunggu_verifikasi,dikonfirmasi,diproses,dikirim,selesai,dibatalkan'],
        'shipping_address' => ['nullable', 'string'],
    ]);

    $buy->update($validated);

    return redirect()
        ->route('admin.buys.show', $buy)
        ->with('success', 'Data pembelian berhasil diperbarui.');
}
}