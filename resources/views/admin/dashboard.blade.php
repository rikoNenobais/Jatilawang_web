@extends('layouts.layout-admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard Admin')

@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Peminjaman --}}
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-sm border border-blue-100 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/5 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Total Peminjaman</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalRentals ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center text-white text-lg shadow-lg">
                    📦
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-blue-100">
                <p class="text-xs text-blue-600/80">
                    Semua transaksi peminjaman
                </p>
            </div>
        </div>

        {{-- Total Produk --}}
        <div class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-sm border border-emerald-100 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-500/5 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">Total Produk</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalItems ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500 flex items-center justify-center text-white text-lg shadow-lg">
                    🎒
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-emerald-100">
                <p class="text-xs text-emerald-600/80">
                    Item perlengkapan aktif
                </p>
            </div>
        </div>

        {{-- Total Pengguna --}}
        <div class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-sm border border-purple-100 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-purple-500/5 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-purple-600 uppercase tracking-wide">Total Pengguna</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-500 flex items-center justify-center text-white text-lg shadow-lg">
                    👤
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-purple-100">
                <p class="text-xs text-purple-600/80">
                    Akun terdaftar
                </p>
            </div>
        </div>

        {{-- Total Review --}}
        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-sm border border-amber-100 p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-amber-500/5 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-amber-600 uppercase tracking-wide">Total Review</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalReviews ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500 flex items-center justify-center text-white text-lg shadow-lg">
                    ⭐
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-amber-100">
                <p class="text-xs text-amber-600/80">
                    Feedback pengguna
                </p>
            </div>
        </div>
    </div>

    {{-- Pendapatan --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Pendapatan Rental --}}
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                        <span class="text-lg">💰</span>
                    </div>
                    <p class="text-sm font-semibold text-blue-100 uppercase tracking-wide">Pendapatan Sewa</p>
                </div>
                <p class="text-2xl font-bold mb-2">Rp {{ number_format($totalRevenueRentals ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-blue-100/80">
                    Dari transaksi yang sudah terverifikasi
                </p>
            </div>
        </div>

        {{-- Pendapatan Beli --}}
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                        <span class="text-lg">🛒</span>
                    </div>
                    <p class="text-sm font-semibold text-green-100 uppercase tracking-wide">Pendapatan Beli</p>
                </div>
                <p class="text-2xl font-bold mb-2">Rp {{ number_format($totalRevenueBuy ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-green-100/80">
                    Dari transaksi yang sudah terverifikasi
                </p>
            </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                        <span class="text-lg">📊</span>
                    </div>
                    <p class="text-sm font-semibold text-purple-100 uppercase tracking-wide">Total Pendapatan</p>
                </div>
                <p class="text-3xl font-bold mb-2">Rp {{ number_format($totalProfit ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-purple-100/80">
                    Total sewa + beli yang terverifikasi
                </p>
            </div>
        </div>
    </div>

    {{-- Info Panel --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Welcome Card --}}
        <div class="bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl text-white p-6 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-20 translate-x-20"></div>
            <div class="relative z-10">
                <h3 class="font-bold text-lg mb-2">🎉 Selamat datang di dashboard admin!</h3>
                <p class="text-indigo-100 text-sm leading-relaxed">
                    Pantau statistik utama seperti peminjaman, produk, pengguna, dan review dari satu tempat.
                    Gunakan menu navigasi untuk mengelola data lebih detail dan memantau performa bisnis.
                </p>
            </div>
        </div>

        {{-- Quick Tips --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                Tips Cepat & Best Practices
            </h4>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold mt-0.5">
                        1
                    </div>
                    <p class="text-sm text-gray-600 flex-1">
                        <strong>Cek stok produk</strong> secara berkala di menu Produk untuk antisipasi high season
                    </p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xs font-bold mt-0.5">
                        2
                    </div>
                    <p class="text-sm text-gray-600 flex-1">
                        <strong>Monitor peminjaman aktif</strong> untuk memastikan pengembalian tepat waktu
                    </p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 text-xs font-bold mt-0.5">
                        3
                    </div>
                    <p class="text-sm text-gray-600 flex-1">
                        <strong>Review feedback pengguna</strong> untuk terus meningkatkan kualitas layanan
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Peminjaman Terbaru --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                Peminjaman Terbaru (Terverifikasi)
            </h3>
            <a href="{{ route('admin.rentals.index') }}"
               class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1 transition-colors">
                Lihat semua 
                <span class="text-lg">→</span>
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table class="w-full text-sm">
                <thead>
                <tr class="bg-gray-50/80 border-b border-gray-100">
                    <th class="text-left py-4 px-4 font-semibold text-gray-600 text-xs uppercase tracking-wide">ID</th>
                    <th class="text-left py-4 px-4 font-semibold text-gray-600 text-xs uppercase tracking-wide">User</th>
                    <th class="text-left py-4 px-4 font-semibold text-gray-600 text-xs uppercase tracking-wide">Mulai</th>
                    <th class="text-left py-4 px-4 font-semibold text-gray-600 text-xs uppercase tracking-wide">Selesai</th>
                    <th class="text-left py-4 px-4 font-semibold text-gray-600 text-xs uppercase tracking-wide">Total</th>
                    <th class="text-left py-4 px-4 font-semibold text-gray-600 text-xs uppercase tracking-wide">Status</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($latestRentals as $rental)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="py-4 px-4">
                            <span class="font-medium text-gray-900">#{{ $rental->rental_id }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold">
                                    {{ substr($rental->user->full_name ?? $rental->user->username ?? 'U', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-800">
                                    {{ $rental->user->full_name ?? $rental->user->username ?? 'User #'.$rental->user_id }}
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-gray-600">
                            {{ $rental->rental_start_date
                                ? Carbon::parse($rental->rental_start_date)->format('d M Y')
                                : '-' }}
                        </td>
                        <td class="py-4 px-4 text-gray-600">
                            {{ $rental->rental_end_date
                                ? Carbon::parse($rental->rental_end_date)->format('d M Y')
                                : '-' }}
                        </td>
                        <td class="py-4 px-4">
                            <span class="font-bold text-gray-900">
                                Rp {{ number_format($rental->total_price ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Terverifikasi
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <span class="text-4xl mb-2">📭</span>
                                <p class="text-sm font-medium">Belum ada data peminjaman</p>
                                <p class="text-xs mt-1">Data peminjaman yang terverifikasi akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection