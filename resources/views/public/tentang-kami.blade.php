@extends('layouts.public')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Tentang Kami - Jatilawang Adventure')

@section('content')
    {{-- ===================== HERO SECTION ===================== --}}
    <section class="relative overflow-hidden py-16 md:py-24">
        {{-- Background Foto --}}
        <div class="absolute inset-0">
            <img src="{{ asset('storage/hero/peaks.jpg') }}" 
                 alt="Pegunungan Jatilawang Adventure" 
                 class="w-full h-full object-cover">
            {{-- Overlay Gradient --}}
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/80 via-emerald-800/70 to-teal-700/80"></div>
        </div>
        
        {{-- Efek Blur --}}
        <div class="pointer-events-none absolute -top-40 -left-40 h-[700px] w-[700px] rounded-full bg-emerald-900/20 blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-6 md:px-8">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Tentang Kami</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Menyediakan perlengkapan adventure terpercaya untuk petualangan Anda
                </p>
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-8">
            <div class="prose prose-lg max-w-none">
                {{-- Intro --}}
                <div class="text-center mb-12">
                    <p class="text-2xl text-gray-700 leading-relaxed">
                        Selamat datang di <span class="font-semibold text-emerald-700">Jatilawang Adventure</span> – 
                        Penyedia layanan penyewaan perlengkapan gunung dan camping terpercaya.
                    </p>
                </div>

                <div class="space-y-8">
                    {{-- Deskripsi --}}
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Jatilawang Adventure hadir dengan misi untuk mendukung kegiatan outdoor Anda dengan menyediakan berbagai pilihan 
                            peralatan yang aman, nyaman, dan siap pakai. Kami memahami bahwa pengalaman mendaki atau berkemah membutuhkan 
                            perlengkapan yang tidak hanya berkualitas tetapi juga dapat diandalkan dalam segala kondisi.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            Oleh karena itu, kami berkomitmen untuk memastikan setiap alat yang kami sewakan berada dalam kondisi terbaik 
                            dan siap untuk digunakan.
                        </p>
                    </div>

                    {{-- Why Choose Us --}}
                    <div class="mt-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Mengapa Memilih Jatilawang Adventure?</h2>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            {{-- Card 1 --}}
                            <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-100">
                                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-emerald-900 mb-3">Pengalaman dan Keahlian</h3>
                                <p class="text-gray-700">
                                    Dengan pengalaman bertahun-tahun dalam industri penyewaan peralatan outdoor, kami telah membantu ribuan 
                                    petualang mempersiapkan perjalanan mereka.
                                </p>
                            </div>

                            {{-- Card 2 --}}
                            <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-100">
                                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-emerald-900 mb-3">Peralatan Berkualitas</h3>
                                <p class="text-gray-700">
                                    Kami menyediakan berbagai macam peralatan pendakian gunung dan camping yang telah melalui pemeriksaan 
                                    kualitas untuk memastikan keamanan dan fungsionalitasnya.
                                </p>
                            </div>

                            {{-- Card 3 --}}
                            <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-100">
                                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-emerald-900 mb-3">Layanan Pelanggan Terbaik</h3>
                                <p class="text-gray-700">
                                    Kami tidak hanya menyewakan peralatan, tetapi juga memberikan panduan dan saran terbaik mengenai 
                                    perlengkapan yang cocok untuk kebutuhan Anda.
                                </p>
                            </div>

                            {{-- Card 4 --}}
                            <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-100">
                                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-emerald-900 mb-3">Fleksibilitas & Kemudahan</h3>
                                <p class="text-gray-700">
                                    Kami menawarkan kemudahan dalam proses pemesanan dan pengembalian peralatan. Dengan lokasi yang strategis, 
                                    Anda dapat dengan mudah mengakses perlengkapan sesuai kebutuhan.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Komitmen --}}
                    <div class="mt-12 text-center">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl p-8 border border-emerald-100">
                            <h2 class="text-2xl font-bold text-emerald-900 mb-4">Komitmen Kami</h2>
                            <p class="text-gray-700 text-lg leading-relaxed max-w-3xl mx-auto">
                                Di Jatilawang Adventure, kami berkomitmen untuk selalu memberikan layanan terbaik dengan menyediakan 
                                peralatan yang selalu terjaga kualitasnya. Kami percaya bahwa setiap petualangan harus dimulai dengan 
                                perlengkapan yang tepat, dan kami ada untuk memastikan Anda siap menghadapi segala tantangan alam.
                            </p>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="mt-12 text-center">
                        <div class="bg-emerald-900 rounded-2xl p-8 text-white">
                            <h2 class="text-2xl font-bold mb-4">Siap Memulai Petualangan?</h2>
                            <p class="text-emerald-100 mb-6 text-lg">
                                Jatilawang Adventure siap membantu Anda dengan perlengkapan terbaik yang tersedia.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('products.index') }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 bg-white text-emerald-900 font-semibold rounded-lg hover:bg-emerald-50 transition-colors">
                                    Lihat Perlengkapan
                                </a>
                                <a href="{{ route('cara-sewa') }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 border border-white text-white font-semibold rounded-lg hover:bg-white/10 transition-colors">
                                    Cara Sewa
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Developer Section Template --}}
                    <div class="mt-16">
                        <div class="text-center mb-10">
                            <p class="text-sm uppercase tracking-[0.3em] text-emerald-500">Tim Pengembang</p>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2">Kenalan dengan Kami</h2>
                            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                                Halo kami adalah developer dari Web Jatilawang Adventure. Semua foto diambil langsung dari postingan Instagram masing-masing anggota sesuai permintaan Anda.
                            </p>
                        </div>

                        @php
                            $developers = [
                                [
                                    'name' => 'Brifly',
                                    'role' => 'Backend Engineer & QA',
                                    'bio'  => 'Fokus di API, database dan Menguji fitur baru bagi pengguna.',
                                    'photo' => asset('storage/dev/dev1.jpg'),
                                    'instagram' => 'https://www.instagram.com/brifly._/',
                                    'instagram_label' => '@brifly._',
                                    'github' => 'https://github.com/Bilabong29',
                                    'github_label' => 'github.com/Bilabong29',
                                ],
                                [
                                    'name' => 'Riko',
                                    'role' => 'Backend Engineer',
                                    'bio'  => 'Fokus di database, controller dan mengelola agar project berjalan lancar.',
                                    'photo' => asset('storage/dev/dev2.jpg'),
                                    'instagram' => 'https://www.instagram.com/rikonbs_/',
                                    'instagram_label' => '@rikonbs_',
                                    'github' => 'https://github.com/rikoNenobais',
                                    'github_label' => 'github.com/rikoNenobais',
                                ],
                                [
                                    'name' => 'Jordy',
                                    'role' => 'Frontend Engineer',
                                    'bio'  => 'Menjaga tampilan dan interaksi UI agar tetap konsisten di berbagai perangkat.',
                                    'photo' => asset('storage/dev/dev3.jpg'),
                                    'instagram' => 'https://www.instagram.com/jordygf__/',
                                    'instagram_label' => '@jordygf__',
                                    'github' => 'https://github.com/ngabjorrr',
                                    'github_label' => 'github.com/ngabjorrr',
                                ],
                            ];
                        @endphp

                        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($developers as $dev)
                                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex flex-col">
                                    <div class="flex flex-col items-center text-center">
                                        @if(!empty($dev['photo']))
                                            <img src="{{ $dev['photo'] }}" alt="{{ $dev['name'] }}"
                                                 loading="lazy" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                                        @else
                                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-emerald-600 font-semibold text-lg uppercase">
                                                {{ Str::of($dev['name'])->substr(0, 2) }}
                                            </div>
                                        @endif
                                        <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $dev['name'] }}</h3>
                                        <p class="text-emerald-600 font-medium">{{ $dev['role'] }}</p>
                                    </div>
                                    <p class="text-gray-600 text-sm leading-relaxed mt-4 flex-1">
                                        {{ $dev['bio'] }}
                                    </p>
                                    <div class="mt-6 flex flex-wrap items-center justify-center gap-3 text-gray-500 text-sm">
                                        <a href="{{ $dev['instagram'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-emerald-100 hover:bg-emerald-50 hover:text-emerald-700 transition" aria-label="Instagram">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm0 2h10c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3zm9 2a1 1 0 100 2 1 1 0 000-2zM12 7c-2.757 0-5 2.243-5 5s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5zm0 2c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3z"/>
                                            </svg>
                                            <span>{{ $dev['instagram_label'] }}</span>
                                        </a>
                                        <a href="{{ $dev['github'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gray-200 hover:bg-gray-50 hover:text-gray-800 transition" aria-label="GitHub">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 .5C5.648.5.5 5.797.5 12.348c0 5.238 3.438 9.677 8.207 11.25.6.106.82-.27.82-.6v-2.03c-3.338.758-4.033-1.472-4.033-1.472-.546-1.44-1.332-1.824-1.332-1.824-1.09-.79.084-.774.084-.774 1.205.086 1.84 1.278 1.84 1.278 1.07 1.89 2.808 1.344 3.493 1.028.108-.8.418-1.344.762-1.653-2.666-.315-5.466-1.372-5.466-6.102 0-1.348.468-2.45 1.235-3.312-.124-.31-.536-1.562.118-3.258 0 0 1.008-.333 3.302 1.265a11.39 11.39 0 013.004-.417c1.02.004 2.046.143 3.004.417 2.292-1.598 3.3-1.265 3.3-1.265.655 1.696.243 2.948.12 3.258.77.862 1.233 1.964 1.233 3.312 0 4.74-2.807 5.782-5.48 6.09.43.382.824 1.148.824 2.318v3.433c0 .334.218.712.825.59 4.767-1.575 8.203-6.013 8.203-11.25C23.5 5.797 18.352.5 12 .5z"/>
                                            </svg>
                                            <span>{{ $dev['github_label'] }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection