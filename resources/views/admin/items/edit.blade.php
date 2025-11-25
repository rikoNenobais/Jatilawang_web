@extends('layouts.layout-admin')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            {{-- Header --}}
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg text-gray-900">Edit Produk</h3>
                    <p class="text-sm text-gray-600">Perbarui informasi produk di katalog penyewaan dan penjualan</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.items.update', $item) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- ID Produk (read-only) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        ID Produk
                    </label>
                    <input
                        type="number"
                        value="{{ $item->item_id }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm bg-gray-50 cursor-not-allowed"
                        disabled
                    >
                    <p class="text-xs text-gray-500 mt-2">
                        ID produk tidak dapat diubah
                    </p>
                </div>

                {{-- Nama & Kategori --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="item_name"
                            value="{{ old('item_name', $item->item_name) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Contoh: Tenda Dome 4 Orang"
                            required
                        >
                        @error('item_name')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $item->category) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Contoh: Tenda, Carrier, Sepatu"
                            required
                        >
                        @error('category')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- URL Gambar + Preview --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        URL Gambar <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="url"
                        name="url_image"
                        value="{{ old('url_image', $item->url_image) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        placeholder="https://example.com/image.jpg"
                        required
                    >
                    @error('url_image')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror

                    @if($item->url_image)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <span class="text-xs font-medium text-gray-700 block mb-2">Pratinjau Gambar:</span>
                                    <img
                                        src="{{ $item->url_image }}"
                                        alt="{{ $item->item_name }}"
                                        class="h-24 w-24 object-cover rounded-lg border-2 border-gray-300"
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iOTYiIGhlaWdodD0iOTYiIHZpZXdCb3g9IjAgMCA5NiA5NiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9Ijk2IiBoZWlnaHQ9Ijk2IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik02NCA0OEg0OFY2NEg2NFY0OFoiIGZpbGw9IiM5Q0EwQUQiLz4KPHBhdGggZD0iTTcyIDI0SDI0VjcySDcyVjI0WiIgc3Ryb2tlPSIjOUNBMEFEIiBzdHJva2Utd2lkdGg9IjIiLz4KPC9zdmc+'"
                                    >
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600">
                                        Gambar saat ini akan diganti jika URL diubah. Pastikan link gambar valid dan dapat diakses.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Harga --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Sewa / Hari
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input
                                type="number"
                                name="rental_price_per_day"
                                value="{{ old('rental_price_per_day', $item->rental_price_per_day) }}"
                                class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-3 text-sm
                                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="25000"
                            >
                        </div>
                        @error('rental_price_per_day')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Jual
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input
                                type="number"
                                name="sale_price"
                                value="{{ old('sale_price', $item->sale_price) }}"
                                class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-3 text-sm
                                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="450000"
                            >
                        </div>
                        @error('sale_price')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Stok --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stok Sewa
                        </label>
                        <input
                            type="number"
                            name="rental_stock"
                            value="{{ old('rental_stock', $item->rental_stock) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        >
                        @error('rental_stock')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Stok Jual
                        </label>
                        <input
                            type="number"
                            name="sale_stock"
                            value="{{ old('sale_stock', $item->sale_stock) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        >
                        @error('sale_stock')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Denda --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Denda per Hari
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input
                            type="number"
                            step="0.01"
                            name="penalty_per_days"
                            value="{{ old('penalty_per_days', $item->penalty_per_days) }}"
                            class="w-full rounded-lg border border-gray-300 pl-10 pr-4 py-3 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="10000"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        Denda keterlambatan pengembalian per hari
                    </p>
                    @error('penalty_per_days')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="flex flex-wrap items-center gap-6 p-4 bg-gray-50 rounded-lg">
                    <label class="inline-flex items-center text-sm text-gray-700">
                        <input type="hidden" name="is_rentable" value="0">
                        <input
                            type="checkbox"
                            name="is_rentable"
                            value="1"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            {{ old('is_rentable', $item->is_rentable) ? 'checked' : '' }}
                        >
                        <span class="ml-2 font-medium">Bisa disewa</span>
                    </label>

                    <label class="inline-flex items-center text-sm text-gray-700">
                        <input type="hidden" name="is_sellable" value="0">
                        <input
                            type="checkbox"
                            name="is_sellable"
                            value="1"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            {{ old('is_sellable', $item->is_sellable) ? 'checked' : '' }}
                        >
                        <span class="ml-2 font-medium">Bisa dijual</span>
                    </label>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        placeholder="Tuliskan detail produk, material, kegunaan, dan spesifikasi..."
                    >{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.items.index') }}"
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg
                              hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button
                        class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg
                               hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                               transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection