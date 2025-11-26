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
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 no-print">
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

    {{-- Printable Invoice --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex justify-between items-center mb-6 no-print">
            <h3 class="text-lg font-semibold text-slate-900">Nota Transaksi</h3>
            <button onclick="printInvoice()" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition">
                🖨️ Cetak Nota
            </button>
        </div>

        {{-- Invoice Content --}}
        <div id="printable-invoice" class="invoice-content border-2 border-dashed border-slate-300 p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-slate-900">JATILAWANG ADVENTURE</h1>
                <p class="text-slate-600">Jl. Parangtritis KM 8.5, Yogyakarta</p>
                <p class="text-slate-600">Telp: 0812-3456-7890 | Email: info@jatilawang.com</p>
            </div>

            {{-- Invoice Info --}}
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold text-slate-900 mb-2">INFORMASI TRANSAKSI</h3>
                    <table class="text-sm">
                        <tr>
                            <td class="pr-4 py-1 text-slate-600">No. Transaksi</td>
                            <td class="font-medium">: TRX-{{ $transaction->transaction_id }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4 py-1 text-slate-600">Tanggal</td>
                            <td class="font-medium">: {{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4 py-1 text-slate-600">Metode Bayar</td>
                            <td class="font-medium">: {{ strtoupper($transaction->payment_method) }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4 py-1 text-slate-600">Status</td>
                            <td class="font-medium">: {{ str_replace('_', ' ', $transaction->payment_status) }}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-900 mb-2">INFORMASI CUSTOMER</h3>
                    <table class="text-sm">
                        <tr>
                            <td class="pr-4 py-1 text-slate-600">Nama</td>
                            <td class="font-medium">: {{ $transaction->user->full_name ?? $transaction->user->username }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4 py-1 text-slate-600">Email</td>
                            <td class="font-medium">: {{ $transaction->user->email }}</td>
                        </tr>
                        <tr>
                            <td class="pr-4 py-1 text-slate-600">Telepon</td>
                            <td class="font-medium">: {{ $transaction->user->phone_number ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Rental Orders --}}
            @if($transaction->rentals->count() > 0)
            <div class="mb-6">
                <h3 class="font-semibold text-slate-900 border-b pb-2 mb-3">PESANAN SEWA</h3>
                @foreach($transaction->rentals as $rental)
                <div class="mb-4 p-3 bg-slate-50 rounded">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-medium">SEWA-{{ $rental->rental_id }}</p>
                            <p class="text-sm text-slate-600">
                                Periode: {{ \Carbon\Carbon::parse($rental->rental_start_date)->format('d/m/Y') }} - 
                                {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                            <p class="text-sm text-slate-600">{{ str_replace('_', ' ', $rental->order_status) }}</p>
                        </div>
                    </div>
                    
                    <table class="w-full text-sm mt-2">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-1">Item</th>
                                <th class="text-center py-1">Qty</th>
                                <th class="text-center py-1">Hari</th>
                                <th class="text-right py-1">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rental->details as $detail)
                            <tr class="border-b">
                                <td class="py-2">{{ $detail->item->item_name }}</td>
                                <td class="text-center py-2">{{ $detail->quantity }}</td>
                                <td class="text-center py-2">{{ $detail->days ?? 1 }}</td>
                                <td class="text-right py-2">Rp {{ number_format($detail->item->rental_price * $detail->quantity * ($detail->days ?? 1), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Buy Orders --}}
            @if($transaction->buys->count() > 0)
            <div class="mb-6">
                <h3 class="font-semibold text-slate-900 border-b pb-2 mb-3">PESANAN BELI</h3>
                @foreach($transaction->buys as $buy)
                <div class="mb-4 p-3 bg-slate-50 rounded">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-medium">BELI-{{ $buy->buy_id }}</p>
                            @if($buy->shipping_address)
                            <p class="text-sm text-slate-600">Alamat: {{ $buy->shipping_address }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">Rp {{ number_format($buy->total_price, 0, ',', '.') }}</p>
                            <p class="text-sm text-slate-600">{{ str_replace('_', ' ', $buy->order_status) }}</p>
                        </div>
                    </div>
                    
                    <table class="w-full text-sm mt-2">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-1">Item</th>
                                <th class="text-center py-1">Qty</th>
                                <th class="text-right py-1">Harga</th>
                                <th class="text-right py-1">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buy->detailBuys as $detail)
                            <tr class="border-b">
                                <td class="py-2">{{ $detail->item->item_name }}</td>
                                <td class="text-center py-2">{{ $detail->quantity }}</td>
                                <td class="text-right py-2">Rp {{ number_format($detail->item->sale_price, 0, ',', '.') }}</td>
                                <td class="text-right py-2">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Summary --}}
            <div class="border-t pt-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-medium">Subtotal:</span>
                    <span class="font-medium">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
                @if($transaction->rentals->count() > 0 || $transaction->buys->count() > 0)
                    @php
                        $deliveryFee = 0;
                        if($transaction->rentals->count() > 0 && $transaction->rentals->first()->delivery_option === 'delivery') {
                            $deliveryFee = 18000;
                        } elseif($transaction->buys->count() > 0 && $transaction->buys->first()->delivery_option === 'delivery') {
                            $deliveryFee = 18000;
                        }
                    @endphp
                    @if($deliveryFee > 0)
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Biaya Pengiriman:</span>
                        <span class="font-medium">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                    </div>
                    @endif
                @endif
                <div class="flex justify-between items-center text-lg font-bold mt-3 pt-3 border-t">
                    <span>TOTAL:</span>
                    <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Footer --}}
            <div class="text-center mt-8 pt-6 border-t">
                <p class="text-slate-600 text-sm">Terima kasih atas kepercayaan Anda berbelanja di Jatilawang Adventure</p>
                <p class="text-slate-500 text-xs mt-2">Nota ini dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex justify-between items-center no-print">
        <a href="{{ route('admin.transactions.index') }}" 
           class="text-indigo-600 hover:text-indigo-900 font-medium">
            ← Kembali ke Daftar Transaksi
        </a>
    </div>
</div>

{{-- Print Styles --}}
<style>
@media print {
    body * {
        visibility: hidden;
        margin: 0;
        padding: 0;
    }
    
    #printable-invoice,
    #printable-invoice * {
        visibility: visible;
    }
    
    #printable-invoice {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: white;
        z-index: 9999;
        box-shadow: none !important;
        border: none !important;
        padding: 20px !important;
        margin: 0 !important;
    }
    
    .no-print,
    .no-print * {
        display: none !important;
    }
    
    .invoice-content {
        border: none !important;
        padding: 0 !important;
        font-size: 14px;
        max-width: none !important;
    }
    
    .bg-slate-50 {
        background-color: #f8fafc !important;
        -webkit-print-color-adjust: exact;
    }
    
    /* Improve print quality */
    table {
        page-break-inside: auto;
        width: 100%;
    }
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    /* Ensure proper spacing */
    .mb-6 {
        margin-bottom: 1.5rem;
    }
    .mb-4 {
        margin-bottom: 1rem;
    }
    .mb-2 {
        margin-bottom: 0.5rem;
    }
    .mt-8 {
        margin-top: 2rem;
    }
    .pt-4 {
        padding-top: 1rem;
    }
    .pt-6 {
        padding-top: 1.5rem;
    }
}

/* Screen styles for invoice */
.invoice-content {
    background: white;
    font-family: 'Courier New', monospace;
}

/* Hide border dashes on screen but show content */
.border-dashed {
    border-style: solid !important;
}
</style>

<script>
function printInvoice() {
    window.print();
}

// Optional: Add print success message
window.addEventListener('afterprint', function() {
    console.log('Nota berhasil dicetak');
});
</script>
@endsection