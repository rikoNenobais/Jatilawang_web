@extends('layouts.layout-admin')

@section('title', 'Manajemen Transaksi')

@section('header', 'Manajemen Transaksi')

@section('content')
<div class="space-y-6">
    {{-- Filter & Search --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
            <div class="flex-1 w-full sm:max-w-md">
                <form action="{{ route('admin.transactions.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" 
                               placeholder="Cari transaksi atau user..." 
                               class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="flex gap-3">
                {{-- Status Filter --}}
                <select onchange="window.location.href = this.value" 
                        class="border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="{{ route('admin.transactions.index') }}">Semua Status</option>
                    <option value="{{ route('admin.transactions.index', ['status' => 'menunggu_pembayaran']) }}" 
                            {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>
                        Menunggu Pembayaran
                    </option>
                    <option value="{{ route('admin.transactions.index', ['status' => 'menunggu_verifikasi']) }}" 
                            {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>
                        Menunggu Verifikasi
                    </option>
                    <option value="{{ route('admin.transactions.index', ['status' => 'terbayar']) }}" 
                            {{ request('status') == 'terbayar' ? 'selected' : '' }}>
                        Terbayar
                    </option>
                    <option value="{{ route('admin.transactions.index', ['status' => 'gagal']) }}" 
                            {{ request('status') == 'gagal' ? 'selected' : '' }}>
                        Gagal
                    </option>
                </select>
            </div>
        </div>
    </div>

    {{-- Transactions List --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Transaksi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Metode
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">
                                TRX-{{ $transaction->transaction_id }}
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ $transaction->rentals->count() }} Sewa • {{ $transaction->buys->count() }} Beli
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">
                                {{ $transaction->user->full_name ?? $transaction->user->username }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $transaction->user->email }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-slate-900">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ strtoupper($transaction->payment_method) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($transaction->payment_status === 'terbayar') bg-green-100 text-green-800
                                @elseif($transaction->payment_status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                                @elseif($transaction->payment_status === 'menunggu_pembayaran') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ str_replace('_', ' ', $transaction->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $transaction->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.transactions.show', $transaction) }}" 
                               class="text-indigo-600 hover:text-indigo-900 mr-4">
                                Detail
                            </a>
                            @if($transaction->payment_status === 'menunggu_verifikasi')
                            <form action="{{ route('admin.transactions.verify', $transaction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="text-green-600 hover:text-green-900 mr-4"
                                        onclick="return confirm('Verifikasi pembayaran transaksi ini?')">
                                    Verify
                                </button>
                            </form>
                            <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Tolak pembayaran transaksi ini?')">
                                    Reject
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                            <h3 class="mt-4 text-sm font-medium text-slate-900">Tidak ada transaksi</h3>
                            <p class="mt-1 text-sm text-slate-500">Belum ada transaksi yang tercatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($transactions->hasPages())
        <div class="bg-white px-6 py-4 border-t border-slate-200">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection