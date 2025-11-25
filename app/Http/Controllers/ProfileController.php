<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Transaction;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Kata sandi tidak valid']);
        }

        // Set session untuk izinkan edit
        session(['profile_edit_allowed' => true]);
        
        // Debug: log session
        \Illuminate\Support\Facades\Log::info('Profile edit allowed - Session set for user: ' . $user->user_id);

        // Redirect ke form edit - PASTIKAN route name benar
        return redirect()->route('profile.edit.form');
    }

    public function showEditForm()
    {
        \Illuminate\Support\Facades\Log::info('Accessing showEditForm - Session data:', session()->all());
        
        if (!session('profile_edit_allowed')) {
            \Illuminate\Support\Facades\Log::warning('Profile edit not allowed - redirecting to profile.edit');
            return redirect()->route('profile.edit')->withErrors(['password' => 'Silakan verifikasi kata sandi terlebih dahulu']);
        }

        $user = Auth::user();
        \Illuminate\Support\Facades\Log::info('Showing edit form for user: ' . $user->user_id);
        return view('profile.update', compact('user'));
    }

    public function update(Request $request)
    {
        if (!session('profile_edit_allowed')) {
            return redirect()->route('profile.edit')->withErrors(['password' => 'Sesi edit telah berakhir. Silakan verifikasi ulang.']);
        }

        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->user_id . ',user_id',
            'email' => 'nullable|email|max:100',
            'full_name' => 'nullable|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($validated);

        // Clear session setelah update berhasil
        session()->forget('profile_edit_allowed');

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    // Tampilkan form ubah password
    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    // Proses update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

         /** @var User $user */
        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak valid.']);
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah!');
    }

    public function orders()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Ambil transactions user dengan relasi rentals dan buys
        $transactions = Transaction::with(['rentals', 'buys'])
            ->where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.orders', compact('transactions'));
    }
}