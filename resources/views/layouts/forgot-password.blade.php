@extends('layouts.public')

@section('title', 'Reset Password - Jatilawang Adventure')

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
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Reset Password</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Buat kata sandi baru untuk akun Anda
                </p>
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <section class="py-16 bg-white">
        <div class="max-w-md mx-auto px-6 md:px-8">
            <div class="bg-white rounded-xl border border-gray-200 p-6 md:p-8">
                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Password Baru</h2>
                <p class="text-gray-600 mb-6 text-center">
                    Masukkan password baru untuk akun Anda
                </p>
                
                <form action="{{ route('password.store') }}" method="POST">
                    @csrf
                    
                    {{-- Token Hidden --}}
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email Hidden --}}
                    <input type="hidden" name="email" value="{{ $request->email }}">

                    {{-- New Password --}}
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru *
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password"
                               required
                               minlength="8"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                               placeholder="Minimal 8 karakter">
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru *
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                               placeholder="Ulangi password baru">
                    </div>

                    {{-- Password Requirements --}}
                    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-blue-900 mb-2">Persyaratan Password:</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Minimal 8 karakter</li>
                            <li>• Disarankan kombinasi huruf dan angka</li>
                        </ul>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection