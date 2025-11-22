@extends('layouts.public')

@section('title', 'Cara Sewa - Jatilawang Adventure')

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
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Cara Sewa</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Panduan lengkap untuk menyewa perlengkapan adventure di Jatilawang Adventure
                </p>
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-8">
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-600 mb-8">
                    Sebagai penyedia layanan penyewaan perlengkapan pendidikan dan kegiatan outdoor, 
                    Jatilawang Adventure berkomitman memanfaatkan kemudahan dan kenyamanan dalam setiap proses pemesanan. 
                    Berikut langkah-langkah yang perlu Anda ikuti.
                </p>

                <div class="space-y-12">
                    {{-- Step 1 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">1</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Periksa Ketersediaan Perlengkapan</h3>
                            <p class="text-gray-600">
                                Silakan kunjungi website Jatilawang Adventure untuk melihat perlengkapan yang tersedia untuk disewa. 
                                Informasi tersedia diperbarui secara berkala agar Anda dapat merencanakan kegiatan dengan lebih tepat.
                            </p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">2</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Pastikan Anda Terdaftar sebagai Anggota</h3>
                            <p class="text-gray-600 mb-3">
                                Layanan penyewaan hanya tersedia bagi pengguna yang telah menjadi anggota Jatilawang Adventure.
                            </p>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Jika Anda belum memiliki akun, silakan lakukan pendaftaran terlebih dahulu sebelum melakukan penyewaan.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Panduan lengkap mengenai proses registrasi tersedia di halaman pendaftaran.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">3</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Pilih Barang dan Lakukan Transaksi melalui Website</h3>
                            <p class="text-gray-600 mb-3">
                                Setelah memastikan Anda telah menjadi anggota, silakan pilih perlengkapan yang diinginkan melalui website Jatilawang Adventure.
                            </p>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Layanan tersedia untuk penyewaan secara online di website dan upload bukti pembayaran pada halaman yang telah disediakan.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Setelah upload bukti pembayaran, hubungi tim Jatilawang Adventure melalui WhatsApp untuk memastikan proses penyewaan berjalan dengan lancar.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">4</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Pengambilan Perlengkapan di Lokasi Store</h3>
                            <p class="text-gray-600">
                                Datang ke store Jatilawang Adventure sesuai dengan jadwal pengambilan yang telah disepakati.
                            </p>
                            <p class="text-gray-600 mt-2">
                                Informasi lengkap mengenai lokasi, waktu operasional, dan petunjuk pengambilan perlengkapan tersedia di website.
                            </p>
                        </div>
                    </div>

                    {{-- Step 5 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">5</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Gunakan Perlengkapan dengan Tanggung Jawab</h3>
                            <p class="text-gray-600 mb-3">
                                Selama masa sewa, gunakan perlengkapan sesuai fungsi dan dengan penuh tanggung jawab.
                            </p>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Jaga kebersihan perlengkapan selama digunakan dan lakukan perawatan yang wajar.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Jika terjadi kerusakan, akan dikenakan denda sesuai kerusakan yang berlaku secara wajar.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Laporkan segera jika terdapat kerusakan atau kendala teknis pada perlengkapan.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Step 6 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">6</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Pengembalian Perlengkapan</h3>
                            <p class="text-gray-600 mb-3">
                                Setelah masa sewa berakhir, kembalikan perlengkapan ke store Jatilawang Adventure sesuai jadwal yang ditentukan.
                            </p>
                            <ul class="text-gray-600 space-y-2 ml-4">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pelanggan tidak perlu khawatir tentang kebersihan. Tim kami yang akan menangani proses pembersihan sesuai standar kebersihan dan kenyamanan untuk pengguna berikutnya.
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Detail lebih lanjut mengenai prosedur pengembalian tersedia pada halaman panduan.
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Step 7 --}}
                    <div class="flex gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold text-lg">7</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Butuh Bantuan?</h3>
                            <p class="text-gray-600">
                                Jangan ragu untuk menghubungi kami melalui WhatsApp Jatilawang Adventure untuk informasi atau pertanyaan lebih lanjut.
                            </p>
                            <div class="mt-4">
                                <a href="https://wa.me/6282219033938" 
                                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    Hubungi WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection