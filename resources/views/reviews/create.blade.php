@extends('layouts.public')

@section('title', 'Beri Review - Jatilawang Adventure')

@section('content')
{{-- BACKGROUND FOTO UNTUK SELURUH HALAMAN --}}
<div class="fixed inset-0 -z-10">
    <img src="{{ asset('storage/hero/peaks.jpg') }}" 
        alt="Pegunungan Jatilawang Adventure" 
        class="w-full h-full object-cover">
    {{-- Overlay Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/80 via-emerald-800/70 to-teal-700/80"></div>
</div>

{{-- Efek Blur --}}
<div class="pointer-events-none absolute -top-40 -left-40 h-[700px] w-[700px] rounded-full bg-emerald-900/20 blur-3xl -z-10"></div>

{{-- Konten Utama --}}
<section class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            {{-- Header --}}
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Beri Review Produk</h1>
                <p class="text-gray-600 mt-2">Bagikan pengalaman Anda menggunakan produk kami</p>
            </div>

            {{-- Order Info --}}
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-gray-900 mb-2">Detail Pesanan</h3>
                @if($type === 'rental')
                    <p class="text-sm text-gray-600">Sewa - SEWA-{{ $order->rental_id }}</p>
                    <p class="text-sm text-gray-600">
                        Periode: {{ \Carbon\Carbon::parse($order->rental_start_date)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($order->rental_end_date)->format('d M Y') }}
                    </p>
                @else
                    <p class="text-sm text-gray-600">Beli - BELI-{{ $order->buy_id }}</p>
                @endif
            </div>

            {{-- Products List --}}
            <div class="space-y-4">
                @if($type === 'rental')
                    @foreach($order->details as $detail)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <form action="{{ route('reviews.store', [$type, $order->{$type . '_id'}]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $detail->item_id }}">
                            
                            <div class="flex items-start gap-4">
                                {{-- Product Info --}}
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $detail->item->item_name }}</h4>
                                    <p class="text-sm text-gray-600">Qty: {{ $detail->quantity }}</p>
                                    
                                    {{-- Rating Stars --}}
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Beri Rating
                                        </label>
                                        <div class="flex items-center gap-1" id="stars-{{ $detail->item_id }}">
                                            @for($i = 1; $i <= 5; $i++)
                                            <button type="button" 
                                                    data-rating="{{ $i }}"
                                                    class="text-2xl focus:outline-none star-rating"
                                                    data-target="{{ $detail->item_id }}">
                                                <span class="star-{{ $detail->item_id }}-{{ $i }}">☆</span>
                                            </button>
                                            @endfor
                                            <input type="hidden" name="rating_value" id="rating-value-{{ $detail->item_id }}" value="0" required>
                                        </div>
                                        @error('rating_value')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Comment --}}
                                    <div class="mt-3">
                                        <label for="comment-{{ $detail->item_id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                            Ulasan (opsional)
                                        </label>
                                        <textarea name="comment" id="comment-{{ $detail->item_id }}" rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                  placeholder="Bagikan pengalaman Anda menggunakan produk ini..."></textarea>
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="mt-4">
                                        <button type="submit"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                            Kirim Review
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                @else
                    @foreach($order->detailBuys as $detail)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <form action="{{ route('reviews.store', [$type, $order->{$type . '_id'}]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $detail->item_id }}">
                            
                            <div class="flex items-start gap-4">
                                {{-- Product Info --}}
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $detail->item->item_name }}</h4>
                                    <p class="text-sm text-gray-600">Qty: {{ $detail->quantity }}</p>
                                    
                                    {{-- Rating Stars --}}
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Beri Rating
                                        </label>
                                        <div class="flex items-center gap-1" id="stars-{{ $detail->item_id }}">
                                            @for($i = 1; $i <= 5; $i++)
                                            <button type="button" 
                                                    data-rating="{{ $i }}"
                                                    class="text-2xl focus:outline-none star-rating"
                                                    data-target="{{ $detail->item_id }}">
                                                <span class="star-{{ $detail->item_id }}-{{ $i }}">☆</span>
                                            </button>
                                            @endfor
                                            <input type="hidden" name="rating_value" id="rating-value-{{ $detail->item_id }}" value="0" required>
                                        </div>
                                        @error('rating_value')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Comment --}}
                                    <div class="mt-3">
                                        <label for="comment-{{ $detail->item_id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                            Ulasan (opsional)
                                        </label>
                                        <textarea name="comment" id="comment-{{ $detail->item_id }}" rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                                  placeholder="Bagikan pengalaman Anda menggunakan produk ini..."></textarea>
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="mt-4">
                                        <button type="submit"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                            Kirim Review
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                @endif
            </div>

            {{-- Back Button --}}
            <div class="mt-6 text-center">
                <a href="{{ route('profile.orders') }}" 
                   class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                    ← Kembali ke Riwayat Pesanan
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Star Rating System
    document.querySelectorAll('.star-rating').forEach(button => {
        button.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            const target = this.getAttribute('data-target');
            const starsContainer = document.getElementById(`stars-${target}`);
            
            // Update stars visual
            starsContainer.querySelectorAll('button').forEach((star, index) => {
                const starIndex = index + 1;
                const starSpan = star.querySelector(`.star-${target}-${starIndex}`);
                if (starIndex <= rating) {
                    starSpan.textContent = '★';
                    starSpan.className = `star-${target}-${starIndex} text-yellow-400`;
                } else {
                    starSpan.textContent = '☆';
                    starSpan.className = `star-${target}-${starIndex} text-gray-300`;
                }
            });
            
            // Update hidden input value
            document.getElementById(`rating-value-${target}`).value = rating;
        });
    });

    // Form validation
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const ratingValue = this.querySelector('input[name="rating_value"]').value;
            if (ratingValue === '0') {
                e.preventDefault();
                alert('Silakan beri rating terlebih dahulu!');
            }
        });
    });
});
</script>

<style>
.star-rating:hover {
    transform: scale(1.2);
    transition: transform 0.2s;
}
</style>
@endsection