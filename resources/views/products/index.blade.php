@extends('layouts.public')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Produk - Jatilawang Adventure')

@section('content')
<section class="bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Breadcrumb & Toolbar --}}
    <div class="flex items-center justify-between gap-4">
      <nav class="text-sm text-gray-500">
        <ol class="flex items-center gap-2">
          <li>
            <a href="/" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900">
              {{-- back arrow --}}
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7M3 12h18"/></svg>
              Home
            </a>
          </li>
          <li class="mx-1">/</li>
          <li class="font-medium text-gray-900">Produk</li>
        </ol>
      </nav>

      <div class="flex items-center gap-3">
        <span class="text-sm text-gray-600">Produk Pilihan:</span>
        <span class="text-sm font-semibold text-gray-900">85</span>

        {{-- Sort --}}
        <div class="relative">
          <button type="button" class="inline-flex items-center justify-between gap-3 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
            Berdasarkan Rating
            <svg class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor"><path d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.243 4.64a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"/></svg>
          </button>
        </div>
      </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
      {{-- SIDEBAR --}}
      <aside class="lg:col-span-3">
        <div class="rounded-xl border border-gray-200 p-4">
          <div class="flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Produk</h3>
            <button class="text-sm text-gray-500 hover:text-gray-700">^</button>
          </div>

          {{-- search in sidebar --}}
          <div class="mt-3">
            <div class="relative">
              <input type="text" placeholder="Search"
                     class="w-full rounded-lg border-gray-300 pr-10 focus:border-emerald-600 focus:ring-emerald-600">
              <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2M17 10A7 7 0 103 10a7 7 0 0014 0z"/></svg>
            </div>
          </div>

          {{-- checklist --}}
          <ul class="mt-4 space-y-2 text-sm">
            <li class="flex items-center gap-2">
              <input id="r1" type="checkbox" class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-600" checked>
              <label for="r1" class="text-gray-700">Rekomendasi <span class="text-gray-400">110</span></label>
            </li>
            <li class="flex items-center gap-2">
              <input id="r2" type="checkbox" class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-600">
              <label for="r2" class="text-gray-700">Sepatu <span class="text-gray-400">125</span></label>
            </li>
            <li class="flex items-center gap-2">
              <input id="r3" type="checkbox" class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-600">
              <label for="r3" class="text-gray-700">Tenda <span class="text-gray-400">68</span></label>
            </li>
            <li class="flex items-center gap-2">
              <input id="r4" type="checkbox" class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-600">
              <label for="r4" class="text-gray-700">Jaket <span class="text-gray-400">44</span></label>
            </li>
            <li class="flex items-center gap-2">
              <input id="r5" type="checkbox" class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-600">
              <label for="r5" class="text-gray-700">Tas <span class="text-gray-400">36</span></label>
            </li>
            <li class="flex items-center gap-2">
              <input id="r6" type="checkbox" class="rounded border-gray-300 text-emerald-700 focus:ring-emerald-600">
              <label for="r6" class="text-gray-700">Alat Perlengkapan <span class="text-gray-400">10</span></label>
            </li>
          </ul>
        </div>
      </aside>

     {{-- GRID PRODUK --}}
    <div class="lg:col-span-9">
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 items-stretch">

      @forelse ($items as $item)
      {{-- CARD PRODUK --}}
      <div
      class="group relative bg-white border border-gray-200 rounded-2xl shadow-sm
          transition-all duration-300 ease-out overflow-hidden flex flex-col
          will-change-transform
          hover:-translate-y-1
          hover:shadow-lg
          hover:ring-2 hover:ring-emerald-600 hover:ring-offset-4 hover:ring-offset-white
          hover:border-transparent
      ">
      {{-- Icon Love (dummy, bisa diubah sesuai fitur favorit) --}}
      <div class="absolute top-4 right-4">
        <button type="button"
          class="flex items-center justify-center w-9 h-9 rounded-full bg-white/90 text-gray-400 shadow-sm ring-1 ring-gray-200 hover:text-red-500 transition">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" class="w-5 h-5">
            <path d="M12 21C12 21 4 13.36 4 8.5C4 5.42 6.42 3 9.5 3C11.24 3 12.91 3.81 14 5.08C15.09 3.81 16.76 3 18.5 3C21.58 3 24 5.42 24 8.5C24 13.36 16 21 16 21H12Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>

      {{-- Gambar produk --}}
      <div class="relative w-full aspect-[4/3] grid place-items-center bg-white">
        <img src="{{ $item->url_image ?? asset('storage/foto-produk/default.png') }}" alt="{{ $item->item_name }}"
          class="max-h-[180px] md:max-h-[220px] object-contain transition-transform duration-300 group-hover:scale-105">
      </div>

      {{-- Nama + Harga + Tombol --}}
      <div class="p-5 flex flex-col flex-1 text-center font-sans">
        {{-- Nama produk (max 2 baris) --}}
        <h3 class="text-gray-800 font-medium text-[13px] md:text-[14px] leading-[1.35] mb-2
              line-clamp-2 min-h-[2.7rem]"
          title="{{ $item->item_name }}"
          style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
          {{ $item->item_name }}
        </h3>

         {{--Harga --}}
        <p class="text-emerald-800 font-extrabold text-[16px] md:text-[17px] mb-3">
          Rp{{ number_format($item->rental_price_per_day ?? 0, 0, ',', '.') }}
        </p>

        {{-- Tombol detail pakai item_id --}}
        <a href="{{ route('products.show', $item->item_id) }}"
        class="mt-auto inline-block w-full bg-emerald-900 text-white font-semibold text-[13px] py-2.5 rounded-lg
            hover:bg-emerald-800 transition-all duration-200">
          Lihat Detail
        </a>

        {{-- Tombol Tambah ke Keranjang --}}
        <form method="POST" action="{{ route('cart.store') }}" class="mt-2">
          @csrf
          <input type="hidden" name="item_id" value="{{ $item->item_id }}">
          <button type="submit" class="mt-auto inline-block w-full bg-emerald-600 text-white font-semibold text-[13px] py-2.5 rounded-lg
              hover:bg-emerald-500 transition-all duration-200">
            Tambah ke Keranjang
          </button>
        </form>
      </div>
      </div>
      @empty
        <div class="col-span-full text-center text-gray-500 py-12">Belum ada produk tersedia.</div>
      @endforelse

        {{-- end demo card removed (was using undefined $p) --}}

    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex items-center justify-center gap-2 text-sm">
        <button class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-50">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        </button>
        <button class="rounded-md border border-gray-300 px-3 py-1.5 bg-emerald-900 text-white">1</button>
        <button class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-50">2</button>
        <button class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-50">3</button>
        <span class="px-2 text-gray-500">…</span>
        <button class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-50">12</button>
        <button class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-50">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        </button>
    </div>
    </div>

</section>
@endsection
