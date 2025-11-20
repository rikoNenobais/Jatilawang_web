@extends('layouts.public')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Produk - Jatilawang Adventure')

@section('content')
<section class="bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Breadcrumb & Toolbar --}}
    <div class="flex items-center justify-between gap-4 mb-6">
      <nav class="text-sm text-gray-500">
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
          <li class="font-medium text-gray-900">Produk</li>
        </ol>
      </nav>

      {{-- SORTING SUDAH HIDUP 100% --}}
      <div class="flex items-center gap-3">
        <span class="text-sm text-gray-600 hidden sm:block">Urut berdasarkan:</span>
        <form method="GET" action="{{ route('products.index') }}" class="inline">
          <select name="sort" onchange="this.form.submit()"
                  class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 cursor-pointer">
            <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah → Tinggi</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi → Rendah</option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A → Z</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama: Z → A</option>
          </select>
          {{-- Hidden inputs biar filter lain tetap ikut --}}
          @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
          @if(request('categories'))
            @foreach(request('categories') as $cat)
              <input type="hidden" name="categories[]" value="{{ $cat }}">
            @endforeach
          @endif
          @if(request('recommended')) <input type="hidden" name="recommended" value="1"> @endif
        </form>
      </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
      {{-- SIDEBAR FILTER --}}
      <aside class="lg:col-span-3">
        <form method="GET" action="{{ route('products.index') }}" id="filterForm">
          <div class="rounded-xl border border-gray-200 p-5 bg-white sticky top-24">

            <h3 class="font-bold text-gray-900 mb-5">Filter Produk</h3>

            {{-- Search --}}
            <div class="relative mb-5">
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                     class="w-full rounded-lg border-gray-300 pl-10 pr-4 py-2.5 text-sm focus:border-emerald-600 focus:ring-emerald-600">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </div>

            {{-- Rekomendasi --}}
            <div class="mb-6">
              <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="recommended" value="1" {{ request('recommended') ? 'checked' : '' }}
                       onchange="this.form.submit()" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-600">
                <span class="text-sm font-medium text-gray-700">Rekomendasi</span>
              </label>
            </div>

            {{-- Kategori --}}
            <div class="space-y-3">
              <h4 class="font-semibold text-gray-800">Kategori</h4>
              @foreach($categoryCounts as $categoryName => $count)
                <label class="flex items-center justify-between cursor-pointer group">
                  <div class="flex items-center gap-3">
                    <input type="checkbox" name="categories[]" value="{{ $categoryName }}"
                           {{ in_array($categoryName, (array)request('categories')) ? 'checked' : '' }}
                           onchange="this.form.submit()" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-600">
                    <span class="text-sm text-gray-700 group-hover:text-gray-900">{{ ucfirst($categoryName) }}</span>
                  </div>
                  <span class="text-xs text-gray-500 font-medium">({{ $count }})</span>
                </label>
              @endforeach
            </div>

            {{-- Reset Filter --}}
            @if(request()->hasAny(['categories', 'search', 'recommended', 'sort']))
              <div class="mt-6 pt-4 border-t border-gray-200">
                <a href="{{ route('products.index') }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium underline">
                  Hapus semua filter
                </a>
              </div>
            @endif

            {{-- Hidden sort agar tetap ikut saat filter berubah --}}
            @if(request('sort'))
              <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
          </div>
        </form>
      </aside>

      {{-- GRID PRODUK --}}
      <div class="lg:col-span-9">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

          @forelse ($items as $item)
            <div class="group relative bg-white border border-gray-200 rounded-2xl shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-2 hover:ring-emerald-600 hover:ring-offset-4 overflow-hidden flex flex-col">

              {{-- Gambar --}}
              <div class="relative w-full aspect-[4/3] bg-gray-50 flex items-center justify-center p-4">
                <img src="{{ $item->url_image ?? asset('storage/foto-produk/default.png') }}"
                     alt="{{ $item->item_name }}"
                     class="max-h-48 object-contain group-hover:scale-105 transition-transform duration-300">
              </div>

              {{-- Konten --}}
              <div class="p-5 flex flex-col flex-1 text-center">
                <h3 class="text-gray-800 font-medium text-sm leading-tight line-clamp-2 mb-2">
                  {{ $item->item_name }}
                </h3>

                <p class="text-emerald-800 font-extrabold text-lg mb-4">
                  Rp{{ number_format($item->rental_price_per_day ?? 0, 0, ',', '.') }} <span class="text-xs font-normal text-gray-600">/hari</span>
                </p>

                {{-- Tombol Detail --}}
                <a href="{{ route('products.show', $item->item_id) }}"
                   class="w-full bg-emerald-900 text-white font-semibold text-sm py-2.5 rounded-lg hover:bg-emerald-800 transition mb-2">
                  Lihat Detail
                </a>

                {{-- Tombol Keranjang --}}
                @auth
                  <form method="POST" action="{{ route('cart.store') }}">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                    <button type="submit" class="w-full bg-emerald-600 text-white font-semibold text-sm py-2.5 rounded-lg hover:bg-emerald-700 transition">
                      + Keranjang
                    </button>
                  </form>
                @else
                  <button onclick="goToLoginWithRedirect()" class="w-full bg-emerald-600 text-white font-semibold text-sm py-2.5 rounded-lg hover:bg-emerald-700 transition">
                    + Keranjang (Login Dulu)
                  </button>
                @endauth
              </div>
            </div>
          @empty
            <div class="col-span-full text-center py-16 text-gray-500 text-lg">
              Tidak ada produk yang sesuai dengan filter.
            </div>
          @endforelse
        </div>

        {{-- Pagination Laravel (otomatis bawa semua query string) --}}
        <div class="mt-10">
          {{ $items->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function goToLoginWithRedirect() {
    const url = new URL(window.location);
    const redirectTo = url.pathname + url.search;
    window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(redirectTo);
  }
</script>
@endsection