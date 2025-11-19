<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Jatilawang Adventure')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Favicon utama -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/logo/logo-jatilawang.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/logo/logo-jatilawang.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}?v=2"> {{-- jika punya versi .ico --}}

    <!-- (opsional) Apple/Safari -->
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}?v=2">
    <meta name="theme-color" content="#065f46">
    @stack('head')

</head>
<body style="font-family:sans-serif; background:white; color:#111;">
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center gap-6">

        {{-- Brand --}}
        <a href="{{ url('/') }}" class="text-3xl font-extrabold tracking-tight text-gray-900">
        Jatilawang
        </a>

        {{-- Search --}}
        <form action="{{ url('/products') }}" method="get" class="hidden md:block flex-1">
        <label class="relative block">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
            {{-- icon search --}}
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-5.2-5.2M17 10A7 7 0 103 10a7 7 0 0014 0z" />
            </svg>
            </span>
            <input
            type="search" name="q" placeholder="Search"
            class="w-full h-12 rounded-2xl bg-gray-100 pl-12 pr-4 text-[15px] placeholder:text-gray-400
                    border-0 focus:ring-2 focus:ring-emerald-600"
            >
        </label>
        </form>

        {{-- Nav --}}
        @php
        $nav = [
            ['label'=>'Home','href'=>url('/') , 'active'=>request()->routeIs('home')],
            ['label'=>'About','href'=>'#' , 'active'=>false],
            ['label'=>'Contact Us','href'=>'#' , 'active'=>false],
            ['label'=>'Blog','href'=>'#' , 'active'=>false],
        ];
        @endphp
        <nav class="hidden lg:flex items-center gap-8">
        @foreach ($nav as $item)
            <a href="{{ $item['href'] }}"
            class="{{ $item['active'] ? 'text-gray-900 font-semibold' : 'text-gray-400 hover:text-gray-900' }}">
            {{ $item['label'] }}
            </a>
        @endforeach
        </nav>

        {{-- Icons --}}
        <div class="ml-auto flex items-center gap-6">
        {{-- Wishlist --}}
        <a href="{{ url('/wishlist') }}" class="text-gray-900 hover:opacity-80" aria-label="Wishlist">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.5c0-2.2-1.8-4-4-4-1.6 0-3 .9-3.6 2.4A4 4 0 006 4.5c-2.2 0-4 1.8-4 4 0 6.3 10 10.5 10 10.5S21 14.8 21 8.5z"/>
            </svg>
        </a>

        {{-- Cart --}}
        <a href="{{ url('/cart') }}" class="text-gray-900 hover:opacity-80" aria-label="Cart">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3h2l.4 2M7 13h10l3-7H6.4M7 13L6 6M7 13l-2 7h14M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
            </svg>
        </a>

        {{-- Account --}}
        <a href="{{ auth()->check() ? url('/') : url('/login') }}"
            class="text-gray-900 hover:opacity-80" aria-label="Account">
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
            </svg>
        </a>
        </div>
    </div>
    </header>

    <main>
        @yield('content')
    </main>

    @include('components.footer')

</body>
</html>
