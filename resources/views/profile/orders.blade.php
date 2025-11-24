@extends('layouts.public')

@section('title', 'Riwayat Pesanan - Jatilawang Adventure')

@section('content')
<section class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
            <p class="text-gray-600 mt-2">Lihat semua pesanan sewa dan beli Anda</p>
        </div>

        {{-- Info Box --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Info Pesanan</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>• Pesanan akan diproses dalam 1x24 jam setelah pembayaran terverifikasi</p>
                        <p>• Untuk pertanyaan atau bantuan, hubungi admin:</p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Rental Orders --}}
        @if($rentals->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Pesanan Sewa</h2>
            <div class="space-y-4">
                @foreach($rentals as $rental)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-2">
                                <h3 class="font-medium text-gray-900">SEWA-{{ $rental->rental_id }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($rental->payment_status === 'terbayar') bg-green-100 text-green-800
                                    @elseif($rental->payment_status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $rental->payment_status)) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $rental->order_status)) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">
                                Periode: 
                                {{ \Carbon\Carbon::parse($rental->rental_start_date)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-600 mb-1">Total: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600">Metode: {{ strtoupper($rental->payment_method) }} • {{ $rental->delivery_option === 'delivery' ? 'Antar' : 'Ambil di Tempat' }}</p>
                            
                            {{-- Status Info --}}
                            @if($rental->order_status === 'menunggu_verifikasi')
                            <p class="text-xs text-yellow-600 mt-2">Menunggu verifikasi admin (1x24 jam)</p>
                            @elseif($rental->order_status === 'diproses')
                            <p class="text-xs text-blue-600 mt-2">Pesanan sedang diproses</p>
                            @elseif($rental->order_status === 'selesai')
                            <p class="text-xs text-green-600 mt-2">Pesanan telah selesai</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($rental->created_at)->format('d M Y H:i') }}</p>
                            
                            {{-- REVIEW BUTTON - Hanya untuk order selesai --}}
                            @if($rental->order_status === 'selesai')
                            <button onclick="openReviewModal()" 
                                    class="inline-block mt-2 px-3 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition">
                                Review Produk
                            </button>
                            @endif
                            
                            {{-- BAYAR BUTTON - Untuk yang belum bayar (non-cash) --}}
                            {{-- Untuk Rental --}}
                            @if($rental->payment_status === 'menunggu_pembayaran' && !$rental->payment_proof && $rental->payment_method !== 'cash')
                            <a href="{{ route('payment.show') }}" 
                            class="inline-block mt-2 px-3 py-1 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition">
                                Bayar Sekarang
                            </a>
                            @endif
                            
                            {{-- WHATSAPP BUTTON - Untuk pesanan yang butuh bantuan --}}
                            @if(in_array($rental->order_status, ['menunggu_verifikasi', 'diproses']))
                            <a href="https://wa.me/6288888888888?text={{ urlencode("Halo Admin Jatilawang Adventure,

Saya butuh bantuan untuk pesanan saya:

- ID Pesanan: SEWA-{$rental->rental_id}
- Tanggal Pesan: " . \Carbon\Carbon::parse($rental->created_at)->format('d M Y H:i') . "
- Username: " . Auth::user()->name . "

Status saat ini: " . ucfirst(str_replace('_', ' ', $rental->order_status)) . "

Mohon info update terbaru mengenai pesanan saya.

Terima kasih") }}" 
                               target="_blank"
                               class="inline-block mt-2 px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition">
                                📞 Tanya Admin
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Purchase Orders --}}
        @if($buys->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Pesanan Beli</h2>
            <div class="space-y-4">
                @foreach($buys as $buy)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-2">
                                <h3 class="font-medium text-gray-900">BELI-{{ $buy->buy_id }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($buy->payment_status === 'terbayar') bg-green-100 text-green-800
                                    @elseif($buy->payment_status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $buy->payment_status)) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $buy->order_status)) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">Total: Rp {{ number_format($buy->total_price, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600">Metode: {{ strtoupper($buy->payment_method) }} • {{ $buy->delivery_option === 'delivery' ? 'Antar' : 'Ambil di Tempat' }}</p>
                            @if($buy->shipping_address)
                            <p class="text-sm text-gray-600 mt-1">Alamat: {{ Str::limit($buy->shipping_address, 50) }}</p>
                            @endif
                            
                            {{-- Status Info --}}
                            @if($buy->order_status === 'menunggu_verifikasi')
                            <p class="text-xs text-yellow-600 mt-2">Menunggu verifikasi admin (1x24 jam)</p>
                            @elseif($buy->order_status === 'diproses')
                            <p class="text-xs text-blue-600 mt-2">Pesanan sedang diproses</p>
                            @elseif($buy->order_status === 'dikirim')
                            <p class="text-xs text-orange-600 mt-2">Pesanan sedang dikirim</p>
                            @elseif($buy->order_status === 'selesai')
                            <p class="text-xs text-green-600 mt-2">Pesanan telah selesai dan diterima</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($buy->created_at)->format('d M Y H:i') }}</p>
                            
                            {{-- REVIEW BUTTON - Hanya untuk order selesai --}}
                            @if($buy->order_status === 'selesai')
                            <button onclick="openReviewModal()" 
                                    class="inline-block mt-2 px-3 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition">
                                ✨ Review Produk
                            </button>
                            @endif
                            
                            {{-- BAYAR BUTTON - Untuk yang belum bayar (non-cash) --}}
                            @if($buy->payment_status === 'menunggu_pembayaran' && !$buy->payment_proof && $buy->payment_method !== 'cash')
                            <a href="{{ route('payment.show') }}" 
                            class="inline-block mt-2 px-3 py-1 bg-emerald-600 text-white text-xs rounded hover:bg-emerald-700 transition">
                                Bayar Sekarang
                            </a>
                            @endif
                            
                            {{-- WHATSAPP BUTTON - Untuk pesanan yang butuh bantuan --}}
                            @if(in_array($buy->order_status, ['menunggu_verifikasi', 'diproses', 'dikirim']))
                            <a href="https://wa.me/628888888888888?text={{ urlencode("Halo Admin Jatilawang Adventure,

Saya butuh bantuan untuk pesanan saya:

- ID Pesanan: BELI-{$buy->buy_id}
- Tanggal Pesan: " . \Carbon\Carbon::parse($buy->created_at)->format('d M Y H:i') . "
- Username: " . Auth::user()->name . "

Status saat ini: " . ucfirst(str_replace('_', ' ', $buy->order_status)) . "

Mohon info update terbaru mengenai pesanan saya.

Terima kasih") }}" 
                               target="_blank"
                               class="inline-block mt-2 px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition">
                                📞 Tanya Admin
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($rentals->count() === 0 && $buys->count() === 0)
        <div class="text-center py-12">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
            <p class="text-gray-600 mb-6">Mulai berbelanja untuk melihat pesanan di sini.</p>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">
                Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Modal Review --}}
<div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900">Review Produk</h3>
            <p class="text-sm text-gray-500 mt-2">Fitur review akan segera hadir!</p>
            <div class="items-center px-4 py-3">
                <button onclick="closeReviewModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openReviewModal() {
    document.getElementById('reviewModal').classList.remove('hidden');
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
}
</script>
@endsection