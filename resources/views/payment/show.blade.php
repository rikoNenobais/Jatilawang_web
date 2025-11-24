@extends('layouts.public')

@section('title', 'Pembayaran - Jatilawang Adventure')

@section('content')
<section class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Pembayaran</h1>
            <p class="text-gray-600 mt-2">Selesaikan pembayaran untuk pesanan Anda</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            {{-- Order Info --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h3>
                
                {{-- Tampilkan semua rental yang belum bayar --}}
                @foreach($unpaidRentals as $rental)
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-gray-700 mb-2">📅 Sewa - SEWA-{{ $rental->rental_id }}</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="text-gray-600">Total:</div>
                        <div class="text-gray-900 font-medium">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</div>
                        
                        <div class="text-gray-600">Metode:</div>
                        <div class="text-gray-900 font-medium">{{ strtoupper($rental->payment_method) }}</div>
                        
                        <div class="text-gray-600">Pengiriman:</div>
                        <div class="text-gray-900 font-medium">
                            {{ $rental->delivery_option === 'delivery' ? 'Antar (Rp 18.000)' : 'Ambil di Tempat' }}
                        </div>
                        
                        <div class="text-gray-600">Periode:</div>
                        <div class="text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($rental->rental_start_date)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('d M Y') }}
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Tampilkan semua buy yang belum bayar --}}
                @foreach($unpaidBuys as $buy)
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-gray-700 mb-2">🛒 Beli - BELI-{{ $buy->buy_id }}</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="text-gray-600">Total:</div>
                        <div class="text-gray-900 font-medium">Rp {{ number_format($buy->total_price, 0, ',', '.') }}</div>
                        
                        <div class="text-gray-600">Metode:</div>
                        <div class="text-gray-900 font-medium">{{ strtoupper($buy->payment_method) }}</div>
                        
                        <div class="text-gray-600">Pengiriman:</div>
                        <div class="text-gray-900 font-medium">
                            {{ $buy->delivery_option === 'delivery' ? 'Antar (Rp 18.000)' : 'Ambil di Tempat' }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Payment Instructions --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Instruksi Pembayaran</h3>
                
                @php
                    // Ambil metode pembayaran dari order pertama
                    $paymentMethod = $unpaidRentals->first() ? $unpaidRentals->first()->payment_method : 
                                  ($unpaidBuys->first() ? $unpaidBuys->first()->payment_method : 'transfer');
                @endphp

                @if($paymentMethod === 'qris')
                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                    <h4 class="font-semibold text-emerald-800 mb-2">Pembayaran QRIS</h4>
                    <div class="text-center mb-4">
                        <div class="bg-white p-4 rounded-lg inline-block">
                            <div class="w-48 h-48 bg-gray-200 rounded flex items-center justify-center mb-2">
                                <span class="text-gray-500">[QR CODE]</span>
                            </div>
                            <p class="text-sm text-gray-600">Scan QR code di atas</p>
                        </div>
                    </div>
                    <ol class="text-sm text-gray-700 space-y-2">
                        <li>1. Buka aplikasi e-wallet atau mobile banking Anda</li>
                        <li>2. Pilih fitur scan QRIS</li>
                        <li>3. Arahkan kamera ke QR code di atas</li>
                        <li>4. Konfirmasi pembayaran</li>
                        <li>5. Simpan bukti pembayaran</li>
                    </ol>
                </div>
                @elseif($paymentMethod === 'transfer')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-semibold text-blue-800 mb-2">Transfer Bank</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bank:</span>
                            <span class="font-medium">BRI</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">No. Rekening:</span>
                            <span class="font-medium">1234-5678-9012-3456</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Atas Nama:</span>
                            <span class="font-medium">JATILAWANG ADVENTURE</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Transfer:</span>
                            <span class="font-medium">
                                Rp {{ number_format($unpaidRentals->sum('total_price') + $unpaidBuys->sum('total_price'), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Upload Proof Form --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Bukti Pembayaran</h3>
                
                @if($unpaidRentals->count() + $unpaidBuys->count() > 1)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-yellow-700">
                        <strong>Perhatian:</strong> Anda memiliki {{ $unpaidRentals->count() + $unpaidBuys->count() }} pesanan yang belum dibayar. 
                        Silakan upload bukti pembayaran untuk masing-masing pesanan.
                    </p>
                </div>
                @endif

                {{-- Form untuk setiap order --}}
                @foreach($unpaidRentals as $rental)
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-gray-700 mb-3">Upload untuk SEWA-{{ $rental->rental_id }}</h4>
                    <form action="{{ route('payment.upload-proof') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="order_type" value="rental">
                        <input type="hidden" name="order_id" value="{{ $rental->rental_id }}">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                            <input type="file" name="payment_proof" 
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                   required>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        </div>

                        <button type="submit" 
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-6 rounded-lg font-semibold transition">
                            Konfirmasi Pembayaran untuk SEWA-{{ $rental->rental_id }}
                        </button>
                    </form>
                </div>
                @endforeach

                @foreach($unpaidBuys as $buy)
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-gray-700 mb-3">Upload untuk BELI-{{ $buy->buy_id }}</h4>
                    <form action="{{ route('payment.upload-proof') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="order_type" value="buy">
                        <input type="hidden" name="order_id" value="{{ $buy->buy_id }}">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                            <input type="file" name="payment_proof" 
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                   required>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        </div>

                        <button type="submit" 
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-6 rounded-lg font-semibold transition">
                            Konfirmasi Pembayaran untuk BELI-{{ $buy->buy_id }}
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Info Box --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Mohon Menunggu Verifikasi</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Setelah upload bukti pembayaran, admin akan memverifikasi pembayaran Anda. Status pesanan akan diperbarui dalam 1x24 jam.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection