@extends('layout.layout-admin')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-lg text-slate-800 mb-1">
                Edit Produk
            </h3>
            <p class="text-sm text-gray-600 mb-4">
                Perbarui informasi produk di katalog penyewaan dan penjualan.
            </p>

            <form method="POST" action="{{ route('admin.items.update', $item) }}" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- ID Produk (read-only) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        ID Produk (item_id)
                    </label>
                    <input
                        type="number"
                        value={{ $item->item_id }}
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm bg-gray-100 cursor-not-allowed"
                        disabled
                    >
                    <p class="text-[11px] text-gray-400 mt-1">
                        ID tidak bisa diubah.
                    </p>
                </div>

                {{-- Nama & Kategori --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Produk
                        </label>
                        <input
                            type="text"
                            name="item_name"
                            value="{{ old('item_name', $item->item_name) }}"
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('item_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Kategori
                        </label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $item->category) }}"
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('category')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- URL Gambar + preview --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        URL Gambar
                    </label>
                    <input
                        type="url"
                        name="url_image"
                        value="{{ old('url_image', $item->url_image) }}"
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @error('url_image')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror

                    @if($item->url_image)
                        <div class="mt-3 flex items-start gap-3">
                            <div>
                                <span class="text-[11px] text-gray-500 block mb-1">Pratinjau saat ini:</span>
                                <img
                                    src="{{ $item->url_image }}"
                                    alt="{{ $item->item_name }}"
                                    class="h-20 w-20 object-cover rounded-lg border border-gray-200"
                                >
                            </div>
                            <p class="text-[11px] text-gray-400">
                                Gambar diambil dari URL yang disimpan. Kamu bisa mengganti link jika ingin mengubah gambar.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Harga --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Harga Sewa / Hari
                        </label>
                        <input
                            type="number"
                            name="rental_price_per_day"
                            value="{{ old('rental_price_per_day', $item->rental_price_per_day) }}"
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('rental_price_per_day')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Harga Jual
                        </label>
                        <input
                            type="number"
                            name="sale_price"
                            value="{{ old('sale_price', $item->sale_price) }}"
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('sale_price')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Stok --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Stok Sewa
                        </label>
                        <input
                            type="number"
                            name="rental_stock"
                            value="{{ old('rental_stock', $item->rental_stock) }}"
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('rental_stock')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Stok Jual
                        </label>
                        <input
                            type="number"
                            name="sale_stock"
                            value="{{ old('sale_stock', $item->sale_stock) }}"
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('sale_stock')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Denda --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Denda per Hari
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        name="penalty_per_days"
                        value="{{ old('penalty_per_days', $item->penalty_per_days) }}"
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @error('penalty_per_days')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status sewa / jual --}}
                <div class="flex flex-wrap items-center gap-4">
                    <label class="inline-flex items-center text-sm text-slate-700">
                        <input type="hidden" name="is_rentable" value="0">
                        <input
                            type="checkbox"
                            name="is_rentable"
                            value="1"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            {{ old('is_rentable', $item->is_rentable) ? 'checked' : '' }}
                        >
                        <span class="ml-2">Bisa disewa</span>
                    </label>

                    <label class="inline-flex items-center text-sm text-slate-700">
                        <input type="hidden" name="is_sellable" value="0">
                        <input
                            type="checkbox"
                            name="is_sellable"
                            value="1"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            {{ old('is_sellable', $item->is_sellable) ? 'checked' : '' }}
                        >
                        <span class="ml-2">Bisa dijual</span>
                    </label>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Deskripsi
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Tuliskan detail produk, kondisi, material, dan lain-lain...">{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol aksi --}}
                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('admin.items.index') }}"
                       class="text-sm text-gray-600 hover:underline">
                        Batal
                    </a>
                    <button
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl
                               bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
