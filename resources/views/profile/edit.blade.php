@extends('layouts.public')

@section('title', 'Profil Saya - Jatilawang Adventure')

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
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Profil Saya</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Kelola informasi profil Anda
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

            <div class="grid lg:grid-cols-3 gap-8">
                {{-- ===================== SIDEBAR NAVIGATION ===================== --}}
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Profil</h3>
                        <nav class="space-y-2">
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center gap-3 px-3 py-2 bg-emerald-600 text-white rounded-lg font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                            <a href="{{ route('profile.change-password') }}" 
                               class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Ubah Kata Sandi
                            </a>
                            <a href="#" 
                               class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Riwayat Pesanan
                            </a>
                        </nav>
                    </div>
                </div>

                {{-- ===================== PROFIL VIEW ===================== --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 md:p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Informasi Profil</h2>
                            <button type="button" 
                                    onclick="openEditModal()"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Ubah Profil
                            </button>
                        </div>

                        {{-- Profil Display --}}
                        <div class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                    <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-gray-900">{{ $user->username }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-gray-900">{{ $user->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-900">{{ $user->full_name ?? '-' }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-900">{{ $user->phone_number ?? '-' }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200 min-h-[100px]">
                                    <p class="text-gray-900 whitespace-pre-line">{{ $user->address ?? '-' }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Peran</label>
                                <div class="px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-900 capitalize">{{ $user->role }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Account Info Card --}}
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Informasi Akun</h3>
                        <div class="space-y-2 text-sm text-blue-800">
                            <p><strong>ID Pengguna:</strong> {{ $user->user_id }}</p>
                            <p><strong>Bergabung sejak:</strong> {{ $user->created_at->format('d F Y') }}</p>
                            <p><strong>Terakhir diperbarui:</strong> {{ $user->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== EDIT MODAL ===================== --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 md:p-8 mx-4 max-w-md w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Konfirmasi Kata Sandi</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <p class="text-gray-600 mb-6">Masukkan kata sandi Anda untuk mengubah profil</p>
            
            <form id="passwordForm" action="{{ route('profile.verify') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Kata Sandi *
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                           placeholder="Masukkan kata sandi Anda">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex gap-3">
                    <button type="submit"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        Konfirmasi
                    </button>
                    <button type="button" 
                            onclick="closeEditModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('password').focus();
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('passwordForm').reset();
        }

        // Tutup modal ketika klik di luar
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Tutup modal dengan ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
            }
        });
    </script>
@endsection