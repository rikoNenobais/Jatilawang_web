@extends('layouts.public')

@section('title', 'Beranda - Jatilawang Adventure')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')

    {{-- ===================== HERO (sesuai mockup) ===================== --}}
    <section class="relative overflow-hidden animate-hero-enter">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950 via-emerald-800 to-teal-700"></div>
        <div class="pointer-events-none absolute -top-40 -left-40 h-[700px] w-[700px] rounded-full bg-emerald-900/30 blur-3xl"></div>

        <div class="relative">
            <div class="max-w-7xl mx-auto px-6 md:px-8 py-16 md:py-24">
                <div class="grid items-center gap-12 md:gap-16 md:grid-cols-2">
                    {{-- LEFT: Copy --}}
                    <div class="text-white">
                        <p class="text-emerald-200/80 text-xl md:text-2xl font-semibold">
                            Awali Petualangan Terbaikmu.
                        </p>

                        {{-- Judul 2 baris besar --}}
                        <h1 class="mt-3 leading-[0.95] tracking-tight">
                            <span class="block text-[52px] md:text-[84px] lg:text-[80px] font-light">
                                Jatilawang
                            </span>
                            <span class="block -mt-2 text-[72px] md:text-[100px] lg:text-[90px] font-extrabold">
                                Adventure
                            </span>
                        </h1>

                        <p class="mt-6 max-w-xl text-emerald-100 text-base md:text-lg">
                            Dari pendaki pemula hingga profesional, kami menyediakan peralatan teruji
                            untuk memastikan kenyamanan dan kenyamanan perjalanan Anda.
                        </p>

                        <a href="{{ route('products.index') }}"
                           class="mt-8 inline-flex h-12 items-center justify-center rounded-xl border border-white/70
                                  px-6 text-white font-semibold hover:bg-white/10 focus:outline-none
                                  focus-visible:ring-2 focus-visible:ring-white/60">
                            Mulai Petualangan
                        </a>
                    </div>

                    {{-- RIGHT: Image --}}
                    <div class="justify-self-center md:justify-self-end">
                        <div class="rounded-2xl overflow-hidden shadow-xl ring-1 ring-black/10 bg-black/10">
                            <img
                                src="{{ asset('storage/hero/peaks.jpg') }}"
                                alt="Pegunungan saat senja"
                                class="hero-float block w-[560px] h-[320px] md:w-[640px] md:h-[360px] object-cover transition-transform duration-700 ease-out"
                                loading="eager"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- =================== /HERO ====================== --}}

    {{-- ====== GEAR SLIDER ====== --}}
    <section class="mt-16 md:mt-24">
        <div class="mx-auto max-w-7xl px-6">
            <p class="text-sm text-emerald-700/70 mb-2">Koleksi Favorit Pendaki</p>
            <div class="flex items-center justify-between">
                <h2 class="text-3xl md:text-4xl font-extrabold text-jatilawang-900">
                    Perlengkapan Andalan
                </h2>

                <div class="relative z-20 flex items-center gap-3">
                    <button class="gear-prev" aria-label="Sebelumnya">
                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="w-5 h-5">
                            <path d="M12 4L6 10l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="gear-next" aria-label="Berikutnya">
                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="w-5 h-5">
                            <path d="M8 4l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="gear-slider relative mx-auto max-w-7xl px-6 mt-6">
            <div class="swiper gear-swiper">
                <div class="swiper-wrapper">
                    {{-- SLIDE 1 --}}
                    <div class="swiper-slide">
                        <div class="rounded-[28px] bg-emerald-50/70 ring-1 ring-emerald-100 p-6 md:p-10
                                    grid md:grid-cols-2 gap-8 items-center min-h-[420px]">
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/foto-produk/tenda-camping.png') }}"
                                     alt="Tenda Camping"
                                     class="max-h-[300px] md:max-h-[360px] w-auto object-contain">
                            </div>
                            <div>
                                <h3 class="text-emerald-900 font-extrabold text-[42px] leading-[1.05] md:text-[58px] md:leading-[1.05]">
                                    Tenda <br class="hidden md:block"> Camping
                                </h3>
                                <p class="mt-3 text-emerald-900/70 text-lg">
                                    Ringkas, kuat, mudah dipasang…
                                </p>
                                <a href="{{ route('products.index') }}"
                                   class="inline-flex items-center gap-2 mt-6 rounded-xl border border-emerald-200
                                          bg-white px-5 py-3 text-emerald-900 hover:bg-emerald-50 transition">
                                    Lihat Koleksi
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                        <path d="M7 5l6 5-6 5" stroke="currentColor" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- SLIDE 2 --}}
                    <div class="swiper-slide">
                        <div class="rounded-[28px] bg-emerald-50/70 ring-1 ring-emerald-100 p-6 md:p-10
                                    grid md:grid-cols-2 gap-8 items-center min-h-[420px]">
                            <div class="flex justify-center order-last md:order-first">
                                <img src="{{ asset('storage/foto-produk/jaket-hitam.png') }}"
                                     alt="Jaket Gunung"
                                     class="max-h-[300px] md:max-h-[360px] w-auto object-contain">
                            </div>
                            <div>
                                <h3 class="text-emerald-900 font-extrabold text-[42px] leading-[1.05] md:text-[58px] md:leading-[1.05]">
                                    Jaket Gunung
                                </h3>
                                <p class="mt-3 text-emerald-900/70 text-lg">
                                    Melindungi dari angin & hujan…
                                </p>
                                <a href="{{ route('products.index') }}"
                                   class="inline-flex items-center gap-2 mt-6 rounded-xl border border-emerald-200
                                          bg-white px-5 py-3 text-emerald-900 hover:bg-emerald-50 transition">
                                    Lihat Koleksi
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                        <path d="M7 5l6 5-6 5" stroke="currentColor" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- SLIDE 3 --}}
                    <div class="swiper-slide">
                        <div class="rounded-[28px] bg-emerald-50/70 ring-1 ring-emerald-100 p-6 md:p-10
                                    grid md:grid-cols-2 gap-8 items-center min-h-[420px]">
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/foto-produk/carrier-eiger-streamline.png') }}"
                                     alt="Tas Gunung"
                                     class="max-h-[300px] md:max-h-[360px] w-auto object-contain">
                            </div>
                            <div>
                                <h3 class="text-emerald-900 font-extrabold text-[42px] leading-[1.05] md:text-[58px] md:leading-[1.05]">
                                    Tas Gunung
                                </h3>
                                <p class="mt-3 text-emerald-900/70 text-lg">
                                    Material ergonomis & kuat, perlengkapanmu tetap terorganisir.
                                </p>
                                <a href="{{ route('products.index') }}"
                                   class="inline-flex items-center gap-2 mt-6 rounded-xl border border-emerald-200
                                          bg-white px-5 py-3 text-emerald-900 hover:bg-emerald-50 transition">
                                    Lihat Koleksi
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                        <path d="M7 5l6 5-6 5" stroke="currentColor" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pagination titik di bawah card --}}
                <div class="gear-pagination mt-6"></div>
            </div>
        </div>
    </section>

    {{-- ===================== KATEGORI ===================== --}}
    <section class="py-20 bg-white">
        <div class="max-w-9xl mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-10">
                Cari Berdasarkan Kategori
            </h2>

            <div class="flex flex-wrap justify-center gap-6 sm:gap-8">
                @foreach(['Sepatu', 'Tas', 'Jaket', 'Tenda', 'Aksesori', 'Lainnya'] as $kategori)
                    <button
                        class="px-10 py-4 rounded-2xl font-medium text-gray-800 bg-gray-100
                                hover:bg-emerald-700 hover:text-white transition-all duration-200
                                shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        {{ $kategori }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>
    {{-- ===================== /KATEGORI ===================== --}}

    {{-- ===================== PRODUK UNGGULAN ===================== --}}
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            {{-- Tabs Produk --}}
            <div class="flex items-center gap-8 border-b border-gray-200 mb-10">
                <button class="pb-3 border-b-2 border-brand text-brand font-semibold">
                    Terbaru
                </button>
                <button class="pb-3 text-gray-500 hover:text-emerald-700 transition">
                    Bestseller
                </button>
                <button class="pb-3 text-gray-500 hover:text-emerald-700 transition">
                    Produk Terkait
                </button>
            </div>

            {{-- Grid Produk --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($items as $item)
                    {{-- Card Produk --}}
                    <div class="group relative bg-white border border-gray-200 rounded-2xl shadow-sm transition-all duration-300 ease-out overflow-hidden flex flex-col will-change-transform hover:-translate-y-1 hover:shadow-lg hover:ring-2 hover:ring-emerald-600 hover:ring-offset-4 hover:ring-offset-white hover:border-transparent">
                        <div class="absolute top-4 right-4">
                            <button type="button" class="flex items-center justify-center w-9 h-9 rounded-full bg-white/90 text-gray-400 shadow-sm ring-1 ring-gray-200 hover:text-red-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path d="M12 21C12 21 4 13.36 4 8.5C4 5.42 6.42 3 9.5 3C11.24 3 12.91 3.81 14 5.08C15.09 3.81 16.76 3 18.5 3C21.58 3 24 5.42 24 8.5C24 13.36 16 21 16 21H12Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        <div class="relative w-full aspect-[4/3] grid place-items-center bg-white overflow-hidden">
                            <img src="{{ $item->url_image ?? asset('storage/foto-produk/default.png') }}" alt="{{ $item->item_name }}" class="max-h-[200px] md:max-h-[220px] object-contain transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <div class="p-5 flex flex-col flex-1 text-center font-sans">
                            <h3 class="text-gray-800 font-medium text-[13px] md:text-[14px] leading-[1.35] mb-2 line-clamp-2 min-h-[2.7rem]" title="{{ $item->item_name }}" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $item->item_name }}
                            </h3>
                            <p class="text-emerald-800 font-extrabold text-[16px] md:text-[17px] mb-3">
                                Rp{{ number_format($item->rental_price_per_day ?? 0, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('products.show', $item->item_id) }}" class="mt-auto inline-block w-full bg-emerald-900 text-white font-semibold text-[13px] py-2.5 rounded-lg hover:bg-emerald-800 transition-all duration-200">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">Belum ada produk tersedia.</div>
                @endforelse

                    
            </div>
        </div>
    </section>
    {{-- ===================== /PRODUK UNGGULAN ===================== --}}

@endsection