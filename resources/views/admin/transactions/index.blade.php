@extends('layouts.layout-admin')

@section('title', 'Manajemen Transaksi')

@section('header', 'Manajemen Transaksi')

@section('content')
<div class="space-y-6">
    {{-- Filter & Search --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col gap-4">
            {{-- Search Bar --}}
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                <div class="flex-1 w-full sm:max-w-md">
                    <form action="{{ route('admin.transactions.index') }}" method="GET" id="searchForm">
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
                
                <div class="flex gap-3 flex-wrap">
                    {{-- Status Filter --}}
                    <select name="status" onchange="updateUrlParam('status', this.value)" 
                            class="border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>
                            Menunggu Pembayaran
                        </option>
                        <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>
                            Menunggu Verifikasi
                        </option>
                        <option value="terbayar" {{ request('status') == 'terbayar' ? 'selected' : '' }}>
                            Terbayar
                        </option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                        <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>
                            Gagal
                        </option>
                    </select>

                    {{-- Reset Filter --}}
                    @if(request()->hasAny(['q', 'status', 'month', 'year', 'start_date', 'end_date']))
                    <a href="{{ route('admin.transactions.index') }}" 
                       class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-lg transition">
                        Reset Filter
                    </a>
                    @endif
                </div>
            </div>

            {{-- Advanced Date Filters --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-4 border-t border-slate-200">
                {{-- Filter Tahun --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                    <select name="year" onchange="updateUrlParam('year', this.value)"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Tahun</option>
                        @php
                            $currentYear = date('Y');
                            $selectedYear = request('year');
                        @endphp
                        @for($year = $currentYear; $year >= 2025; $year--)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Filter Bulan --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Bulan</label>
                    <select name="month" onchange="updateUrlParam('month', this.value)"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Bulan</option>
                        @php
                            $currentYear = date('Y');
                            $currentMonth = date('m');
                            $selectedMonth = request('month');
                        @endphp
                        @for($month = 1; $month <= 12; $month++)
                            @php
                                $monthValue = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
                                $monthName = \Carbon\Carbon::create($currentYear, $month, 1)->translatedFormat('F');
                                $isSelected = $selectedMonth == $monthValue;
                            @endphp
                            <option value="{{ $monthValue }}" {{ $isSelected ? 'selected' : '' }}>
                                {{ $monthName }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Filter Tanggal Mulai --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           onchange="updateUrlParam('start_date', this.value)"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                {{-- Filter Tanggal Akhir --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           onchange="updateUrlParam('end_date', this.value)"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        {{-- Info Filter Aktif --}}
        @if(request()->hasAny(['q', 'status', 'month', 'year', 'start_date', 'end_date']))
        <div class="mt-4 flex flex-wrap gap-2">
            @if(request('q'))
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                Pencarian: "{{ request('q') }}"
                <button onclick="removeUrlParam('q')" class="ml-1 text-blue-600 hover:text-blue-800">
                    &times;
                </button>
            </span>
            @endif

            @if(request('status'))
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                <button onclick="removeUrlParam('status')" class="ml-1 text-green-600 hover:text-green-800">
                    &times;
                </button>
            </span>
            @endif

            @if(request('year'))
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                Tahun: {{ request('year') }}
                <button onclick="removeUrlParam('year')" class="ml-1 text-purple-600 hover:text-purple-800">
                    &times;
                </button>
            </span>
            @endif

            @if(request('month'))
            @php
                $monthName = \Carbon\Carbon::createFromFormat('Y-m', request('month'))->translatedFormat('F Y');
            @endphp
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-indigo-100 text-indigo-800">
                Bulan: {{ $monthName }}
                <button onclick="removeUrlParam('month')" class="ml-1 text-indigo-600 hover:text-indigo-800">
                    &times;
                </button>
            </span>
            @endif

            @if(request('start_date') && request('end_date'))
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">
                Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                <button onclick="removeDateRange()" class="ml-1 text-amber-600 hover:text-amber-800">
                    &times;
                </button>
            </span>
            @elseif(request('start_date'))
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">
                Dari: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }}
                <button onclick="removeUrlParam('start_date')" class="ml-1 text-amber-600 hover:text-amber-800">
                    &times;
                </button>
            </span>
            @elseif(request('end_date'))
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800">
                Sampai: {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                <button onclick="removeUrlParam('end_date')" class="ml-1 text-amber-600 hover:text-amber-800">
                    &times;
                </button>
            </span>
            @endif
        </div>
        @endif
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
                                @elseif($transaction->payment_status === 'dibatalkan') bg-gray-100 text-gray-800
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
                            
                            {{-- ADMIN ACTIONS --}}
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
                                        class="text-red-600 hover:text-red-900 mr-4"
                                        onclick="return confirm('Tolak pembayaran transaksi ini?')">
                                    Reject
                                </button>
                            </form>
                            @endif
                            
                            {{-- CANCEL BUTTON - Untuk status menunggu --}}
                            @if(in_array($transaction->payment_status, ['menunggu_pembayaran', 'menunggu_verifikasi']))
                            <button onclick="openAdminCancelModal({{ $transaction->transaction_id }})" 
                                    class="text-red-600 hover:text-red-900">
                                Batalkan
                            </button>
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
                            <p class="mt-1 text-sm text-slate-500">
                                @if(request()->hasAny(['q', 'status', 'month', 'year', 'start_date', 'end_date']))
                                Tidak ada transaksi yang sesuai dengan filter yang dipilih.
                                @else
                                Belum ada transaksi yang tercatat.
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($transactions->hasPages())
        <div class="bg-white px-6 py-4 border-t border-slate-200">
            {{ $transactions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Admin Cancel Modal --}}
<div id="adminCancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900">Batalkan Transaksi</h3>
            <p class="text-sm text-gray-500 mt-2">Anda yakin ingin membatalkan transaksi ini?</p>
            
            <form id="adminCancelForm" method="POST" class="mt-4">
                @csrf
                <div class="mt-4">
                    <label for="admin_cancellation_reason" class="block text-sm font-medium text-gray-700">
                        Alasan Pembatalan
                    </label>
                    <textarea name="cancellation_reason" id="admin_cancellation_reason" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Masukkan alasan pembatalan..."
                              required></textarea>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeAdminCancelModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Konfirmasi Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi untuk update URL parameter
function updateUrlParam(key, value) {
    const url = new URL(window.location.href);
    
    if (value === '') {
        url.searchParams.delete(key);
    } else {
        url.searchParams.set(key, value);
    }
    
    window.location.href = url.toString();
}

// Fungsi untuk remove URL parameter
function removeUrlParam(key) {
    const url = new URL(window.location.href);
    url.searchParams.delete(key);
    window.location.href = url.toString();
}

// Fungsi untuk remove date range (kedua tanggal sekaligus)
function removeDateRange() {
    const url = new URL(window.location.href);
    url.searchParams.delete('start_date');
    url.searchParams.delete('end_date');
    window.location.href = url.toString();
}

// Auto-submit form ketika mengetik di search (dengan delay)
let searchTimeout;
document.querySelector('input[name="q"]').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('searchForm').submit();
    }, 500);
});

// Admin Cancel Modal
function openAdminCancelModal(transactionId) {
    const form = document.getElementById('adminCancelForm');
    form.action = `/admin/transactions/${transactionId}/cancel`;
    document.getElementById('adminCancelModal').classList.remove('hidden');
}

function closeAdminCancelModal() {
    document.getElementById('adminCancelModal').classList.add('hidden');
    document.getElementById('admin_cancellation_reason').value = '';
}

// Close modal ketika klik outside
document.getElementById('adminCancelModal').addEventListener('click', function(e) {
    if (e.target.id === 'adminCancelModal') {
        closeAdminCancelModal();
    }
});
</script>
@endsection