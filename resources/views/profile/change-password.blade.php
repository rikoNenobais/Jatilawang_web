@extends('layouts.public')

@section('title', 'Ubah Kata Sandi - Jatilawang Adventure')

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
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Ubah Kata Sandi</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Perbarui kata sandi akun Anda untuk keamanan yang lebih baik
                </p>
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-8">
            {{-- Alert Success --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Alert Error --}}
            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                {{-- ===================== SIDEBAR NAVIGATION ===================== --}}
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Profil</h3>
                        <nav class="space-y-2">
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                            <a href="{{ route('profile.change-password') }}" 
                               class="flex items-center gap-3 px-3 py-2 bg-emerald-600 text-white rounded-lg font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Ubah Kata Sandi
                            </a>
                            
                            {{-- Hanya tampilkan untuk customer --}}
                            @if(auth()->user()->role === 'customer')
                            <a href="{{ route('profile.orders') }}" 
                               class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Riwayat Pesanan
                            </a>
                            @endif
                        </nav>
                    </div>
                </div>

                {{-- ===================== FORM UBAH PASSWORD ===================== --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Ubah Kata Sandi</h2>
                        
                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Current Password --}}
                            <div class="mb-6">
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kata Sandi Saat Ini *
                                </label>
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Masukkan kata sandi saat ini">
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="mb-6">
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kata Sandi Baru *
                                </label>
                                <input type="password" 
                                       id="new_password" 
                                       name="new_password"
                                       required
                                       minlength="8"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Minimal 8 karakter">
                                @error('new_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm New Password --}}
                            <div class="mb-6">
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Kata Sandi Baru *
                                </label>
                                <input type="password" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Ulangi kata sandi baru">
                            </div>

                            {{-- Password Requirements --}}
                            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-semibold text-blue-900 mb-2">Persyaratan Kata Sandi:</h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Minimal 8 karakter</li>
                                    <li>• Disarankan kombinasi huruf dan angka</li>
                                    <li>• Hindari kata sandi yang mudah ditebak</li>
                                </ul>
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex gap-4">
                                <button type="submit"
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                                    Ubah Kata Sandi
                                </button>
                                <a href="{{ route('profile.edit') }}"
                                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Security Info Card --}}
                    <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-amber-900 mb-2">Tips Keamanan</h3>
                        <div class="space-y-2 text-sm text-amber-800">
                            <p>• Gunakan kata sandi yang unik dan berbeda dari akun lain</p>
                            <p>• Jangan bagikan kata sandi Anda kepada siapapun</p>
                            <p>• Ganti kata sandi secara berkala untuk keamanan optimal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection