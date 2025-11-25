@extends('layouts.layout-admin')

@section('title', 'Produk')
@section('header', 'Manajemen Produk')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    {{-- Header dengan Filter --}}
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Produk</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola semua produk sewa dan jual</p>
            </div>
            
            <a href="{{ route('admin.items.create') }}"
               class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium
                      rounded-lg shadow-sm hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Produk
            </a>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 flex flex-col sm:flex-row gap-3">
                    {{-- Search --}}
                    <div class="flex-1 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari produk..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    {{-- Kategori --}}
                    <div class="sm:w-48">
                        <input
                            type="text"
                            name="category"
                            value="{{ request('category') }}"
                            placeholder="Kategori"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    {{-- Sort --}}
                    <div class="sm:w-56">
                        <select
                            name="sort"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm
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
                        </select>
                    </div>
                </div>

                <button
                    class="px-4 py-2.5 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800 
                           transition-colors flex items-center gap-2 justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                    </svg>
                    Filter
                </button>
            </form>
        </div>
    </div>

    {{-- Info --}}
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-gray-600">
            Menampilkan <span class="font-semibold text-gray-900">{{ $items->count() }}</span> dari 
            <span class="font-semibold text-gray-900">{{ $items->total() }}</span> produk
        </p>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Produk
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Harga Sewa
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Harga Jual
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Stok
                        </th>
                        <th class="text-right py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($items as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            {{-- Produk --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    @if($item->url_image)
                                        <img
                                            src="{{ $item->url_image }}"
                                            alt="{{ $item->item_name }}"
                                            class="w-12 h-12 rounded-lg object-cover border border-gray-200"
                                        >
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 
                                                    flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold text-gray-900 truncate">
                                                {{ $item->item_name }}
                                            </p>
                                            <span class="text-xs text-gray-500 font-mono bg-gray-100 px-1.5 py-0.5 rounded">
                                                #{{ $item->item_id }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 truncate">
                                            {{ $item->description ? Str::limit($item->description, 50) : 'Tidak ada deskripsi' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            bg-blue-100 text-blue-800">
                                    {{ $item->category ?? '-' }}
                                </span>
                            </td>

                            {{-- Harga Sewa --}}
                            <td class="py-4 px-6">
                                <div class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($item->rental_price_per_day ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500">per hari</div>
                            </td>

                            {{-- Harga Jual --}}
                            <td class="py-4 px-6">
                                <div class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($item->sale_price ?? 0, 0, ',', '.') }}
                                </div>
                            </td>

                            {{-- Stok --}}
                            <td class="py-4 px-6">
                                <div class="flex gap-4">
                                    <div class="text-center">
                                        <div class="text-sm font-semibold text-gray-900">{{ $item->rental_stock }}</div>
                                        <div class="text-xs text-gray-500">Sewa</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm font-semibold text-gray-900">{{ $item->sale_stock }}</div>
                                        <div class="text-xs text-gray-500">Jual</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.items.edit', $item) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 
                                              text-xs font-medium rounded-lg hover:bg-blue-100 transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.items.destroy', $item) }}"
                                          onsubmit="return confirm('Yakin hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 
                                                   text-xs font-medium rounded-lg hover:bg-red-100 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-lg font-medium text-gray-500">Belum ada produk</p>
                                    <p class="text-sm mt-1">Produk yang ditambahkan akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $items->withQueryString()->links() }}
    </div>
@endsection