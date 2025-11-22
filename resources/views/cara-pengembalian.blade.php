@extends('layouts.public')

@section('title', 'Cara Pengembalian - Jatilawang Adventure')

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
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Cara Pengembalian</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Panduan lengkap pengembalian perlengkapan setelah masa sewa berakhir
                </p>
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-8">
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-600 mb-8">
                    Setelah menggunakan perlengkapan yang disewa dari Jatilawang Adventure, pengembalian alat adalah bagian penting dari proses penyewaan. 
                    Pastikan untuk mengikuti prosedur pengembalian dengan cermat untuk menghindari biaya keterlambatan atau masalah lainnya.
                </p>

                <div class="space-y-12">
                    {{-- Langkah 1 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">1</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Pengembalian Mandiri</h3>
                            <p class="text-gray-600 mb-3">
                                Pelanggan diwajibkan untuk mengembalikan alat secara langsung ke lokasi Jatilawang Adventure sesuai dengan tanggal dan waktu yang telah disepakati saat pemesanan.
                            </p>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pastikan Anda membawa alat dalam kondisi yang baik dan lengkap, sesuai dengan saat alat diterima.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Langkah 2 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">2</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Pengembalian dengan Ojek Online (untuk Member Pro)</h3>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Member Pro dapat mengembalikan alat dengan menggunakan layanan ojek online.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pengembalian alat wajib dipantau hingga sampai di lokasi Jatilawang Adventure.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Member Pro tidak diwajibkan menitipkan KTP sebagai jaminan.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Langkah 3 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">3</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Keterlambatan Pengembalian</h3>
                            <p class="text-gray-600 mb-3">
                                Keterlambatan pengembalian hanya diperbolehkan jika telah mendapat persetujuan dari Jatilawang Adventure sebelumnya.
                            </p>
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                                <h4 class="font-semibold text-amber-800 mb-2">Biaya Keterlambatan:</h4>
                                <ul class="text-amber-700 space-y-1 text-sm">
                                    <li>• 00:01 – 12:00 → 10% dari total biaya sewa</li>
                                    <li>• 12:01 – 15:00 → 20% dari total biaya sewa</li>
                                    <li>• 15:01 – 18:00 → 30% dari total biaya sewa</li>
                                    <li>• 18:01 – 21:00 → 50% dari total biaya sewa</li>
                                    <li>• Keterlambatan lebih dari pukul 21:00 → 100% dari total biaya sewa</li>
                                </ul>
                            </div>
                            <p class="text-gray-600 text-sm">
                                Keterlambatan lebih dari pukul 21:00 tanpa pemberitahuan dianggap sebagai pelanggaran berat dan dapat dikenakan sanksi hukum.
                            </p>
                        </div>
                    </div>

                    {{-- Langkah 4 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">4</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Pengembalian oleh Perwakilan</h3>
                            <p class="text-gray-600 mb-3">
                                Jika tidak dapat mengembalikan alat secara langsung, pelanggan dapat menunjuk perwakilan dengan syarat:
                            </p>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Perwakilan harus mampu memeriksa kondisi fisik, kelengkapan, dan fungsi alat.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Segala kendala setelah pengembalian menjadi tanggung jawab penuh pelanggan.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Langkah 5 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">5</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Persetujuan Kondisi Alat</h3>
                            <p class="text-gray-600 mb-3">
                                Setelah alat dikembalikan, tim Jatilawang Adventure akan memeriksa kondisi alat secara menyeluruh.
                            </p>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Jika alat diterima tanpa kerusakan, pelanggan akan diminta menandatangani surat pengembalian.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Segala masalah setelah pengembalian dalam kondisi baik menjadi tanggung jawab Jatilawang Adventure.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Langkah 6 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">6</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Proses Pengembalian Dana (Refund)</h3>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pelanggan harus merespons proses refund dalam waktu 3 hari.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Setelah 3 hari, refund akan dianggap kedaluwarsa.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Respons setelah kedaluwarsa dikenakan biaya administrasi 10% (maks. Rp150.000).
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Tidak ada respons hingga hari ke-30, nilai refund dianggap hangus.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Langkah 7 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">7</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Penting untuk Diperhatikan</h3>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pastikan alat dikembalikan dalam kondisi sesuai saat diterima.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Keterlambatan tanpa pemberitahuan dikenakan biaya tambahan.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Alat tidak lengkap/rusak dikenakan biaya penggantian/perbaikan.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection