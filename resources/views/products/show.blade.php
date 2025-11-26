@extends('layouts.public')

@section('title', ($item->item_name ?? 'Produk') . ' - Jatilawang Adventure')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
    $productImage = $item->url_image ?? ($item->img ?? null
        ? asset('storage/foto-produk/' . $item->img)
        : asset('storage/foto-produk/default.png'));
@endphp

<section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6">
            <ol class="flex items-center gap-2">
                <li>
                    <a href="#" onclick="goBack()" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7M3 12h18"/>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="/" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900">
                        Beranda
                    </a>
                </li>
                <li class="mx-1">/</li>
                <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">Produk</a></li>
                <li class="mx-1">/</li>
                <li class="font-semibold text-gray-900">{{ $item->item_name ?? '' }}</li>
            </ol>
        </nav>

        {{-- MAIN CONTENT --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- Left: Large product image --}}
            <div class="flex items-center justify-center p-6 lg:p-12">
                <div class="w-full max-w-[560px]">
                    <img src="{{ $productImage }}" alt="{{ $item->item_name ?? '' }}" class="w-full h-auto object-contain">
                </div>
            </div>

            {{-- Right: Product info and controls --}}
            <div class="pt-6 lg:pt-12">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                    {{ $item->item_name ?? '' }}
                </h1>

                {{-- Prices --}}
                <div class="mb-6">
                    @if($item->is_rentable)
                    <p class="text-2xl font-semibold text-emerald-900 mb-2">
                        Rp{{ number_format($item->rental_price_per_day ?? 0, 0, ',', '.') }} <small class="text-sm text-gray-600">/hari</small>
                    </p>
                    @endif
                    
                    @if($item->is_sellable)
                    <p class="text-2xl font-semibold text-orange-600">
                        Rp{{ number_format($item->sale_price ?? 0, 0, ',', '.') }} <small class="text-sm text-gray-600">(Beli)</small>
                    </p>
                    @endif
                </div>

                {{-- Days pills (interactive)
                @if($item->is_rentable && $item->rental_stock > 0)
                <div class="mb-4">
                    <p class="font-medium text-gray-800 mb-2">Sewa Berapa Hari :</p>
                    <div class="flex flex-wrap gap-2" id="days-selector">
                        @for ($i = 1; $i <= 6; $i++)
                            <button type="button" class="day-btn px-3 py-1.5 border rounded-md text-sm text-gray-700 bg-emerald-50" 
                                    data-days="{{ $i }}" aria-pressed="{{ $i === 1 ? 'true' : 'false' }}">{{ $i }}</button>
                        @endfor
                    </div>
                    <input type="hidden" id="selectedDays" name="days" value="1">
                </div>
                @endif --}}

                {{-- Material (optional) --}}
                @if($item->material ?? false)
                <div class="mb-6">
                    <div class="bg-gray-100 rounded-md p-3 text-sm text-gray-700">
                        Bahan<br><span class="font-medium">{{ $item->material }}</span>
                    </div>
                </div>
                @endif

                {{-- Short description --}}
                <p class="text-gray-600 leading-relaxed mb-6">
                    {{ $item->description ?? 'Tidak ada deskripsi.' }}
                </p>

                {{-- Total price calculation --}}
                @php
                    $rentalPrice = $item->rental_price_per_day ?? 0;
                    $salePrice = $item->sale_price ?? 0;
                @endphp

                {{-- Quantity controls - Hanya tampil untuk customer --}}
                @auth
                    @if(Auth::user()->role === 'customer')
                        <div class="flex items-center gap-6 mb-6">
                            <div class="inline-flex items-center gap-2" id="qty-control">
                                <button type="button" class="qty-btn decrement w-9 h-9 bg-white border rounded-md text-lg" aria-label="Kurangi">-</button>
                                <div id="qty-display" class="w-10 text-center font-medium">1</div>
                                <button type="button" class="qty-btn increment w-9 h-9 bg-white border rounded-md text-lg" aria-label="Tambah">+</button>
                                <input type="hidden" id="selectedQty" name="qty" value="1">
                            </div>

                            <div class="text-gray-800 text-lg font-semibold">
                                @if($item->is_rentable && $item->rental_stock > 0)
                                    Total Harga: <span id="totalPrice" class="text-emerald-800">
                                        Rp {{ number_format($rentalPrice, 0, ',', '.') }}
                                    </span>
                                @elseif($item->is_sellable && $item->sale_stock > 0)
                                    Total Harga: <span id="totalPrice" class="text-orange-600">
                                        Rp {{ number_format($salePrice, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Tampilkan untuk guest --}}
                    <div class="flex items-center gap-6 mb-6">
                        <div class="inline-flex items-center gap-2" id="qty-control">
                            <button type="button" class="qty-btn decrement w-9 h-9 bg-white border rounded-md text-lg" aria-label="Kurangi">-</button>
                            <div id="qty-display" class="w-10 text-center font-medium">1</div>
                            <button type="button" class="qty-btn increment w-9 h-9 bg-white border rounded-md text-lg" aria-label="Tambah">+</button>
                            <input type="hidden" id="selectedQty" name="qty" value="1">
                        </div>

                        <div class="text-gray-800 text-lg font-semibold">
                            @if($item->is_rentable && $item->rental_stock > 0)
                                Total Sewa: <span id="totalPrice" class="text-emerald-800">
                                    Rp {{ number_format($rentalPrice, 0, ',', '.') }}
                                </span>
                            @elseif($item->is_sellable && $item->sale_stock > 0)
                                Total Beli: <span id="totalPrice" class="text-orange-600">
                                    Rp {{ number_format($salePrice, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endauth

                {{-- Action buttons --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mt-6">
                    @auth
                        {{-- Untuk Customer --}}
                        @if(Auth::user()->role === 'customer')
                            {{-- RENT BUTTON --}}
                            @if($item->is_rentable && $item->rental_stock > 0)
                            <form action="{{ route('cart.store') }}" method="POST" class="w-full sm:w-48">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                                <input type="hidden" name="type" value="rent">
                                <input type="hidden" name="quantity" id="rentQuantity" value="1">
                                <input type="hidden" name="days" id="rentDays" value="1">
                                <button type="submit" class="w-full bg-emerald-900 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-emerald-800 transition flex items-center justify-center gap-2">
                                    Masukkan Keranjang (Sewa)
                                </button>
                            </form>
                            @endif

                            {{-- BUY BUTTON --}}
                            @if($item->is_sellable && $item->sale_stock > 0)
                            <form action="{{ route('cart.store') }}" method="POST" class="w-full sm:w-48">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                                <input type="hidden" name="type" value="buy">
                                <input type="hidden" name="quantity" id="buyQuantity" value="1">
                                <button type="submit" class="w-full bg-orange-600 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-orange-700 transition flex items-center justify-center gap-2">
                                    Masukkan Keranjang (Beli)
                                </button>
                            </form>
                            @endif
                        @else
                            {{-- Untuk Admin - Tampilkan pesan info --}}
                            <div class="w-full bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-blue-800">Anda login sebagai Admin</p>
                                        <p class="text-xs text-blue-600 mt-1">Fitur keranjang tidak tersedia untuk akun admin.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        {{-- Untuk Guest --}}
                        {{-- RENT BUTTON --}}
                        @if($item->is_rentable && $item->rental_stock > 0)
                        <form action="{{ route('cart.store') }}" method="POST" class="w-full sm:w-48">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                            <input type="hidden" name="type" value="rent">
                            <input type="hidden" name="quantity" id="rentQuantity" value="1">
                            <input type="hidden" name="days" id="rentDays" value="1">
                            <button type="submit" class="w-full bg-emerald-900 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-emerald-800 transition flex items-center justify-center gap-2">
                                Masukkan Keranjang (Sewa)
                            </button>
                        </form>
                        @endif

                        {{-- BUY BUTTON --}}
                        @if($item->is_sellable && $item->sale_stock > 0)
                        <form action="{{ route('cart.store') }}" method="POST" class="w-full sm:w-48">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                            <input type="hidden" name="type" value="buy">
                            <input type="hidden" name="quantity" id="buyQuantity" value="1">
                            <button type="submit" class="w-full bg-orange-600 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-orange-700 transition flex items-center justify-center gap-2">
                                Masukkan Keranjang (Beli)
                            </button>
                        </form>
                        @endif
                    @endauth
                </div>

                {{-- Stock badge --}}
                @if($item->rental_stock ?? false || $item->sale_stock ?? false)
                    <div class="mt-6 inline-flex items-center gap-3 text-sm text-gray-600">
                        <span class="p-3 bg-gray-100 rounded-md">Stok</span>
                        <span>
                            @if($item->is_rentable && $item->is_sellable)
                                Sewa: <strong>{{ $item->rental_stock }}</strong>, 
                                Beli: <strong>{{ $item->sale_stock }}</strong>
                            @elseif($item->is_rentable)
                                Tersedia: <strong>{{ $item->rental_stock }}</strong>
                            @else
                                Tersedia: <strong>{{ $item->sale_stock }}</strong>
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- DETAILS CARD --}}
@php
    $detailsId = $item->item_id ?? \Illuminate\Support\Str::slug($item->item_name ?? 'product');
    $detailsRaw = $item->long_description ?? $item->description ?? '';
    $detailsThreshold = 420;
    $detailsIsLong = mb_strlen(trim($detailsRaw)) > $detailsThreshold;
    $detailsHtml = $detailsRaw ? nl2br(e($detailsRaw)) : 'Belum ada deskripsi lengkap.';
@endphp

<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="details-card">
            <h2 class="details-title">Detail Produk</h2>

            <div class="details-wrapper {{ $detailsIsLong ? '' : 'expanded' }}" id="details-wrapper-{{ $detailsId }}">
                <div class="details-body" id="details-body-{{ $detailsId }}">
                    {!! $detailsHtml !!}
                </div>
                @if($detailsIsLong)
                    <div class="details-fade" id="details-fade-{{ $detailsId }}"></div>
                @endif
            </div>

            @if($detailsIsLong)
                <button type="button" class="details-btn" id="details-toggle-{{ $detailsId }}" aria-controls="details-body-{{ $detailsId }}" aria-expanded="false">
                    <span class="details-btn-text">Lihat Lebih Banyak</span>
                    <span class="details-caret">Down</span>
                </button>
            @endif
        </div>
    </div>
</section>

<style>
    .details-card{background:#fff;border:1px solid #eee;border-radius:16px;padding:28px 32px;margin:0 auto;box-shadow:0 2px 8px rgba(0,0,0,.04)}
    .details-title{font-size:28px;font-weight:700;margin:0 0 16px}
    .details-wrapper{position:relative;overflow:hidden}
    .details-body{color:#6b7280;line-height:1.75;max-height:120px;overflow:hidden;transition:max-height .25s ease}
    .details-fade{content:"";position:absolute;left:0;right:0;bottom:0;height:72px;background:linear-gradient(to bottom, rgba(255,255,255,0) 0%, #fff 70%)}
    .details-btn{display:inline-flex;align-items:center;gap:.5rem;margin:18px auto 0;cursor:pointer;border:1px solid #d1d5db;border-radius:12px;padding:12px 18px;background:#fff;font-weight:600}
    .details-btn:hover{background:#f9fafb}
    .details-caret{display:inline-block;transition:transform .2s ease}
    .details-wrapper.expanded .details-body{max-height:9999px}
    .details-wrapper.expanded .details-fade{display:none}
    .details-wrapper.expanded + .details-btn .details-caret{transform:rotate(180deg)}

    .day-btn{background:#ecfdf3;color:#065f46;border-color:transparent;cursor:pointer}
    .day-btn:hover{filter:brightness(.98)}
    .day-btn.active{background:#064e3b;color:#fff;border-color:#064e3b}
</style>

<div id="product-data" 
     data-rent-price="{{ $rentalPrice }}" 
     data-sale-price="{{ $salePrice }}"
     style="display:none"></div>

<script>
    function formatRupiah(num){
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function getBasePrice(){
        const productData = document.getElementById('product-data');
        const isRentable = {{ $item->is_rentable && $item->rental_stock > 0 ? 'true' : 'false' }};
        
        if (isRentable) {
            return Number(productData.dataset.rentPrice);
        } else {
            return Number(productData.dataset.salePrice);
        }
    }

    function updateTotals(){
        const days = Number(document.getElementById('selectedDays')?.value) || 1;
        const qty = Number(document.getElementById('qty-display').textContent) || 1;
        const basePrice = getBasePrice();
        
        // Update hidden inputs
        document.getElementById('rentQuantity')?.setAttribute('value', qty);
        document.getElementById('buyQuantity')?.setAttribute('value', qty);
        
        // Calculate total
        let total = basePrice * qty;
        
        // Jika rental, kalikan dengan days
        if (document.getElementById('selectedDays')) {
            total = basePrice * days * qty;
        }
        
        document.getElementById('totalPrice').textContent = formatRupiah(total);
    }

    document.addEventListener('DOMContentLoaded', function(){
        // Days selector
        document.querySelectorAll('.day-btn').forEach(btn => {
            if(btn.getAttribute('aria-pressed') === 'true'){
                btn.classList.add('active');
            }
            btn.addEventListener('click', function(){
                document.querySelectorAll('.day-btn').forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-pressed', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-pressed', 'true');
                document.getElementById('selectedDays').value = this.dataset.days;
                document.getElementById('rentDays').value = this.dataset.days;
                updateTotals();
            });
        });

        // Quantity controls - hanya jika ada
        const decrementBtn = document.querySelector('.qty-btn.decrement');
        const incrementBtn = document.querySelector('.qty-btn.increment');
        
        if (decrementBtn && incrementBtn) {
            decrementBtn.addEventListener('click', () => {
                let qty = Math.max(1, Number(document.getElementById('qty-display').textContent) - 1);
                document.getElementById('qty-display').textContent = qty;
                document.getElementById('selectedQty').value = qty;
                updateTotals();
            });

            incrementBtn.addEventListener('click', () => {
                let qty = Number(document.getElementById('qty-display').textContent) + 1;
                document.getElementById('qty-display').textContent = qty;
                document.getElementById('selectedQty').value = qty;
                updateTotals();
            });
        }

        // Details toggle
        (function(){
            const id = "{{ $detailsId }}";
            const wrapper = document.getElementById("details-wrapper-"+id);
            const btn = document.getElementById("details-toggle-"+id);
            if(!btn || !wrapper) return;
            btn.addEventListener("click", function(){
                const expanded = wrapper.classList.toggle("expanded");
                btn.setAttribute("aria-expanded", expanded);
                btn.querySelector(".details-btn-text").textContent = expanded ? "Lihat Lebih Sedikit" : "Lihat Lebih Banyak";
            });
        })();

        updateTotals();
    });
</script>

<script>
function goBack() {
    window.history.back();
}
</script>

{{-- Reviews & Related Products --}}
@include('products.partials.reviews', ['item' => $item])
@include('products.partials.related', ['relatedProducts' => $relatedProducts ?? []])



@endsection