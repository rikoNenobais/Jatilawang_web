@extends('layouts.layout-admin')

@section('title', 'Detail Review')
@section('header', 'Detail Review')

@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.reviews.index') }}" 
                   class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Review
                </a>
            </div>
            
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Review</h1>
                    <p class="text-sm text-gray-600 mt-1">Informasi lengkap review dari pengguna</p>
                </div>
                
                <div class="flex gap-2">
                    <form action="{{ route('admin.reviews.destroy', $rating) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Review
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            {{-- Review Header --}}
            <div class="border-b border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                            {{ substr($rating->user->full_name ?? $rating->user->username ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">
                                {{ $rating->user->full_name ?? $rating->user->username ?? 'User #'.$rating->user_id }}
                            </h2>
                            <p class="text-gray-600 mt-1">{{ $rating->user->email ?? '-' }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                    User ID: {{ $rating->user_id }}
                                </span>
                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                    Review ID: {{ $rating->rating_id }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Dibuat pada</div>
                        <div class="font-semibold text-gray-900">
                            {{ Carbon::parse($rating->created_at)->format('d M Y') }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ Carbon::parse($rating->created_at)->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Review Content --}}
            <div class="p-6 space-y-6">
                {{-- Rating --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Rating</h3>
                    <div class="flex items-center gap-3">
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $rating->rating_value)
                                    <svg class="h-8 w-8 text-amber-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="h-8 w-8 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-2xl font-bold text-gray-900">
                            {{ $rating->rating_value }}/5
                        </span>
                    </div>
                </div>

                {{-- Komentar --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Komentar</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        @if($rating->comment)
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $rating->comment }}</p>
                        @else
                            <p class="text-gray-500 italic">Tidak ada komentar</p>
                        @endif
                    </div>
                </div>

                {{-- Informasi Produk --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Informasi Produk</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900 text-lg">
                                    {{ $rating->item->item_name ?? 'Produk #'.$rating->item_id }}
                                </h4>
                                <p class="text-gray-600 mt-1">
                                    {{ $rating->item->description ?? 'Deskripsi tidak tersedia' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Item ID</div>
                                <div class="font-semibold text-gray-900">{{ $rating->item_id }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Order --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Informasi Order</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @if($rating->rental_id)
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-blue-800">Sewa</span>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-blue-700">Rental ID:</span>
                                        <span class="font-semibold">#{{ $rating->rental_id }}</span>
                                    </div>
                                    @if($rating->rental)
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Status:</span>
                                            <span class="font-semibold capitalize">{{ $rating->rental->order_status ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Tanggal Mulai:</span>
                                            <span class="font-semibold">
                                                {{ $rating->rental->rental_start_date ? Carbon::parse($rating->rental->rental_start_date)->format('d M Y') : '-' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">Tanggal Selesai:</span>
                                            <span class="font-semibold">
                                                {{ $rating->rental->rental_end_date ? Carbon::parse($rating->rental->rental_end_date)->format('d M Y') : '-' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($rating->buy_id)
                            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="p-2 bg-green-100 rounded-lg">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-green-800">Beli</span>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-green-700">Buy ID:</span>
                                        <span class="font-semibold">#{{ $rating->buy_id }}</span>
                                    </div>
                                    @if($rating->buy)
                                        <div class="flex justify-between">
                                            <span class="text-green-700">Status:</span>
                                            <span class="font-semibold capitalize">{{ $rating->buy->order_status ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-green-700">Total:</span>
                                            <span class="font-semibold">
                                                Rp {{ number_format($rating->buy->total_amount ?? 0, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Informasi Transaksi --}}
                @if($rating->transaction_id)
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Informasi Transaksi</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Transaction ID:</span>
                                <p class="font-semibold">#{{ $rating->transaction_id }}</p>
                            </div>
                            @if($rating->transaction)
                            <div>
                                <span class="text-gray-600">Total Amount:</span>
                                <p class="font-semibold">Rp {{ number_format($rating->transaction->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Status Pembayaran:</span>
                                <p class="font-semibold capitalize">{{ str_replace('_', ' ', $rating->transaction->payment_status) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection