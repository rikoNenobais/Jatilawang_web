@extends('layouts.layout-admin')

@section('title', 'Detail Transaksi #TRX-' . $transaction->transaction_id)

@section('header', 'Detail Transaksi')

@section('content')
<div class="space-y-6">
    {{-- Transaction Summary --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Transaction Info --}}
            <div class="lg:col-span-2">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Transaksi</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-slate-500">Kode Transaksi</label>
                        <p class="text-lg font-semibold text-slate-900">TRX-{{ $transaction->transaction_id }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500">Tanggal Transaksi</label>
                        <p class="text-slate-900">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500">Total Amount</label>
                        <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500">Metode Pembayaran</label>
                        <p class="text-slate-900">{{ strtoupper($transaction->payment_method) }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500">Status Pembayaran</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($transaction->payment_status === 'terbayar') bg-green-100 text-green-800
                            @elseif($transaction->payment_status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                            @elseif($transaction->payment_status === 'menunggu_pembayaran') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ str_replace('_', ' ', $transaction->payment_status) }}
                        </span>
                    </div>
                    @if($transaction->paid_at)
                    <div>
                        <label class="text-sm font-medium text-slate-500">Dibayar Pada</label>
                        <p class="text-slate-900">{{ $transaction->paid_at->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Customer Info --}}
            <div>
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Customer</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-slate-500">Nama</label>
                        <p class="text-slate-900">{{ $transaction->user->full_name ?? $transaction->user->username }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500">Email</label>
                        <p class="text-slate-900">{{ $transaction->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500">Telepon</label>
                        <p class="text-slate-900">{{ $transaction->user->phone_number ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Proof --}}
    @if($transaction->payment_proof)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-4">Bukti Pembayaran</h3>
        <div class="flex flex-col sm:flex-row gap-6 items-start">
            <div class="flex-shrink-0">
                @if(pathinfo($transaction->payment_proof, PATHINFO_EXTENSION) === 'pdf')
                <div class="w-64 h-64 bg-slate-100 rounded-lg flex items-center justify-center border-2 border-dashed border-slate-300">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                        <p class="mt-2 text-sm text-slate-500">File PDF</p>
                    </div>
                </div>
                @else
                <img src="{{ asset('storage/' . $transaction->payment_proof) }}" 
                     alt="Bukti Pembayaran" 
                     class="w-64 h-64 object-cover rounded-lg border-2 border-slate-300">
                @endif
            </div>
            
            @if($transaction->payment_status === 'menunggu_verifikasi')
            <div class="flex-1">
                <h4 class="text-md font-semibold text-slate-900 mb-3">Verifikasi Pembayaran</h4>
                <div class="flex gap-3">
                    <form action="{{ route('admin.transactions.verify', $transaction) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition"
                                onclick="return confirm('Verifikasi pembayaran ini? Semua pesanan terkait akan dikonfirmasi.')">
                            ✅ Verifikasi Pembayaran
                        </button>
                    </form>
                    <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition"
                                onclick="return confirm('Tolak pembayaran ini?')">
                            ❌ Tolak Pembayaran
                        </button>
                    </form>
                </div>
                <p class="text-sm text-slate-500 mt-3">
                    Setelah diverifikasi, semua pesanan sewa dan beli dalam transaksi ini akan otomatis berstatus "dikonfirmasi".
                </p>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Rental Orders --}}
    @if($transaction->rentals->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-4">Pesanan Sewa</h3>
        <div class="space-y-4">
            @foreach($transaction->rentals as $rental)
            <div class="border border-slate-200 rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-slate-900">SEWA-{{ $rental->rental_id }}</h4>
                        <p class="text-sm text-slate-600 mt-1">
                            Periode: {{ \Carbon\Carbon::parse($rental->rental_start_date)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($rental->order_status === 'selesai') bg-green-100 text-green-800
                            @elseif($rental->order_status === 'dikonfirmasi') bg-blue-100 text-blue-800
                            @elseif($rental->order_status === 'sedang_berjalan') bg-purple-100 text-purple-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ str_replace('_', ' ', $rental->order_status) }}
                        </span>
                        <p class="text-lg font-semibold text-slate-900 mt-1">
                            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Rental Items --}}
                <div class="border-t border-slate-200 pt-3 mt-3">
                    <h5 class="text-sm font-medium text-slate-700 mb-2">Items:</h5>
                    <div class="space-y-2">
                        @foreach($rental->details as $detail)
                        <div class="flex justify-between items-center text-sm">
                            <span>{{ $detail->item->item_name }} (x{{ $detail->quantity }})</span>
                            <span class="text-slate-600">{{ $detail->days ?? 1 }} hari</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between items-center mt-3 pt-3 border-t border-slate-200">
                    <div class="text-sm text-slate-600">
                        Pengiriman: {{ $rental->delivery_option === 'delivery' ? 'Antar' : 'Ambil di Tempat' }}
                    </div>
                    <a href="{{ route('admin.rentals.show', $rental) }}" 
                       class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                        Kelola Pesanan →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Buy Orders --}}
    @if($transaction->buys->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-4">Pesanan Beli</h3>
        <div class="space-y-4">
            @foreach($transaction->buys as $buy)
            <div class="border border-slate-200 rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-slate-900">BELI-{{ $buy->buy_id }}</h4>
                        @if($buy->shipping_address)
                        <p class="text-sm text-slate-600 mt-1">
                            Alamat: {{ Str::limit($buy->shipping_address, 50) }}
                        </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($buy->order_status === 'selesai') bg-green-100 text-green-800
                            @elseif($buy->order_status === 'dikirim') bg-blue-100 text-blue-800
                            @elseif($buy->order_status === 'diproses') bg-purple-100 text-purple-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ str_replace('_', ' ', $buy->order_status) }}
                        </span>
                        <p class="text-lg font-semibold text-slate-900 mt-1">
                            Rp {{ number_format($buy->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Buy Items --}}
                <div class="border-t border-slate-200 pt-3 mt-3">
                    <h5 class="text-sm font-medium text-slate-700 mb-2">Items:</h5>
                    <div class="space-y-2">
                        @foreach($buy->detailBuys as $detail)
                        <div class="flex justify-between items-center text-sm">
                            <span>{{ $detail->item->item_name }} (x{{ $detail->quantity }})</span>
                            <span class="text-slate-600">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between items-center mt-3 pt-3 border-t border-slate-200">
                    <div class="text-sm text-slate-600">
                        Pengiriman: {{ $buy->delivery_option === 'delivery' ? 'Antar' : 'Ambil di Tempat' }}
                    </div>
                    <a href="{{ route('admin.buys.show', $buy) }}" 
                       class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                        Kelola Pesanan →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.transactions.index') }}" 
           class="text-indigo-600 hover:text-indigo-900 font-medium">
            ← Kembali ke Daftar Transaksi
        </a>
        
        <div class="flex gap-3">
            <button onclick="window.print()" 
                    class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-medium transition">
                🖨️ Cetak Nota
            </button>
        </div>
    </div>
</div>

{{-- Print Styles --}}
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .bg-white, .bg-white * {
        visibility: visible;
    }
    .bg-white {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: 1px solid #000 !important;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endsection