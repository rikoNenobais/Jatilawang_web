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
            ['label'=>'Beranda','href'=>url('/'), 'active'=>request()->routeIs('home')],
            ['label' => 'Produk',   'href' => route('products.index'), 'active' => request()->routeIs('products.*')],
            ['label'=>'Kontak','href'=>route('kontak') , 'active' => request()->routeIs('kontak')],
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

{{-- CART – hanya bisa diakses kalau sudah login --}}
@auth
    <a href="{{ route('cart.index') }}" class="relative text-gray-900 hover:opacity-80 transition" aria-label="Keranjang">
        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M3 3h2l.4 2M7 13h10l3-7H6.4M7 13L6 6M7 13l-2 7h14M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
        </svg>

        {{-- Badge jumlah item --}}
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
        <a href="{{ auth()->check() ? route('home') : route('login') }}"
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

    <!-- Script keranjang frontend -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const CART_KEY = 'keujak_cart';

            function normalizeNumber(value) {
                const num = typeof value === 'string' ? value.replace(/[^0-9.-]/g, '') : value;
                return Number(num) || 0;
            }

            function normalizeCartShape(raw) {
                if (Array.isArray(raw)) {
                    return raw.map(item => ({
                        id: item.id,
                        name: item.name,
                        qty: Math.max(1, Number(item.qty ?? item.quantity) || 1),
                        price: normalizeNumber(item.price),
                        image: item.image || '',
                        sku: item.sku || ''
                    }));
                }

                if (raw && typeof raw === 'object') {
                    return Object.entries(raw).map(([id, item]) => ({
                        id,
                        name: item.name || '',
                        qty: Math.max(1, Number(item.qty ?? item.quantity) || 1),
                        price: normalizeNumber(item.price),
                        image: item.image || '',
                        sku: item.sku || ''
                    }));
                }

                return [];
            }

            function getCart() {
                try {
                    const parsed = JSON.parse(localStorage.getItem(CART_KEY));
                    const normalized = normalizeCartShape(parsed || []);
                    // Simpan kembali jika sebelumnya bukan array
                    if (parsed && !Array.isArray(parsed)) {
                        saveCart(normalized);
                    }
                    return normalized;
                } catch {
                    return [];
                }
            }

            function saveCart(items) {
                localStorage.setItem(CART_KEY, JSON.stringify(items));
            }

            function updateCartBadge(items = null) {
                const cart = items ?? getCart();
                const totalItems = cart.reduce((sum, item) => sum + (item.qty || 0), 0);
                document.querySelectorAll('[data-cart-badge]').forEach(el => {
                    el.textContent = totalItems;
                });
            }

            function addToCart(payload) {
                const cart = getCart();
                const existing = cart.find(item => String(item.id) === String(payload.id));

                if (existing) {
                    existing.qty += payload.qty;
                } else {
                    cart.push({
                        id: payload.id,
                        name: payload.name,
                        qty: payload.qty,
                        price: payload.price,
                        image: payload.image,
                        sku: payload.sku || ''
                    });
                }

                saveCart(cart);
                updateCartBadge(cart);
            }

            document.body.addEventListener('click', function (event) {
                const button = event.target.closest('.add-to-cart');
                if (!button) return;

                const quantityTarget = button.dataset.quantityTarget;
                const qtySource = quantityTarget ? document.querySelector(quantityTarget) : null;
                const qty = qtySource ? Number(qtySource.value) : Number(button.dataset.quantity);

                const payload = {
                    id: button.dataset.id,
                    name: button.dataset.name,
                    qty: Math.max(1, qty || 1),
                    price: normalizeNumber(button.dataset.price),
                    image: button.dataset.image || '',
                    sku: button.dataset.sku || ''
                };

                addToCart(payload);
                alert(`${payload.name} telah ditambahkan ke keranjang!`);
            });

            updateCartBadge();
        });
    </script>

    {{-- SCRIPT BIAR KALAU BELUM LOGIN KLIK KERANJANG LANGSUNG KE LOGIN + KEMBALI KE KERANJANG SETELAH LOGIN --}}
    <script>
        function goToLoginWithRedirect() {
            const redirectTo = '/cart';
            window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(redirectTo);
        }
    </script>

    {{-- KALAU MAU SETELAH LOGIN OTOMATIS BALIK KE KERANJANG, TAMBAHKAN INI DI LoginController (method authenticated) --}}
    {{-- 
    protected function authenticated(Request $request, $user)
    {
        if ($request->has('redirect')) {
            return redirect($request->get('redirect'));
        }
        return redirect()->intended(route('home'));
    }
    --}}
</body>
</html>