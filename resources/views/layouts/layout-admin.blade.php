    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Admin - @yield('title', 'Dashboard')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 antialiased">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="hidden md:flex md:flex-col md:w-64 bg-white shadow-lg border-r border-slate-100">
            {{-- Brand --}}
            <div class="p-4 border-b border-slate-100 bg-gradient-to-r from-indigo-600 to-blue-500">
                <h1 class="font-bold text-lg text-white tracking-tight">
                    Jatilawang Admin
                </h1>
                <p class="text-xs text-indigo-100 mt-1">
                    Panel pengelolaan rental & penjualan
                </p>
            </div>

            {{-- Menu --}}
            <nav class="flex-1 p-3 space-y-1 text-sm">
                @php
                $navItems = [
                    [
                        'label' => 'Dashboard',
                        'route' => 'admin.dashboard',
                        'icon'  => 'M3 13.5l9-9 9 9M5.25 12.75V21h4.5v-4.5h4.5V21h4.5v-8.25',
                    ],
                    [
                        'label' => 'Laporan Keuangan',
                        'route' => 'admin.financial-report',
                        'icon'  => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
                    ],
                    [
                        'label' => 'Produk (Items)',
                        'route' => 'admin.items.index',
                        'icon'  => 'M4.5 6.75l7.5-3 7.5 3M4.5 6.75V12l7.5 3 7.5-3V6.75',
                    ],
                    [
                        'label' => 'Peminjaman',
                        'route' => 'admin.rentals.index',
                        'icon'  => 'M4.5 9.75l7.5-3 7.5 3m-15 3l7.5 3 7.5-3',
                    ],
                    [
                        'label' => 'Pembelian',
                        'route' => 'admin.buys.index',
                        'icon'  => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                    ],
                    [
                        'label' => 'Transaksi',
                        'route' => 'admin.transactions.index',
                        'icon'  => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z',
                    ],
                    [
                        'label' => 'Pengguna',
                        'route' => 'admin.users.index',
                        'icon'  => 'M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0',
                    ],
                    [
                        'label' => 'Review',
                        'route' => 'admin.reviews.index',
                        'icon'  => 'M4.5 4.5h15v9H9.75L6 17.25V13.5H4.5z',
                    ],
                ];
            @endphp

                @foreach($navItems as $item)
                    @php
                        $active = request()->routeIs($item['route'].'*');
                    @endphp

                    <a href="{{ route($item['route']) }}"
                    class="group flex items-center gap-3 px-3 py-2 rounded-lg
                            {{ $active
                                ? 'bg-indigo-50 text-indigo-700 font-semibold'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ $active ? 'text-indigo-500' : 'text-slate-400 group-hover:text-slate-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                        </svg>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Footer kecil --}}
            <div class="p-3 border-t border-slate-100 text-[11px] text-slate-400">
                © {{ date('Y') }} Jatilawang Adventure
            </div>
        </aside>

        {{-- Konten utama --}}
        <main class="flex-1 flex flex-col">

            {{-- Topbar --}}
            <header class="bg-white border-b border-slate-100 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-semibold text-lg text-slate-800 leading-tight">
                            @yield('header', 'Dashboard')
                        </h2>
                        <p class="text-xs text-slate-500">
                            Kelola data produk, peminjaman, user, dan review di sini.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-xs text-slate-400">Masuk sebagai</span>
                            <span class="text-sm font-medium text-slate-800">
                                {{ auth()->user()->full_name ?? auth()->user()->username ?? auth()->user()->email ?? 'Admin' }}
                            </span>
                        </div>
                        <form class="inline" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-semibold rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Isi halaman --}}
            <section class="flex-1 py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div
                            class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-start gap-2">
                            <svg class="w-5 h-5 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75l1.5 1.5L15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </section>
        </main>
    </div>
    </body>
    </html>
