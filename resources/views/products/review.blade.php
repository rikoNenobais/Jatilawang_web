@extends('layouts.public')

@section('title', 'Ulasan Produk - ' . ($product->item_name ?? ''))
@section('header', 'Ulasan Produk')

@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
        
        <div class="flex items-center gap-4 mb-6">
            @if($product->url_image)
            <img src="{{ $product->url_image }}" alt="{{ $product->item_name }}" 
                 class="w-16 h-16 object-cover rounded-lg">
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $product->item_name }}</h1>
                <p class="text-gray-600">Lihat semua ulasan untuk produk ini</p>
            </div>
        </div>
    </div>

    {{-- Rating Summary --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-8">
            {{-- Average Rating --}}
            <div class="text-center lg:text-left">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-6">
                    <div class="text-5xl font-bold text-gray-900 mb-1">{{ number_format($stats['avg'], 1) }}</div>
                    <div class="flex justify-center lg:justify-start gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 {{ $i <= round($stats['avg']) ? 'text-amber-400 fill-current' : 'text-gray-300 fill-current' }}" 
                                 viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold">{{ $stats['total'] }}</span> ulasan
                    </div>
                </div>
            </div>

            {{-- Rating Distribution --}}
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-gray-900 mb-4">Distribusi Rating</h3>
                <div class="space-y-3">
                    @for($star = 5; $star >= 1; $star--)
                        @php
                            $count = $stats['counts'][$star] ?? 0;
                            $percentage = $stats['total'] > 0 ? round(($count / $stats['total']) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2 w-20">
                                <span class="text-sm font-medium text-gray-900">{{ $star }}</span>
                                <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div class="flex-1 bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="bg-amber-400 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="w-16 text-right">
                                <span class="text-sm font-medium text-gray-900">{{ $count }}</span>
                                <span class="text-xs text-gray-500 ml-1">({{ $percentage }}%)</span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    {{-- Reviews List --}}
    <div class="space-y-6">
        @forelse($reviews as $review)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                {{-- Review Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr($review->user->full_name ?? $review->user->username ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">
                                {{ $review->user->full_name ?? $review->user->username ?? 'Pengguna' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ Carbon::parse($review->created_at)->locale('id')->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    </div>
                    
                    {{-- Rating Stars --}}
                    <div class="flex items-center gap-2">
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating_value ? 'text-amber-400 fill-current' : 'text-gray-300 fill-current' }}" 
                                     viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $review->rating_value }}/5</span>
                    </div>
                </div>

                {{-- Review Comment --}}
                @if($review->comment)
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $review->comment }}
                    </div>
                @else
                    <div class="text-gray-500 italic">
                        Tidak ada komentar tambahan
                    </div>
                @endif

                {{-- Order Info --}}
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex flex-wrap gap-2">
                        @if($review->rental_id)
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                Sewa #{{ $review->rental_id }}
                            </span>
                        @elseif($review->buy_id)
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                Beli #{{ $review->buy_id }}
                            </span>
                        @endif
                        <span class="text-xs text-gray-500">
                            Diberikan pada {{ Carbon::parse($review->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-4 text-gray-300">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada ulasan</h3>
                <p class="text-gray-500">Jadilah yang pertama memberikan ulasan untuk produk ini</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($reviews->hasPages())
        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection