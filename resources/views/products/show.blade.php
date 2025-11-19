@extends('layouts.public')

@section('title', ($product['name'] ?? 'Product') . ' - Jatilawang Adventure')

@section('content')
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6">
            <ol class="flex items-center gap-2">
                <li>
                    <a href="/" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7M3 12h18"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li class="mx-1">/</li>
                <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">Produk</a></li>
                <li class="mx-1">/</li>
                <li class="font-semibold text-gray-900">{{ $product['name'] ?? '' }}</li>
            </ol>
        </nav>

        {{-- MAIN CONTENT --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- Left: Large product image --}}
            <div class="flex items-center justify-center p-6 lg:p-12">
                <div class="w-full max-w-[560px]">
                    <img src="{{ $product['img_url'] ?? asset('storage/foto-produk/' . ($product['img'] ?? '')) }}" alt="{{ $product['name'] ?? '' }}" class="w-full h-auto object-contain">
                </div>
            </div>

            {{-- Right: Product info and controls --}}
            <div class="pt-6 lg:pt-12">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">{{ $product['name'] ?? '' }}</h1>

                <p class="text-2xl font-semibold text-emerald-900 mb-6">{{ $product['price'] ?? '' }}</p>

                {{-- Sizes (selectable) --}}
                <div class="flex flex-wrap gap-3 mb-4" id="size-selector">
                    @foreach([39,40,41,42,43] as $size)
                        <button type="button" class="size-btn px-4 py-2 border rounded-md text-sm text-gray-700 bg-white" data-size="{{ $size }}" aria-pressed="false">{{ $size }}</button>
                    @endforeach
                    <input type="hidden" id="selectedSize" name="size" value="{{ $product['size'] ?? 40 }}">
                </div>

                {{-- Days pills (interactive) --}}
                <div class="mb-4">
                    <p class="font-medium text-gray-800 mb-2">Sewa Berapa Hari :</p>
                    <div class="flex flex-wrap gap-2" id="days-selector">
                        @for ($i = 1; $i <= 6; $i++)
                            <button type="button" class="day-btn px-3 py-1.5 border rounded-md text-sm text-gray-700 bg-emerald-50" data-days="{{ $i }}" aria-pressed="{{ $i === 1 ? 'true' : 'false' }}">{{ $i }}</button>
                        @endfor
                    </div>
                    <input type="hidden" id="selectedDays" name="days" value="1">
                </div>

                {{-- Material box (optional) --}}
                <div class="mb-6">
                    <div class="bg-gray-100 rounded-md p-3 text-sm text-gray-700">Bahan<br><span class="font-medium">{{ $product['material'] ?? '-' }}</span></div>
                </div>

                {{-- Short description --}}
                <p class="text-gray-600 leading-relaxed mb-6">{{ $product['desc'] ?? '' }}</p>

                {{-- Total price calculation (dynamic: basePrice x days x qty) --}}
                @php
                    $numericPrice = (int) filter_var($product['price'] ?? '0', FILTER_SANITIZE_NUMBER_INT);
                @endphp
                <div class="flex items-center gap-6 mb-6">
                    <div class="inline-flex items-center gap-2" id="qty-control">
                        <button type="button" class="qty-btn decrement inline-flex items-center justify-center w-9 h-9 bg-white border rounded-md text-lg" aria-label="Kurangi jumlah">-</button>
                        <div id="qty-display" class="w-10 text-center font-medium">1</div>
                        <button type="button" class="qty-btn increment inline-flex items-center justify-center w-9 h-9 bg-white border rounded-md text-lg" aria-label="Tambah jumlah">+</button>
                        <input type="hidden" id="selectedQty" name="qty" value="1">
                    </div>

                    <div class="text-gray-800 text-lg font-semibold">Total Sewa: <span id="totalPrice" class="text-emerald-800">Rp {{ number_format($numericPrice, 0, ',', '.') }}</span></div>
                </div>

                {{-- Action buttons --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mt-6">
                    <button class="w-full sm:w-48 flex items-center justify-center gap-2 border border-gray-300 px-5 py-3 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6.5 3.5 5 5.5 5 c1.54 0 3.04.99 3.57 2.36h1.87 C13.46 5.99 14.96 5 16.5 5 18.5 5 20 6.5 20 8.5 c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        Favorit
                    </button>

                    {{-- Form Tambah ke Keranjang --}}
                    <form method="POST" action="{{ route('cart.store') }}" class="w-full sm:w-48">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $product['id'] ?? '' }}">
                        <input type="hidden" name="qty" id="selectedQty" value="1">
                        <button type="submit" class="w-full bg-emerald-900 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-emerald-800 transition">
                            Tambahkan ke Keranjang
                        </button>
                    </form>
                </div>

                {{-- Stock badge (optional) --}}
                @if(isset($product['stock']))
                    <div class="mt-6 inline-flex items-center gap-3 text-sm text-gray-600">
                        <span class="p-3 bg-gray-100 rounded-md">📦</span>
                        <span>Stok <strong>{{ $product['stock'] }}</strong></span>
                    </div>
                @endif

            </div>

        </div>
    </div>
  </div>
</section>

{{-- DETAILS CARD (full-width) --}}
@php
    $detailsId = $product['id'] ?? (isset($product['slug']) ? $product['slug'] : \Illuminate\Support\Str::slug($product['name'] ?? time()));
    $detailsRaw = $product['long_description'] ?? $product['description'] ?? $product['desc'] ?? '';
    $detailsThreshold = 420;
    $detailsIsLong = mb_strlen(trim($detailsRaw)) > $detailsThreshold;
    $detailsHtml = $detailsRaw ? nl2br(e($detailsRaw)) : 'Belum ada deskripsi.';
@endphp
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="details-card">
            <h2 id="details-title-{{ $detailsId }}" class="details-title">Details</h2>

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
                    <span class="details-caret">˅</span>
                </button>
            @endif

        </div>
    </div>
</section>

<style>
    .details-card{background:#fff;border:1px solid #eee;border-radius:16px;padding:28px 32px;margin:0 auto;box-shadow:0 2px 8px rgba(0,0,0,.04)}
    .details-title{font-size:28px;font-weight:700;margin:0 0 16px}
    .details-wrapper{position:relative}
    .details-body{color:#6b7280;line-height:1.75;max-height:120px;overflow:hidden;transition:max-height .25s ease}
    .details-fade{content:"";position:absolute;left:0;right:0;bottom:0;height:72px;background:linear-gradient(to bottom, rgba(255,255,255,0) 0%, #fff 70%)}
    .details-btn{display:inline-flex;align-items:center;gap:.5rem;margin:18px auto 0;cursor:pointer;border:1px solid #d1d5db;border-radius:12px;padding:12px 18px;background:#fff;font-weight:600}
    .details-btn:hover{background:#f9fafb}
    .details-caret{display:inline-block;transition:transform .2s ease}
    .details-wrapper.expanded .details-body{max-height:9999px}
    .details-wrapper.expanded .details-fade{display:none}
    .details-wrapper.expanded + .details-btn .details-caret{transform:rotate(180deg)}

    /* Size & Day button styles */
    .size-btn{cursor:pointer}
    .size-btn.active{border:2px solid #000;background:#fff}

    .day-btn{background:#ecfdf3;color:#065f46;border-color:transparent;cursor:pointer}
    .day-btn:hover{filter:brightness(.98)}
    .day-btn.active{background:#064e3b;color:#fff;border-color:#064e3b}

    /* Quantity controls */
    #qty-control .qty-btn{width:36px;height:36px;padding:0;display:inline-flex;align-items:center;justify-content:center}
    #qty-display{min-width:36px}
</style>

<div id="product-data" data-base-price="{{ $numericPrice ?? 0 }}" style="display:none"></div>

<script>
    function formatRupiah(num){
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function getBasePrice(){
        return Number(document.getElementById('product-data')?.dataset?.basePrice) || 0;
    }

    function updateTotals(){
        const days = Number(document.getElementById('selectedDays')?.value) || 1;
        const qty = Number(document.getElementById('selectedQty')?.value) || 1;
        const total = getBasePrice() * days * qty;
        const el = document.getElementById('totalPrice');
        if(el) el.textContent = formatRupiah(total);
    }

    document.addEventListener('DOMContentLoaded', function(){
        /* Size selector init */
        const sizeBtns = document.querySelectorAll('.size-btn');
        const selectedSizeInput = document.getElementById('selectedSize');
        if(sizeBtns.length && selectedSizeInput){
            const selected = selectedSizeInput.value;
            sizeBtns.forEach(btn => {
                if(String(btn.dataset.size) === String(selected)){
                    btn.classList.add('active');
                    btn.setAttribute('aria-pressed','true');
                }

                btn.addEventListener('click', function(e){
                    sizeBtns.forEach(b=>{ b.classList.remove('active'); b.setAttribute('aria-pressed','false'); });
                    btn.classList.add('active');
                    btn.setAttribute('aria-pressed','true');
                    selectedSizeInput.value = btn.dataset.size;
                });
            });
        }

        /* Days selector init */
        const dayBtns = document.querySelectorAll('.day-btn');
        const selectedDaysInput = document.getElementById('selectedDays');
        if(dayBtns.length && selectedDaysInput){
            const selected = selectedDaysInput.value || '1';
            dayBtns.forEach(btn => {
                if(String(btn.dataset.days) === String(selected)){
                    btn.classList.add('active');
                    btn.setAttribute('aria-pressed','true');
                }
                btn.addEventListener('click', function(){
                    dayBtns.forEach(b=>{ b.classList.remove('active'); b.setAttribute('aria-pressed','false'); });
                    btn.classList.add('active');
                    btn.setAttribute('aria-pressed','true');
                    selectedDaysInput.value = btn.dataset.days;
                    updateTotals();
                });
                btn.addEventListener('keydown', function(ev){
                    if(ev.key === 'Enter' || ev.key === ' '){ ev.preventDefault(); btn.click(); }
                });
            });
        }

        /* Quantity controls */
        const dec = document.querySelector('.qty-btn.decrement');
        const inc = document.querySelector('.qty-btn.increment');
        const qtyDisplay = document.getElementById('qty-display');
        const qtyInput = document.getElementById('selectedQty');
        if(dec && inc && qtyDisplay && qtyInput){
            function setQty(q){ q = Math.max(1, Math.floor(Number(q)||1)); qtyInput.value = q; qtyDisplay.textContent = q; updateTotals(); }
            dec.addEventListener('click', function(){ setQty(Number(qtyInput.value)-1); });
            inc.addEventListener('click', function(){ setQty(Number(qtyInput.value)+1); });
            dec.addEventListener('keydown', function(ev){ if(ev.key==='Enter' || ev.key===' ') { ev.preventDefault(); dec.click(); } });
            inc.addEventListener('keydown', function(ev){ if(ev.key==='Enter' || ev.key===' ') { ev.preventDefault(); inc.click(); } });
        }

        /* Initial totals */
        updateTotals();

        /* Details toggle (existing logic) */
        (function(){
            const id = "{{ $detailsId }}";
            const wrapper = document.getElementById("details-wrapper-"+id);
            const btn = document.getElementById("details-toggle-"+id);
            const text = btn ? btn.querySelector(".details-btn-text") : null;

            if(btn && wrapper){
                btn.addEventListener("click", function(){
                    const expanded = wrapper.classList.toggle("expanded");
                    btn.setAttribute("aria-expanded", expanded ? "true" : "false");
                    if(text) text.textContent = expanded ? "Lihat Lebih Sedikit" : "Lihat Lebih Banyak";
                });
            }
        })();
    });
</script>

{{-- include reviews partial --}}
@include('products.partials.reviews', ['product' => $product])

{{-- include related products --}}
@include('products.partials.related', ['relatedProducts' => $relatedProducts ?? []])

@if(empty($relatedProducts) || count($relatedProducts) === 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16"></div>
@endif

@endsection