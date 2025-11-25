<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with('user', 'details.item');
        
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('rental_id', 'LIKE', "%{$search}%")
                  ->orWhere('user_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('full_name', 'LIKE', "%{$search}%")
                               ->orWhere('username', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('order_status', $request->status);
        }

        $rentals = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.rentals.index', compact('rentals'));
    }

   public function show(Rental $rental)
    {
        $rental->load('user', 'details.item'); 
        
        $denda = $this->hitungDenda($rental);
        $totalBayar = ($rental->total_price ?? 0) + $denda;

        return view('admin.rentals.show', compact('rental', 'denda', 'totalBayar'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'return_date' => ['nullable', 'date'],
            'total_price' => ['nullable', 'numeric', 'min:0'],
            'order_status' => ['required', 'in:menunggu_verifikasi,dikonfirmasi,sedang_berjalan,selesai,dibatalkan'],
        ]);

        $rental->update($validated);

        return redirect()
            ->route('admin.rentals.show', $rental)
            ->with('success', 'Data rental berhasil diperbarui.');
    }

    public function updateDenda(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'penalty' => ['required', 'numeric', 'min:0'],
        ]);

        foreach ($rental->details as $detail) {
            $detail->update(['penalty' => $validated['penalty']]);
        }

        return redirect()
            ->route('admin.rentals.show', $rental)
            ->with('success', 'Denda berhasil diperbarui.');
    }

    private function hitungDenda(Rental $rental): float
    {
        $denda = 0;
        
        if ($rental->return_date) {
            return $rental->details->sum('penalty');
        }

        $hariIni = Carbon::today();
        $tenggat = Carbon::parse($rental->rental_end_date);

        if ($rental->order_status === 'sedang_berjalan' && $hariIni->gt($tenggat)) {
            $hariTerlambat = $hariIni->diffInDays($tenggat);
            $dendaPerHari = ($rental->total_price ?? 0) * 0.1;
            $denda = $hariTerlambat * $dendaPerHari;
        }

        return $denda;
    }
}