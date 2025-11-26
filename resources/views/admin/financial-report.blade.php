@extends('layouts.layout-admin')

@section('title', 'Laporan Keuangan')
@section('header', 'Laporan Keuangan')

@section('content')
<div class="space-y-6">
    {{-- Filter Periode --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.financial-report') }}" method="GET" class="flex flex-col md:flex-row gap-4 md:items-end">
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-medium text-slate-700 mb-1">Mulai tanggal</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date', $start->toDateString()) }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex-1">
                <label for="end_date" class="block text-sm font-medium text-slate-700 mb-1">Sampai tanggal</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date', $end->toDateString()) }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Terapkan
                </button>
                <a href="{{ route('admin.financial-report') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Ringkasan Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-sm text-slate-500">Pendapatan Bersih</p>
            <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Transaksi terbayar</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-sm text-slate-500">Sedang Diproses</p>
            <p class="text-2xl font-bold text-amber-600">Rp {{ number_format($summary['pending_amount'], 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Menunggu bayar/verifikasi</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-sm text-slate-500">Pembayaran Gagal</p>
            <p class="text-2xl font-bold text-rose-600">Rp {{ number_format($summary['failed_amount'], 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Pembayaran ditolak/gagal</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <p class="text-sm text-slate-500">Total Transaksi</p>
            <p class="text-2xl font-bold text-slate-900">{{ $summary['transaction_count'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Dalam periode terpilih</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Breakdown tipe order --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Pendapatan per Tipe Order</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-slate-600">Rental</span>
                    <span class="font-semibold">Rp {{ number_format($typeBreakdown['rental'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-600">Pembelian</span>
                    <span class="font-semibold">Rp {{ number_format($typeBreakdown['buy'] ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Breakdown metode pembayaran --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Pendapatan per Metode</h3>
            @forelse($paymentMethodBreakdown as $method => $total)
                <div class="flex items-center justify-between">
                    <span class="uppercase text-slate-600">{{ $method }}</span>
                    <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            @empty
                <p class="text-slate-500 text-sm">Belum ada transaksi terbayar.</p>
            @endforelse
        </div>

        {{-- Tren bulanan --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Tren 6 Bulan Terakhir</h3>
            <div class="space-y-3">
                @forelse($monthlyTrend as $trend)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">{{ \Carbon\Carbon::parse($trend->period.'-01')->translatedFormat('M Y') }}</span>
                        <span class="font-semibold">Rp {{ number_format($trend->total, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-slate-500 text-sm">Belum ada data.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Detail transaksi --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Detail Transaksi</h3>
                <p class="text-sm text-slate-500">{{ $transactions->count() }} transaksi pada periode ini</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">TRX-{{ $transaction->transaction_id }}</div>
                                <div class="text-xs text-slate-500 mt-1">
                                    {{ $transaction->transactionItems->where('order_type', 'rental')->count() }} sewa •
                                    {{ $transaction->transactionItems->where('order_type', 'buy')->count() }} beli
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-900">{{ $transaction->user->full_name ?? $transaction->user->username }}</div>
                                <div class="text-xs text-slate-500">{{ $transaction->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs uppercase text-slate-600">
                                {{ $transaction->payment_method }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($transaction->payment_status === 'terbayar') bg-green-100 text-green-800
                                    @elseif($transaction->payment_status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                                    @elseif($transaction->payment_status === 'menunggu_pembayaran') bg-blue-100 text-blue-800
                                    @else bg-rose-100 text-rose-800 @endif">
                                    {{ str_replace('_', ' ', $transaction->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
