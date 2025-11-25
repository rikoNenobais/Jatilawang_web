@extends('layouts.layout-admin')

@section('title', 'Produk')
@section('header', 'Manajemen Produk (Items)')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    {{-- Bar atas: filter & tombol tambah --}}
    <div class="mb-4 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <form method="GET" class="flex flex-1 flex-wrap sm:flex-nowrap gap-2">
            {{-- Search --}}
            <div class="relative flex-1 min-w-[180px]">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    🔍
                </span>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari produk..."
                    class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-xl text-sm
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            {{-- Kategori --}}
            <div class="w-full sm:w-44">
                <input
                    type="text"
                    name="category"
                    value="{{ request('category') }}"
                    placeholder="Kategori"
                    class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            {{-- Sort seperti di gambar --}}
            <div class="w-full sm:w-52">
                <select
                    name="sort"
                    class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                >
                    <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>
                        Terbaru
                    </option>
                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>
                        Harga: Rendah → Tinggi
                    </option>
                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>
                        Harga: Tinggi → Rendah
                    </option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>
                        Nama: A → Z
                    </option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>
                        Nama: Z → A
                    </option>
                    <option value="id_asc" {{ request('sort') === 'id_asc' ? 'selected' : '' }}>
                        ID Produk: Kecil → Besar
                    </option>
                </select>
            </div>

            <button
                class="px-4 py-2 bg-slate-900 text-white text-sm rounded-xl flex items-center gap-1
                       hover:bg-slate-800">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.items.create') }}"
           class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium
                  rounded-xl shadow-sm hover:bg-indigo-700">
            + Tambah Produk
        </a>
    </div>

    {{-- Info kecil jumlah data --}}
    <div class="mb-3 text-xs text-gray-500">
        Menampilkan
        <span class="font-semibold">{{ $items->count() }}</span>
        dari
        <span class="font-semibold">{{ $items->total() }}</span>
        produk.
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full text-sm">
            <thead>
            <tr class="border-b bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <th class="text-left px-3 py-2">ID</th>
                <th class="text-left px-3 py-2">Produk</th>
                <th class="text-left px-3 py-2">Kategori</th>
                <th class="text-left px-3 py-2">Sewa/Hari</th>
                <th class="text-left px-3 py-2">Harga Jual</th>
                <th class="text-left px-3 py-2">Stok Sewa</th>
                <th class="text-left px-3 py-2">Stok Jual</th>
                <th class="text-right px-3 py-2">Aksi</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($items as $item)
                <tr class="hover:bg-gray-50/70">
                    <td class="px-3 py-2 text-gray-500 text-xs">
                        #{{ $item->item_id }}
                    </td>

                    <td class="px-3 py-2">
                        <div class="flex items-center gap-3">
                            @if($item->url_image)
                                <img
                                    src="{{ $item->url_image }}"
                                    alt="{{ $item->item_name }}"
                                    class="h-10 w-10 rounded-lg object-cover border border-gray-200"
                                >
                            @else
                                <div
                                    class="h-10 w-10 rounded-lg border border-dashed border-gray-300 flex items-center
                                           justify-center text-[10px] text-gray-400">
                                    No Img
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-gray-900">
                                    {{ $item->item_name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $item->description ? Str::limit($item->description, 40) : 'Tidak ada deskripsi' }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-3 py-2 text-gray-700">
                        {{ $item->category ?? '-' }}
                    </td>

                    <td class="px-3 py-2">
                        <span class="font-medium text-gray-900">
                            Rp {{ number_format($item->rental_price_per_day ?? 0, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-gray-400 block">/ hari</span>
                    </td>

                    <td class="px-3 py-2">
                        <span class="font-medium text-gray-900">
                            Rp {{ number_format($item->sale_price ?? 0, 0, ',', '.') }}
                        </span>
                    </td>

                    <td class="px-3 py-2">
                        <span class="text-sm text-gray-800 font-medium">{{ $item->rental_stock }}</span>
                    </td>

                    <td class="px-3 py-2">
                        <span class="text-sm text-gray-800 font-medium">{{ $item->sale_stock }}</span>
                    </td>

                    <td class="px-3 py-2 text-right whitespace-nowrap">
                        <a href="{{ route('admin.items.edit', $item) }}"
                           class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-lg border
                                  border-gray-200 text-gray-700 hover:bg-gray-50">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.items.destroy', $item) }}"
                              class="inline-block"
                              onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-lg border
                                       border-red-100 text-red-600 hover:bg-red-50 ml-1">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-3 py-6 text-center text-sm text-gray-400">
                        Belum ada produk yang terdaftar.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->withQueryString()->links() }}
    </div>
@endsection
