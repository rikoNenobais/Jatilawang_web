@extends('layouts.guest')

@section('title', 'Lupa Password - Jatilawang Adventure')

@section('content')
    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden py-16 md:py-24">
        <div class="absolute inset-0">
            <img src="{{ asset('storage/hero/peaks.jpg') }}" 
                 alt="Pegunungan Jatilawang Adventure" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/80 via-emerald-800/70 to-teal-700/80"></div>
        </div>
        
        <div class="pointer-events-none absolute -top-40 -left-40 h-[700px] w-[700px] rounded-full bg-emerald-900/20 blur-3xl"></div>
        
        <div class="relative max-w-7xl mx-auto px-6 md:px-8">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Lupa Password</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Reset kata sandi akun Anda
                </p>
            </div>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <section class="py-16 bg-white">
        <div class="max-w-md mx-auto px-6 md:px-8">
            <div class="bg-white rounded-xl border border-gray-200 p-6 md:p-8">
                @if (session('status'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

               @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>
                                @if($error == 'The email field is required.')
                                    Alamat email wajib diisi.
                                @elseif($error == 'The email must be a valid email address.')
                                    Format alamat email tidak valid.
                                @elseif($error == 'We can\'t find a user with that email address.')
                                    Tidak ditemukan pengguna dengan email tersebut.
                                @elseif($error == 'We have emailed your password reset link.')
                                    Link reset password telah dikirim ke email Anda.
                                @else
                                    {{ $error }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Reset Password</h2>
                <p class="text-gray-600 mb-6 text-center">
                    Masukkan email Anda, kami akan mengirim link reset password
                </p>
                
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email"
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                               placeholder="email@example.com">
                    </div>

                    <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors mb-4">
                        Kirim Link Reset
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" 
                           class="text-emerald-600 hover:text-emerald-700 font-medium">
                            ← Kembali ke Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection