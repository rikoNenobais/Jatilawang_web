@extends('layouts.public')

@section('title', 'Keranjang - Jatilawang Adventure')

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

    {{-- ===================== CART SECTION ===================== --}}

    <section class="min-h-screen py-8 relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Keranjang Belanja</h1>
            <p class="text-emerald-200 mt-2">Kelola produk yang ingin Anda sewa atau beli</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2">
                {{-- RENTAL SECTION --}}
                @if($rentalItems->count() > 0)
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-8 bg-emerald-500 rounded"></div>
                        <h2 class="text-xl font-bold text-white">Produk Disewa</h2>
                        <span class="px-2 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full">
                            {{ $rentalItems->count() }} item
                        </span>
                    </div>

                    @foreach($rentalItems as $cartItem)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            {{-- Product Image --}}
                            <div class="flex-shrink-0">
                                <img src="{{ $cartItem->item->url_image ?? 'https://via.placeholder.com/120' }}" 
                                     alt="{{ $cartItem->item->item_name }}" 
                                     class="w-24 h-24 object-cover rounded-lg">
                            </div>

                            {{-- Product Info & Controls --}}
                            <div class="flex-grow">
                                <div class="flex flex-col sm:flex-row justify-between">
                                    {{-- Product Details --}}
                                    <div class="flex-grow">
                                        <h3 class="font-semibold text-lg text-gray-900 mb-1">
                                            {{ $cartItem->item->item_name }}
                                        </h3>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800">
                                                Sewa • {{ $cartItem->days }} hari
                                            </span>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-3">
                                            Stok sewa: {{ $cartItem->item->rental_stock }} tersedia
                                        </p>
                                    </div>

                                    {{-- Price --}}
                                    <div class="flex-shrink-0 text-right mb-4 sm:mb-0">
                                        <p class="text-lg font-semibold text-gray-900">
                                            Rp {{ number_format($cartItem->total_price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Rp {{ number_format($cartItem->unit_price, 0, ',', '.') }}/hari
                                        </p>
                                    </div>
                                </div>

                                {{-- Quantity Controls --}}
                                <div class="flex items-center justify-between mt-4">
                                    <form action="{{ route('cart.update', $cartItem->cart_item_id) }}" method="POST" class="flex items-center gap-3">
                                        @csrf @method('PATCH')
{{--                                         
                                        <div class="flex items-center gap-2">
                                            <label class="text-sm text-gray-600">Hari:</label>
                                            <input type="number" name="days" value="{{ $cartItem->days }}" min="1" 
                                                  class="w-16 px-2 py-1 border border-gray-300 rounded text-sm">
                                        </div> --}}

                                        <div class="flex items-center gap-2">
                                            <label class="text-sm text-gray-600">Qty:</label>
                                            <div class="flex border border-gray-300 rounded">
                                                <button type="button" class="decrement-btn w-8 h-8 flex items-center justify-center hover:bg-gray-100">-</button>
                                                <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" 
                                                      class="w-12 text-center border-x border-gray-300">
                                                <button type="button" class="increment-btn w-8 h-8 flex items-center justify-center hover:bg-gray-100">+</button>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Remove Button --}}
                                    <form action="{{ route('cart.destroy', $cartItem->cart_item_id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- PURCHASE SECTION --}}
                @if($purchaseItems->count() > 0)
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-8 bg-orange-500 rounded"></div>
                        <h2 class="text-xl font-bold text-white">Produk Dibeli</h2>
                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                            {{ $purchaseItems->count() }} item
                        </span>
                    </div>

                    @foreach($purchaseItems as $cartItem)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            {{-- Product Image --}}
                            <div class="flex-shrink-0">
                                <img src="{{ $cartItem->item->url_image ?? 'https://via.placeholder.com/120' }}" 
                                     alt="{{ $cartItem->item->item_name }}" 
                                     class="w-24 h-24 object-cover rounded-lg">
                            </div>

                            {{-- Product Info & Controls --}}
                            <div class="flex-grow">
                                <div class="flex flex-col sm:flex-row justify-between">
                                    {{-- Product Details --}}
                                    <div class="flex-grow">
                                        <h3 class="font-semibold text-lg text-gray-900 mb-1">
                                            {{ $cartItem->item->item_name }}
                                        </h3>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                                Beli
                                            </span>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-3">
                                            Stok beli: {{ $cartItem->item->sale_stock }} tersedia
                                        </p>
                                    </div>

                                    {{-- Price --}}
                                    <div class="flex-shrink-0 text-right mb-4 sm:mb-0">
                                        <p class="text-lg font-semibold text-gray-900">
                                            Rp {{ number_format($cartItem->total_price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Satuan: Rp {{ number_format($cartItem->unit_price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Quantity Controls --}}
                                <div class="flex items-center justify-between mt-4">
                                    <form action="{{ route('cart.update', $cartItem->cart_item_id) }}" method="POST" class="flex items-center gap-3">
                                        @csrf @method('PATCH')
                                        
                                        <div class="flex items-center gap-2">
                                            <label class="text-sm text-gray-600">Qty:</label>
                                            <div class="flex border border-gray-300 rounded">
                                                <button type="button" class="decrement-btn w-8 h-8 flex items-center justify-center hover:bg-gray-100">-</button>
                                                <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" 
                                                      class="w-12 text-center border-x border-gray-300">
                                                <button type="button" class="increment-btn w-8 h-8 flex items-center justify-center hover:bg-gray-100">+</button>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Remove Button --}}
                                    <form action="{{ route('cart.destroy', $cartItem->cart_item_id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- EMPTY STATE --}}
                @if($rentalItems->count() == 0 && $purchaseItems->count() == 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="text-6xl mb-4">🛒</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Kosong</h3>
                    <p class="text-gray-600 mb-6">Belum ada produk di keranjang Anda</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">
                        Jelajahi Produk
                    </a>
                </div>
                @endif
            </div>

            {{-- Order Summary --}}
            @if($rentalItems->count() > 0 || $purchaseItems->count() > 0)
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                    
                    {{-- Rental Summary --}}
                    @if($rentalItems->count() > 0)
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                            <span class="text-sm font-medium text-gray-700">Sewa</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal Sewa</span>
                                <span>Rp {{ number_format($rentalSubtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>{{ $rentalItems->count() }} produk</span>
                                <span>{{ $rentalItems->sum('quantity') }} item</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Purchase Summary --}}
                    @if($purchaseItems->count() > 0)
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                            <span class="text-sm font-medium text-gray-700">Beli</span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal Beli</span>
                                <span>Rp {{ number_format($purchaseSubtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>{{ $purchaseItems->count() }} produk</span>
                                <span>{{ $purchaseItems->sum('quantity') }} item</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Total Summary --}}
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Item</span>
                            <span>{{ $rentalItems->count() + $purchaseItems->count() }} produk</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Total Kuantitas</span>
                            <span>{{ $rentalItems->sum('quantity') + $purchaseItems->sum('quantity') }} item</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between text-lg font-semibold text-gray-900">
                            <span>Total</span>
                            <span>Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
            
                    <a href="{{ route('checkout.show') }}" 
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-4 rounded-lg font-semibold text-lg transition text-center block">
                        Lanjut ke Pembayaran
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls in cart - auto submit
    document.querySelectorAll('.increment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input[name="quantity"]');
            input.value = parseInt(input.value) + 1;
            this.closest('form').submit(); // Auto submit
        });
    });

    document.querySelectorAll('.decrement-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input[name="quantity"]');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                this.closest('form').submit(); // Auto submit
            }
        });
    });

    // Auto submit when days input changes
    document.querySelectorAll('input[name="days"]').forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endsection