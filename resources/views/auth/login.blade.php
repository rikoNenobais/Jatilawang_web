<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Jatilawang Adventure</title>

  @vite(['resources/css/app.css','resources/js/app.js'])

  <!-- Fonts -->
  <link rel="icon" href="{{ asset('storage/logo/logo-jatilawang.png') }}" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Raleway:wght@700;800&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen font-inter bg-gradient-to-r from-emerald-50 via-emerald-100/50 to-white text-neutral-900">
  <main class="grid min-h-screen grid-rows-[1fr_auto] overflow-hidden">

    {{-- ===== HERO LOGIN ===== --}}
    <section class="relative grid w-full md:grid-cols-2 min-h-screen">

      {{-- KIRI: FORM LOGIN --}}
      <div class="flex items-center justify-center px-8 md:px-16 py-20 bg-gradient-to-br from-white via-emerald-50 to-emerald-100">
        <div class="w-full max-w-xl bg-white/80 backdrop-blur-md rounded-3xl shadow-lg ring-1 ring-emerald-100 p-10 md:p-12 transition-transform duration-300 hover:shadow-xl">

          {{-- Judul --}}
          <h1 class="mb-2 text-3xl md:text-4xl font-raleway font-extrabold text-emerald-900 tracking-tight">
            Selamat Datang Kembali!
          </h1>
          <p class="mb-10 text-sm text-emerald-700/80">
            Masuk untuk melanjutkan petualanganmu bersama Jatilawang Adventure
          </p>

          {{-- Form --}}
          <form method="POST" action="{{ route('login') }}" class="space-y-6" novalidate>
            @csrf

            {{-- Email atau Username --}}
            <div>
              <label for="email" class="block text-sm font-medium text-emerald-900 mb-1">Email atau Username</label>
              <input id="email" name="email" type="text" autocomplete="username" required
                     placeholder="Masukkan email atau username Anda"
                     value="{{ old('email') }}"
                     class="mt-1 block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 text-[15px] text-emerald-900
                            placeholder:text-emerald-650 outline-none transition-all duration-200
                            hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">
              @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
              <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-emerald-900 mb-1">Password</label>
                <a href="{{ route('password.request') }}" class="text-xs font-medium text-emerald-700 hover:text-emerald-900 transition">Lupa password?</a>
              </div>
              <div class="relative">
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       placeholder="Masukkan password"
                       class="block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 pr-10 text-[15px] text-emerald-900
                              placeholder:text-emerald-650 outline-none transition-all duration-200
                              hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">
                <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 grid w-10 place-items-center text-emerald-700/60 hover:text-emerald-800 transition">👁</button>
              </div>
              @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Remember Me --}}
            <label class="flex items-center gap-2 text-sm">
              <input type="checkbox" name="remember" class="rounded border-neutral-300 text-emerald-600 focus:ring-emerald-600">
              <span class="text-emerald-800">Ingat saya</span>
            </label>

            {{-- Tombol Login --}}
            <button type="submit"
              class="w-full rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 py-3.5 text-white font-semibold shadow-md
                     hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 hover:shadow-lg text-[15px]">
              Masuk Sekarang
            </button>

            {{-- Divider --}}
            <div class="my-5 flex items-center gap-3 text-xs text-neutral-500">
              <span class="h-px flex-1 bg-neutral-200"></span> Atau <span class="h-px flex-1 bg-neutral-200"></span>
            </div>

            {{-- OAuth --}}
            <div class="flex flex-col sm:flex-row gap-3">
              <a href="{{ route('social.redirect','google') }}"
                 class="flex flex-1 items-center justify-center gap-3 rounded-lg border border-neutral-200 bg-white py-2.5 text-sm hover:bg-neutral-50 shadow-sm transition">
                <img src="{{ asset('storage/icons/google.png') }}" alt="Logo Google" class="h-5 w-5 object-contain">
                <span class="font-medium text-neutral-700">Masuk dengan Google</span>
              </a>

              <a href="{{ route('social.redirect','apple') }}"
                 class="flex flex-1 items-center justify-center gap-3 rounded-lg border border-neutral-200 bg-white py-2.5 text-sm hover:bg-neutral-50 shadow-sm transition">
                <img src="{{ asset('storage/icons/apple.png') }}" alt="Logo Apple" class="h-5 w-5 object-contain">
                <span class="font-medium text-neutral-700">Masuk dengan Apple</span>
              </a>
            </div>

            <p class="text-xs text-neutral-700 text-center">
              Belum punya akun?
              <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-900">Daftar Sekarang</a>
            </p>
          </form>
        </div>
      </div>

      {{-- KANAN: GAMBAR --}}
      <div class="relative hidden md:block overflow-hidden">
        <img src="{{ asset('storage/hero/peaks.jpg') }}"
             alt="Pemandangan gunung Jatilawang Adventure"
             class="absolute inset-0 h-full w-full object-cover object-center brightness-90">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-emerald-900/20 to-transparent"></div>
        <div class="absolute bottom-8 right-8 text-right text-emerald-50/90 text-xs tracking-wide">
          <p class="font-semibold uppercase">Jatilawang Adventure</p>
          <p class="text-emerald-100/80">Temani Setiap Langkahmu Menjelajahi Alam</p>
        </div>
      </div>
    </section>
  </main>

  <!-- Toggle password -->
  <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
      const pass = document.getElementById('password');
      pass.type = pass.type === 'password' ? 'text' : 'password';
    });
  </script>
</body>
</html>
