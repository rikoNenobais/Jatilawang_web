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
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}?v=2">
    <meta name="theme-color" content="#065f46">
    
    <!-- Style untuk hamburger menu -->
    <style>
        .hamburger-line {
            transition: all 0.3s ease;
        }
        .hamburger-active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }
        .hamburger-active .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        .hamburger-active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }
        .mobile-menu {
            transition: all 0.3s ease;
        }
    </style>
    
    @stack('head')
</head>
<body style="font-family:sans-serif; background:white; color:#111;">
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between gap-6">
                
                {{-- Logo & Brand --}}
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-3xl font-extrabold tracking-tight text-gray-900">
                        Jatilawang
                    </a>
                </div>

                {{-- Search Bar - Tampil di tablet/desktop --}}
                <form action="{{ url('/products') }}" method="get" class="hidden md:block flex-1 max-w-2xl mx-8">
                    <label class="relative block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-5.2-5.2M17 10A7 7 0 103 10a7 7 0 0014 0z" />
                            </svg>
                        </span>
                        <input
                            type="search" name="q" placeholder="Search"
                            class="w-full h-12 rounded-2xl bg-gray-100 pl-12 pr-4 text-[15px] placeholder:text-gray-400 border-0 focus:ring-2 focus:ring-emerald-600"
                        >
                    </label>
                </form>

                {{-- Desktop Navigation - Tampil di desktop --}}
                @php
                $nav = [
                    ['label'=>'Beranda','href'=>url('/'), 'active'=>request()->routeIs('home')],
                    ['label' => 'Produk',   'href' => route('products.index'), 'active' => request()->routeIs('products.*')],
                    ['label'=>'Tentang Kami','href'=>route('tentang-kami'), 'active' => request()->routeIs('tentang-kami')],
                    ['label'=>'Kontak','href'=>route('kontak') , 'active' => request()->routeIs('kontak')],
                ];
                @endphp
                <nav class="hidden lg:flex items-center gap-7">
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}"
                    class="{{ $item['active'] ? 'text-gray-900 font-semibold' : 'text-gray-400 hover:text-gray-900' }}">
                    {{ $item['label'] }}
                    </a>
                @endforeach
                </nav>

                {{-- Desktop Icons - Tampil di tablet/desktop --}}
                <div class="hidden md:flex items-center gap-6 ml-auto">
                    {{-- Cart --}}
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative text-gray-900 hover:opacity-80 transition" aria-label="Keranjang">
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l3-7H6.4M7 13L6 6M7 13l-2 7h14M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                            </svg>
                            <span data-cart-badge class="absolute -top-2 -right-2 min-w-[20px] min-h-[20px] px-1 rounded-full bg-emerald-700 text-white text-xs font-semibold text-center">
                                0
                            </span>
                        </a>
                    @else
                        <button type="button" onclick="goToLoginWithRedirect()" class="relative text-gray-900 hover:opacity-80 cursor-pointer transition" aria-label="Keranjang (Login dulu)">
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l3-7H6.4M7 13L6 6M7 13l-2 7h14M9 21a1 1 0 100-2 1 1 0 000 2z"/>
                            </svg>
                            <span data-cart-badge class="absolute -top-2 -right-2 min-w-[20px] min-h-[20px] px-1 rounded-full bg-gray-400 text-white text-xs font-semibold text-center">
                                0
                            </span>
                        </button>
                    @endauth

                    {{-- Account --}}
                    <div class="relative">
                        @auth
                            <button type="button" id="user-menu-button" class="flex items-center gap-1 text-emerald-600 hover:text-emerald-700 transition focus:outline-none group">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
                                </svg>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                 {{-- Header Profil --}}
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->username ?? '' }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                
                                {{-- Menu Items --}}
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                                
                                <a href="{{ route('profile.change-password') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Ubah Kata Sandi
                                </a>
                                
                                <a href="{{ route('profile.orders') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Riwayat Pesanan
                                </a>
                                
                                {{-- Separator --}}
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                {{-- Logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-900 hover:opacity-80 transition" aria-label="Login">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- Hamburger Button - Tampil di mobile saja --}}
                <button id="hamburger-button" class="lg:hidden flex flex-col space-y-1.5 p-2">
                    <span class="hamburger-line block w-6 h-0.5 bg-gray-700"></span>
                    <span class="hamburger-line block w-6 h-0.5 bg-gray-700"></span>
                    <span class="hamburger-line block w-6 h-0.5 bg-gray-700"></span>
                </button>
            </div>

            {{-- Mobile Menu - Tampil saat hamburger diklik --}}
            <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-200 bg-white py-4">
                <div class="flex flex-col space-y-4">
                    {{-- Mobile Search --}}
                    <form action="{{ url('/products') }}" method="get" class="px-4">
                        <label class="relative block">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-5.2-5.2M17 10A7 7 0 103 10a7 7 0 0014 0z" />
                                </svg>
                            </span>
                            <input
                                type="search" name="q" placeholder="Search"
                                class="w-full h-12 rounded-xl bg-gray-100 pl-10 pr-4 text-[15px] placeholder:text-gray-400 border-0 focus:ring-2 focus:ring-emerald-600"
                            >
                        </label>
                    </form>

                    {{-- Mobile Navigation Links --}}
                    @foreach ($nav as $item)
                        <a href="{{ $item['href'] }}" 
                           class="{{ $item['active'] ? 'text-emerald-600 font-semibold bg-emerald-50' : 'text-gray-700' }} 
                                  block px-4 py-3 text-lg font-medium rounded-lg transition duration-200 hover:bg-gray-100">
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    {{-- Mobile Auth Links --}}
                    <div class="border-t border-gray-200 pt-4 mt-2">
                        @auth
                            <a href="{{ route('cart.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l3-7H6.4M7 13L6 6M7 13l-2 7h14M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                                </svg>
                                <span>Keranjang</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
                                </svg>
                                <span>Profil Saya</span>
                            </a>
                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center space-x-3 w-full px-4 py-3 text-red-600 hover:bg-gray-100 rounded-lg transition text-left">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/>
                                </svg>
                                <span>Login</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    {{-- Script untuk hamburger menu --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerButton = document.getElementById('hamburger-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            // Toggle hamburger menu
            if (hamburgerButton && mobileMenu) {
                hamburgerButton.addEventListener('click', function() {
                    // Toggle hamburger animation
                    hamburgerButton.classList.toggle('hamburger-active');
                    
                    // Toggle mobile menu
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Close mobile menu when clicking on links
            const mobileLinks = document.querySelectorAll('#mobile-menu a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    hamburgerButton.classList.remove('hamburger-active');
                });
            });

            // User dropdown script (tetap sama)
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');
            const chevron = userMenuButton?.querySelector('svg:last-child');

            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = userDropdown.classList.toggle('hidden');
                    
                    if (chevron) {
                        chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target) && !userMenuButton.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                        if (chevron) {
                            chevron.style.transform = 'rotate(0deg)';
                        }
                    }
                });

                userDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
</script>

    <!-- Script keranjang frontend -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Untuk user yang sudah login, gunakan data dari server
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const totalItems = {{ $totalItems ?? 0 }};
        
        if (isLoggedIn) {
            document.querySelectorAll('[data-cart-badge]').forEach(el => {
                el.textContent = totalItems;
            });
        } else {
            document.querySelectorAll('[data-cart-badge]').forEach(el => {
                el.textContent = '0';
            });
        }
    });
    </script>
    

    {{-- SCRIPT BIAR KALAU BELUM LOGIN KLIK KERANJANG LANGSUNG KE LOGIN + KEMBALI KE KERANJANG SETELAH LOGIN --}}
    <script>
        function goToLoginWithRedirect() {
            const redirectTo = '/cart';
            window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(redirectTo);
        }
    </script>
</body>
</html>