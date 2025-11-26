{{-- resources/views/components/product-card.blade.php --}}
@props(['item' => null])

@if(!$item?->exists || !$item?->item_id)
    @endcomponent
@endif

<div class="group relative bg-white border border-gray-200 rounded-2xl shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-2 hover:ring-emerald-600 hover:ring-offset-4 overflow-hidden flex flex-col h-full">

    {{-- Badge Beli / Sewa --}}
    <div class="absolute top-3 right-3 z-10 flex flex-col gap-1">
        @if($item->is_sellable ?? false)
            <span class="px-2.5 py-1 text-[10px] font-bold text-white bg-emerald-700 rounded-full shadow">BELI</span>
        @endif
        @if($item->is_rentable ?? false)
            <span class="px-2.5 py-1 text-[10px] font-bold text-white bg-blue-700 rounded-full shadow">SEWA</span>
        @endif
    </div>

    {{-- Gambar --}}
    <a href="{{ route('products.show', $item->item_name) }}" class="block">
        <div class="relative w-full aspect-4/3 grid place-items-center bg-white overflow-hidden">
            <img src="{{ $item->url_image ?? asset('storage/foto-produk/default.png') }}"
                 alt="{{ $item->item_name ?? 'Produk' }}"
                 class="max-h-[200px] md:max-h-[220px] object-contain transition-transform duration-300 group-hover:scale-105">
        </div>
    </a>

    {{-- KONTEN + TOMBOL SELALU Nempel DI BAWAH --}}
    <div class="p-5 flex flex-col flex-1">

        {{-- Nama Produk --}}
        <h3 class="text-gray-800 font-extrabold text-[13px] md:text-[16.5px] leading-[1.35] mb-4 line-clamp-2 text-center" >
            {{ \Illuminate\Support\Str::limit($item->item_name ?? 'Produk Tanpa Nama', 60) }}
        </h3>

        <div class="mt-auto space-y-2">
        {{-- Harga Beli --}}
        @if(($item->is_sellable ?? false) && $item->sale_price > 0)
            <div class="mb-3 text-center">
                <p class="text-emerald-900 font-bold text-med-lg">
                    Rp{{ number_format($item->sale_price, 0, ',', '.') }}
                </p>
                <span class="text-xs text-gray-500 block -mt-1">Harga Beli</span>
            </div>
        @endif

        {{-- Harga Sewa --}}
        @if(($item->is_rentable ?? false) && $item->rental_price_per_day > 0)
            <div class="mb-4 text-center">
                <p class="text-blue-600 font-bold text-med-lg">
                    Rp{{ number_format($item->rental_price_per_day, 0, ',', '.') }}
                    <span class="text-xs font-normal text-gray-500 ml-1">/ hari</span>
                </p>
                <span class="text-xs text-gray-500 block -mt-1">Harga Sewa</span>
            </div>
        @endif
        </div>


        {{-- Fallback kalau gak ada harga --}}
        @if(!($item->is_sellable ?? false) && !($item->is_rentable ?? false))
            <p class="text-gray-400 text-sm italic mb-4 text-center">Harga belum tersedia</p>
        @endif

        <div class="mt-auto space-y-3">
            <div class="my-3 border-t border-gray-200"></div>
            {{-- Tombol Lihat Detail --}}
            <a href="{{ route('products.show', $item->item_name) }}"
               class="block w-full bg-emerald-900 text-white font-semibold text-[13px] py-2.5 rounded-lg hover:bg-emerald-800 transition text-center">
                Lihat Detail
            </a>

        </div>
        {{-- AKHIR DARI mt-auto --}}

    </div>
</div>