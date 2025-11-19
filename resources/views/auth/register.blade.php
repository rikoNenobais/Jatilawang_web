<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar - Jatilawang Adventure</title>
  <meta name="description" content="Bergabung dengan Jatilawang Adventure dan temukan perlengkapan terbaik untuk petualanganmu." />

  @vite(['resources/css/app.css','resources/js/app.js'])

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Raleway:wght@700;800&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen font-inter bg-gradient-to-r from-emerald-50 via-emerald-100/50 to-white text-neutral-900">
  <main class="grid min-h-screen grid-rows-[1fr_auto] overflow-hidden">

    {{-- ===== HERO REGISTER ===== --}}
    <section class="relative grid w-full md:grid-cols-2 min-h-screen">

      {{-- KIRI: FORM REGISTER --}}
      <div class="flex items-center justify-center px-8 md:px-16 py-20 bg-gradient-to-br from-white via-emerald-50 to-emerald-100">
        <div class="w-full max-w-xl bg-white/80 backdrop-blur-md rounded-3xl shadow-lg ring-1 ring-emerald-100 p-10 md:p-12 transition-transform duration-300 hover:shadow-xl">

          {{-- Judul --}}
          <h1 class="mb-2 text-3xl md:text-4xl font-raleway font-extrabold text-emerald-900 tracking-tight">
            Daftar Sekarang
          </h1>
          <p class="mb-10 text-sm text-emerald-700/80">
            Buat akun untuk memulai petualanganmu bersama Jatilawang Adventure.
          </p>

          {{-- Form --}}
          <form action="{{ route('register') }}" method="POST" novalidate class="space-y-6">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
              <label for="full_name" class="block text-sm font-medium text-emerald-900 mb-1">Nama Lengkap</label>
              <input id="full_name" name="full_name" type="text" required
                     placeholder="Masukkan nama lengkap Anda"
                     value="{{ old('full_name') }}"
                     class="mt-1 block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 text-[15px] text-emerald-900
                            placeholder:text-emerald-650 outline-none transition-all duration-200
                            hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">
              @error('full_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
              <label for="email" class="block text-sm font-medium text-emerald-900 mb-1">Email</label>
              <input id="email" name="email" type="email" required
                     placeholder="Masukkan email anda"
                     value="{{ old('email') }}"
                     class="mt-1 block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 text-[15px] text-emerald-900
                            placeholder:text-emerald-650 outline-none transition-all duration-200
                            hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">
              @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
              <label for="password" class="block text-sm font-medium text-emerald-900 mb-1">Password</label>
              <div class="relative">
                <input id="password" name="password" type="password" required minlength="8"
                       placeholder="Buat password minimal 8 karakter"
                       class="block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 pr-10 text-[15px] text-emerald-900
                              placeholder:text-emerald-650 outline-none transition-all duration-200
                              hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">
                <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 grid w-10 place-items-center text-emerald-700/60 hover:text-emerald-800 transition">👁</button>
              </div>
              @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-emerald-900 mb-1">Konfirmasi Password</label>
              <input id="password_confirmation" name="password_confirmation" type="password" required
                     placeholder="Ulangi password Anda"
                     class="mt-1 block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 text-[15px] text-emerald-900
                            placeholder:text-emerald-650 outline-none transition-all duration-200
                            hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">
              @error('password_confirmation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Username --}}
            <div>
              <label for="username" class="block text-sm font-medium text-emerald-900 mb-1">Username</label>
              <input id="username" name="username" type="text" required
                     placeholder="Masukkan username Anda"
                     value="{{ old('username') }}"
                     class="mt-1 block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 text-[15px] text-emerald-900
                            placeholder:text-emerald-650 outline-none transition-all duration-200
                            hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">
              @error('username') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Nomor Telepon --}}
            <div>
              <label for="phone_number" class="block text-sm font-medium text-emerald-900 mb-1">Nomor Telepon</label>
              <input id="phone_number" name="phone_number" type="text"
                     placeholder="Masukkan nomor telepon Anda"
                     value="{{ old('phone_number') }}"
                     class="mt-1 block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 text-[15px] text-emerald-900
                            placeholder:text-emerald-650 outline-none transition-all duration-200
                            hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">
              @error('phone_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Alamat --}}
            <div>
              <label for="address" class="block text-sm font-medium text-emerald-900 mb-1">Alamat</label>
              <textarea id="address" name="address" rows="3"
                        placeholder="Masukkan alamat Anda"
                        class="mt-1 block w-full rounded-xl border border-emerald-100 bg-emerald-50/40 px-4 py-3 text-[15px] text-emerald-900
                               placeholder:text-emerald-650 outline-none transition-all duration-200
                               hover:border-emerald-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-200 focus:shadow-md focus:shadow-emerald-100">{{ old('address') }}</textarea>
              @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Checkbox Persetujuan --}}
            <label class="flex items-center gap-2 text-sm">
              <input type="checkbox" class="rounded border-neutral-300 text-emerald-600 focus:ring-emerald-600" required>
              <span class="text-emerald-800">Saya setuju dengan <a href="#" class="underline hover:text-emerald-700">syarat & ketentuan</a></span>
            </label>

            {{-- Tombol Daftar --}}
            <button type="submit"
                    class="w-full rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 py-3.5 text-white font-semibold shadow-md
                           hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 hover:shadow-lg text-[15px]">
              Daftar Sekarang
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
                <span class="font-medium text-neutral-700">Daftar dengan Google</span>
              </a>

              <a href="{{ route('social.redirect','apple') }}"
                 class="flex flex-1 items-center justify-center gap-3 rounded-lg border border-neutral-200 bg-white py-2.5 text-sm hover:bg-neutral-50 shadow-sm transition">
                <img src="{{ asset('storage/icons/apple.png') }}" alt="Logo Apple" class="h-5 w-5 object-contain">
                <span class="font-medium text-neutral-700">Daftar dengan Apple</span>
              </a>
            </div>

            <p class="text-xs text-neutral-700 text-center">
              Sudah punya akun?
              <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:text-emerald-900">Masuk</a>
            </p>
          </form>
        </div>
      </div>

      {{-- KANAN: GAMBAR --}}
      <div class="relative hidden md:block overflow-hidden">
        <img src="{{ asset('storage/hero/peaks.jpg') }}"
             alt="Pemandangan gunung dengan matahari terbit - Jatilawang Adventure"
             class="absolute inset-0 h-full w-full object-cover object-center brightness-90">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-emerald-900/20 to-transparent"></div>
        <div class="absolute bottom-8 right-8 text-right text-emerald-50/90 text-xs tracking-wide">
          <p class="font-semibold uppercase">Jatilawang Adventure</p>
          <p class="text-emerald-100/80">Bersiaplah untuk Menaklukkan Alam Bersama Kami</p>
        </div>
      </div>
    </section>
  </main>

  <!-- Toggle Password -->
  <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
      const pass = document.getElementById('password');
      pass.type = pass.type === 'password' ? 'text' : 'password';
    });
  </script>
</body>
</html>
