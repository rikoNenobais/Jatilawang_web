@extends('layouts.public')

@section('title', 'Riwayat Pesanan - Jatilawang Adventure')

@section('content')
<section class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
            <p class="text-gray-600 mt-2">Lihat semua transaksi sewa dan beli Anda</p>
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
                    <h3 class="text-sm font-medium text-blue-800">Info Transaksi</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>• Pesanan akan diproses dalam 1x24 jam setelah pembayaran terverifikasi</p>
                        <p>• Anda dapat membatalkan transaksi yang belum diproses</p>
                        <p>• Beri review untuk pesanan yang sudah selesai</p>
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

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Transactions --}}
        @if($transactions->count() > 0)
        <div class="space-y-6">
            @foreach($transactions as $transaction)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                {{-- Transaction Header --}}
                <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-200">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Transaksi #TRX-{{ $transaction->transaction_id }}</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $transaction->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($transaction->payment_status === 'terbayar') bg-green-100 text-green-800
                            @elseif($transaction->payment_status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800
                            @elseif($transaction->payment_status === 'menunggu_pembayaran') bg-blue-100 text-blue-800
                            @elseif($transaction->payment_status === 'dibatalkan') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ str_replace('_', ' ', $transaction->payment_status) }}
                        </span>
                        <p class="text-lg font-bold text-gray-900 mt-2">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ strtoupper($transaction->payment_method) }}
                        </p>
                    </div>
                </div>

                {{-- Rental Orders --}}
                @foreach($transaction->rentals as $rental)
                <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-2">
                                <h3 class="font-medium text-gray-900">📅 Sewa - SEWA-{{ $rental->rental_id }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($rental->order_status === 'selesai') bg-green-100 text-green-800
                                    @elseif($rental->order_status === 'dibatalkan') bg-gray-100 text-gray-800
                                    @elseif($rental->order_status === 'sedang_berjalan') bg-purple-100 text-purple-800
                                    @endif">
                                    {{ str_replace('_', ' ', $rental->order_status) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                                <div>Periode:</div>
                                <div>{{ \Carbon\Carbon::parse($rental->rental_start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('d M Y') }}</div>
                                <div>Pengiriman:</div>
                                <div>{{ $rental->delivery_option === 'delivery' ? 'Antar (Rp 18.000)' : 'Ambil di Tempat' }}</div>
                                <div>Subtotal:</div>
                                <div class="font-medium">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                            </div>

                            {{-- Tampilkan rating jika sudah direview --}}
                            @if($rental->order_status === 'selesai' && $rental->ratings->count() > 0)
                            <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center gap-2 text-sm text-green-800">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="font-medium">Rating Anda:</span>
                                    <div class="flex items-center gap-1">
                                        @php $rating = $rental->ratings->first()->rating_value; @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                        <span class="text-green-700 ml-1">({{ $rating }}/5)</span>
                                    </div>
                                </div>
                                @if($rental->ratings->first()->comment)
                                <p class="text-sm text-green-700 mt-1 italic">"{{ $rental->ratings->first()->comment }}"</p>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="text-right">
                            {{-- REVIEW BUTTON - Hanya untuk order selesai dan belum ada rating --}}
                            @if($rental->order_status === 'selesai' && $rental->ratings->count() === 0)
                            <a href="{{ route('reviews.create', ['rental', $rental->rental_id]) }}" 
                               class="inline-block px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition mb-2">
                                ✨ Beri Review
                            </a>
                            @endif
                            
                            {{-- WHATSAPP BUTTON --}}
                            @if(in_array($rental->order_status, ['menunggu_verifikasi', 'dikonfirmasi', 'sedang_berjalan']))
                            <a href="https://wa.me/6288888888888?text={{ urlencode("Halo Admin Jatilawang Adventure,

Saya butuh bantuan untuk pesanan saya:

- ID Transaksi: TRX-{$transaction->transaction_id}
- ID Sewa: SEWA-{$rental->rental_id}
- Status: " . ucfirst(str_replace('_', ' ', $rental->order_status)) . "

Mohon info update terbaru.

Terima kasih") }}" 
                               target="_blank"
                               class="inline-block px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                                📞 Tanya Admin
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Buy Orders --}}
                @foreach($transaction->buys as $buy)
                <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-2">
                                <h3 class="font-medium text-gray-900">🛒 Beli - BELI-{{ $buy->buy_id }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($buy->order_status === 'selesai') bg-green-100 text-green-800
                                    @elseif($buy->order_status === 'dibatalkan') bg-gray-100 text-gray-800
                                    @elseif(in_array($buy->order_status, ['diproses', 'dikirim'])) bg-purple-100 text-purple-800
                                    @endif">
                                    {{ str_replace('_', ' ', $buy->order_status) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                                <div>Pengiriman:</div>
                                <div>{{ $buy->delivery_option === 'delivery' ? 'Antar (Rp 18.000)' : 'Ambil di Tempat' }}</div>
                                <div>Subtotal:</div>
                                <div class="font-medium">Rp {{ number_format($buy->total_price, 0, ',', '.') }}</div>
                            </div>
                            @if($buy->shipping_address)
                            <div class="text-sm text-gray-600 mt-2">
                                <div class="font-medium">Alamat:</div>
                                <div class="text-xs">{{ $buy->shipping_address }}</div>
                            </div>
                            @endif

                            {{-- Tampilkan rating jika sudah direview --}}
                            @if($buy->order_status === 'selesai' && $buy->ratings->count() > 0)
                            <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center gap-2 text-sm text-green-800">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="font-medium">Rating Anda:</span>
                                    <div class="flex items-center gap-1">
                                        @php $rating = $buy->ratings->first()->rating_value; @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                        <span class="text-green-700 ml-1">({{ $rating }}/5)</span>
                                    </div>
                                </div>
                                @if($buy->ratings->first()->comment)
                                <p class="text-sm text-green-700 mt-1 italic">"{{ $buy->ratings->first()->comment }}"</p>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="text-right">
                            {{-- REVIEW BUTTON - Hanya untuk order selesai dan belum ada rating --}}
                            @if($buy->order_status === 'selesai' && $buy->ratings->count() === 0)
                            <a href="{{ route('reviews.create', ['buy', $buy->buy_id]) }}" 
                               class="inline-block px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition mb-2">
                                ✨ Beri Review
                            </a>
                            @endif
                            
                            {{-- WHATSAPP BUTTON --}}
                            @if(in_array($buy->order_status, ['menunggu_verifikasi', 'dikonfirmasi', 'diproses', 'dikirim']))
                            <a href="https://wa.me/6288888888888?text={{ urlencode("Halo Admin Jatilawang Adventure,

Saya butuh bantuan untuk pesanan saya:

- ID Transaksi: TRX-{$transaction->transaction_id}
- ID Beli: BELI-{$buy->buy_id}
- Status: " . ucfirst(str_replace('_', ' ', $buy->order_status)) . "

Mohon info update terbaru.

Terima kasih") }}" 
                               target="_blank"
                               class="inline-block px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                                📞 Tanya Admin
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Payment Actions --}}
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            @if($transaction->payment_status === 'menunggu_pembayaran')
                            <p class="text-yellow-600">Silakan selesaikan pembayaran</p>
                            @elseif($transaction->payment_status === 'menunggu_verifikasi')
                            <p class="text-blue-600">Menunggu verifikasi pembayaran</p>
                            @elseif($transaction->payment_status === 'terbayar')
                            <p class="text-green-600">Pembayaran terverifikasi</p>
                            @elseif($transaction->payment_status === 'dibatalkan')
                            <p class="text-gray-600">Transaksi dibatalkan</p>
                            @endif
                        </div>
                        
                        <div class="flex gap-2">
                            @if($transaction->payment_status === 'menunggu_pembayaran')
                            <a href="{{ route('payment.show', $transaction->transaction_id) }}" 
                               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                Bayar Sekarang
                            </a>
                            @endif
                            
                            {{-- CANCEL TRANSACTION BUTTON - Hanya untuk status menunggu --}}
                            @if(in_array($transaction->payment_status, ['menunggu_pembayaran', 'menunggu_verifikasi']))
                            <form action="{{ route('transactions.cancel', $transaction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition"
                                        onclick="return confirm('Batalkan transaksi ini? Semua pesanan dalam transaksi akan dibatalkan dan stock akan dikembalikan.')">
                                    Batalkan Transaksi
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($transactions->hasPages())
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
        @endif
        @endif

        @if($transactions->count() === 0)
        <div class="text-center py-12">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada transaksi</h3>
            <p class="text-gray-600 mb-6">Mulai berbelanja untuk melihat transaksi di sini.</p>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">
                Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</section>
@endsection