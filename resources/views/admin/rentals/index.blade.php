@extends('layouts.layout-admin')

@section('title', 'Peminjaman')
@section('header', 'Manajemen Peminjaman')

@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
    <div class="mb-6 flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Peminjaman</h1>
            <p class="text-sm text-gray-600 mt-1">Kelola semua transaksi peminjaman perlengkapan outdoor</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
            <form method="GET" class="flex gap-2 flex-1 lg:flex-none">
                <div class="relative flex-1 lg:w-64">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari ID / Nama / Email..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
                <button
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
            </form>

            <select 
                name="status" 
                onchange="window.location.href = this.value ? '{{ request()->url() }}?status=' + this.value : '{{ request()->url() }}'"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
                <option value="">Semua Status</option>
                <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="sedang_berjalan" {{ request('status') == 'sedang_berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        @php
            $stats = [
                'total' => App\Models\Rental::count(),
                'pending' => App\Models\Rental::where('order_status', 'menunggu_verifikasi')->count(),
                'active' => App\Models\Rental::where('order_status', 'sedang_berjalan')->count(),
                'completed' => App\Models\Rental::where('order_status', 'selesai')->count(),
            ];
        @endphp
        
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sedang Berjalan</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['active'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">ID Rental</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">Customer</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">Periode</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">Total + Denda</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">Status Order</th>
                    <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">Status Bayar</th>
                    <th class="text-right py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse($rentals as $rental)
                    @php
                        $denda = 0;
                        $hariIni = Carbon::today();
                        $tenggat = Carbon::parse($rental->rental_end_date);
                        
                        if (!$rental->return_date && $hariIni->gt($tenggat)) {
                            $hariTerlambat = $hariIni->diffInDays($tenggat);
                            $dendaPerHari = ($rental->total_price ?? 0) * 0.1;
                            $denda = $hariTerlambat * $dendaPerHari;
                        }

                        $totalDenda = $rental->details->sum('penalty') + $denda;
                        $totalBayar = ($rental->total_price ?? 0) + $totalDenda;

                        $statusColors = [
                            'menunggu_verifikasi' => 'bg-orange-100 text-orange-800 border-orange-200',
                            'dikonfirmasi' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'sedang_berjalan' => 'bg-purple-100 text-purple-800 border-purple-200',
                            'selesai' => 'bg-green-100 text-green-800 border-green-200',
                            'dibatalkan' => 'bg-red-100 text-red-800 border-red-200'
                        ];

                        $paymentColors = [
                            'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'terbayar' => 'bg-green-100 text-green-800 border-green-200',
                            'gagal' => 'bg-red-100 text-red-800 border-red-200'
                        ];

                        $statusLabels = [
                            'menunggu_verifikasi' => 'Menunggu Verifikasi',
                            'dikonfirmasi' => 'Dikonfirmasi',
                            'sedang_berjalan' => 'Sedang Berjalan',
                            'selesai' => 'Selesai',
                            'dibatalkan' => 'Dibatalkan'
                        ];
                    @endphp

                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-mono font-semibold text-gray-900">#{{ $rental->rental_id }}</div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $rental->created_at->format('d M Y') }}
                            </div>
                        </td>

                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold">
                                    {{ substr(optional($rental->user)->full_name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ optional($rental->user)->full_name ?? optional($rental->user)->username ?? 'User #'.$rental->user_id }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ optional($rental->user)->email }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">Mulai:</span>
                                    <span class="text-sm text-gray-600">{{ Carbon::parse($rental->rental_start_date)->format('d M Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">Selesai:</span>
                                    <span class="text-sm text-gray-600">{{ Carbon::parse($rental->rental_end_date)->format('d M Y') }}</span>
                                </div>
                                @if($rental->return_date)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">Kembali:</span>
                                    <span class="text-sm text-gray-600">{{ Carbon::parse($rental->return_date)->format('d M Y') }}</span>
                                </div>
                                @endif
                            </div>
                        </td>

                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                <div class="font-semibold text-gray-900">
                                    Rp {{ number_format($rental->total_price ?? 0, 0, ',', '.') }}
                                </div>
                                @if($totalDenda > 0)
                                <div class="text-xs">
                                    <span class="text-red-600 font-medium">+ Denda: Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                                </div>
                                <div class="text-sm font-bold text-gray-900">
                                    Total: Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusColors[$rental->order_status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                {{ $statusLabels[$rental->order_status] ?? $rental->order_status }}
                            </span>
                        </td>

                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $paymentColors[$rental->payment_status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                {{ str_replace('_', ' ', $rental->payment_status) }}
                            </span>
                            @if($rental->paid_at)
                            <div class="text-xs text-gray-500 mt-1">
                                {{ Carbon::parse($rental->paid_at)->format('d M Y') }}
                            </div>
                            @endif
                        </td>

                        <td class="py-4 px-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.rentals.show', $rental) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Kelola
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-lg font-medium text-gray-500">Belum ada data peminjaman</p>
                                <p class="text-sm mt-1">Data peminjaman akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $rentals->withQueryString()->links() }}
    </div>
@endsection