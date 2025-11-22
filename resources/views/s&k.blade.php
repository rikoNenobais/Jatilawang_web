@extends('layouts.public')

@section('title', 'Syarat & Ketentuan - Jatilawang Adventure')

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
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Syarat & Ketentuan</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Ketentuan penggunaan layanan Jatilawang Adventure
                </p>
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-8">
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-600 mb-8">
                    Dengan mengakses dan menggunakan layanan Jatilawang Adventure, pelanggan dianggap telah membaca, memahami, 
                    dan menyetujui seluruh syarat dan ketentuan yang berlaku.
                </p>

                <div class="space-y-12">
                    {{-- Bagian 1: Umum --}}
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold">1</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Umum</h2>
                        </div>
                        
                        <div class="space-y-6 ml-12">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Persetujuan terhadap Syarat & Ketentuan</h3>
                                <p class="text-gray-600">
                                    Dengan mengakses dan menggunakan layanan Jatilawang Adventure, pelanggan dianggap telah membaca, 
                                    memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Perubahan Ketentuan</h3>
                                <p class="text-gray-600">
                                    Jatilawang Adventure berhak untuk mengubah syarat dan ketentuan ini kapan saja tanpa pemberitahuan sebelumnya.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Batasan Layanan</h3>
                                <p class="text-gray-600">
                                    Layanan kami hanya tersedia untuk Warga Negara Indonesia (WNI) yang berdomisili di wilayah Yogyakarta dan sekitarnya
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Informasi Kontak</h3>
                                <p class="text-gray-600">
                                    Pelanggan diwajibkan memiliki email dan nomor WhatsApp aktif yang dapat dihubungi.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Jenis Pelanggan</h3>
                                <p class="text-gray-600">
                                    Jatilawang Adventure hanya melayani penyewaan untuk individu (perorangan).
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Komitmen dan Tanggung Jawab</h3>
                                <p class="text-gray-600">
                                    Pelanggan bersedia mengganti kerugian akibat kerusakan atau kehilangan alat yang disewa.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Penggunaan Alat</h3>
                                <p class="text-gray-600">
                                    Pelanggan dilarang menggunakan alat untuk kegiatan yang bertentangan dengan hukum yang berlaku.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Alih Tangan</h3>
                                <p class="text-gray-600">
                                    Alat yang disewa tidak boleh dipindahtangankan tanpa persetujuan resmi.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tanggung Jawab Perawatan</h3>
                                <p class="text-gray-600">
                                    Pelanggan bertanggung jawab penuh untuk merawat dan menjaga kondisi alat yang disewa.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pemahaman Penggunaan Alat</h3>
                                <p class="text-gray-600">
                                    Pelanggan hanya diperbolehkan menyewa alat yang sudah dipahami cara penggunaannya.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Kondisi Produk</h3>
                                <p class="text-gray-600">
                                    Kondisi alat yang diterima mungkin berbeda dari foto yang ditampilkan di situs web.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian 2: Keanggotaan --}}
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold">2</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Keanggotaan (Membership)</h2>
                        </div>
                        
                        <div class="space-y-6 ml-12">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pendaftaran Keanggotaan</h3>
                                <p class="text-gray-600">
                                    Calon pelanggan wajib mendaftar melalui platform Jatilawang Adventure untuk mengajukan permohonan keanggotaan.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Proses Seleksi</h3>
                                <p class="text-gray-600">
                                    Jatilawang Adventure akan melakukan seleksi terhadap data yang diunggah oleh calon pelanggan.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hasil Seleksi dan Status Keanggotaan</h3>
                                <p class="text-gray-600">
                                    Jika data tidak memenuhi kualifikasi, Jatilawang Adventure berhak menolak permohonan.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Kebijakan Keanggotaan</h3>
                                <p class="text-gray-600">
                                    Jatilawang Adventure berhak membatalkan keanggotaan pelanggan sewaktu-waktu.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Perlindungan Data</h3>
                                <p class="text-gray-600">
                                    Data pribadi pelanggan tidak akan dibagikan kepada pihak ketiga tanpa izin.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian 3: Pemesanan --}}
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold">3</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Pemesanan (Order)</h2>
                        </div>
                        
                        <div class="space-y-6 ml-12">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Waktu & Perhitungan Sewa</h3>
                                <p class="text-gray-600">
                                    Harga sewa dihitung pada hari berikutnya setelah pengambilan alat. Durasi sewa dihitung sesuai ketentuan yang berlaku.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pembatalan & Perubahan Jadwal</h3>
                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-3">
                                    <h4 class="font-semibold text-amber-800 mb-2">Biaya Pembatalan:</h4>
                                    <ul class="text-amber-700 space-y-1 text-sm">
                                        <li>• Pembatalan dalam 1 jam → 5% dari total biaya sewa</li>
                                        <li>• H-4 atau lebih → 25% dari total biaya sewa</li>
                                        <li>• H-3 hingga H-1 → 50% dari total biaya sewa</li>
                                        <li>• Hari H (sebelum jam 09:00) → 75% dari total biaya sewa</li>
                                        <li>• Hari H (jam 09:00 atau setelahnya) → 100% dari total biaya sewa</li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Perpanjangan Masa Sewa (Extend)</h3>
                                <p class="text-gray-600">
                                    Pelanggan harus mengajukan izin terlebih dahulu untuk memperpanjang masa sewa.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pengembalian Dana (Refund)</h3>
                                <p class="text-gray-600">
                                    Jika dalam 3 hari pelanggan tidak merespons proses refund, maka refund akan dianggap kedaluwarsa.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Promo</h3>
                                <p class="text-gray-600">
                                    Promo yang berlaku dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian 4: Pengambilan Alat --}}
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold">4</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Pengambilan Alat</h2>
                        </div>
                        
                        <div class="space-y-6 ml-12">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pengambilan Mandiri</h3>
                                <p class="text-gray-600">
                                    Pelanggan diwajibkan untuk mengambil alat secara langsung di lokasi yang telah ditentukan.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pengambilan oleh Perwakilan</h3>
                                <p class="text-gray-600">
                                    Jika tidak dapat hadir, pelanggan dapat menunjuk perwakilan dengan syarat tertentu.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Penitipan KTP</h3>
                                <p class="text-gray-600">
                                    Non-Member dan Member Classic wajib menitipkan KTP asli selama masa sewa.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Persetujuan Kondisi Alat</h3>
                                <p class="text-gray-600">
                                    Setelah pengambilan alat ditandatangani, alat dianggap telah diambil dalam kondisi baik.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian 5: Pengembalian Alat --}}
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold">5</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Pengembalian Alat</h2>
                        </div>
                        
                        <div class="space-y-6 ml-12">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Pengembalian Mandiri</h3>
                                <p class="text-gray-600">
                                    Pelanggan diwajibkan mengembalikan alat secara langsung.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Keterlambatan Pengembalian</h3>
                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-3">
                                    <h4 class="font-semibold text-amber-800 mb-2">Biaya Keterlambatan:</h4>
                                    <ul class="text-amber-700 space-y-1 text-sm">
                                        <li>• 00:01 – 12:00 → 10% dari total biaya sewa</li>
                                        <li>• 12:01 – 15:00 → 20% dari total biaya sewa</li>
                                        <li>• 15:01 – 18:00 → 30% dari total biaya sewa</li>
                                        <li>• 18:01 – 21:00 → 50% dari total biaya sewa</li>
                                        <li>• Lebih dari 21:00 → 100% dari total biaya sewa</li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Sanksi untuk Non-Member</h3>
                                <p class="text-gray-600">
                                    Jika alat tidak dikembalikan dalam waktu 2x24 jam, uang jaminan menjadi hak Jatilawang Adventure.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian 6: Kerusakan atau Kehilangan --}}
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold">6</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Kerusakan atau Kehilangan</h2>
                        </div>
                        
                        <div class="space-y-6 ml-12">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Larangan Modifikasi</h3>
                                <p class="text-gray-600">
                                    Pelanggan dilarang melakukan modifikasi atau perbaikan sendiri pada alat yang disewa.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tanggung Jawab atas Kerusakan</h3>
                                <p class="text-gray-600">
                                    Pelanggan yang merusak atau menghilangkan alat akan dikenakan tagihan resolusi.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian 7: Ketentuan Tambahan --}}
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-700 font-bold">7</span>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Ketentuan Tambahan</h2>
                        </div>
                        
                        <div class="space-y-6 ml-12">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Ketentuan Tunggakan</h3>
                                <p class="text-gray-600">
                                    Pelanggan yang tidak membayar biaya keterlambatan dalam waktu 7 hari akan disuspend.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Rekam Jejak Pelanggan</h3>
                                <p class="text-gray-600">
                                    Pelanggan dengan rekam jejak buruk dapat dikenakan sanksi penonaktifan keanggotaan.
                                </p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Etika dan Perlindungan Karyawan</h3>
                                <p class="text-gray-600">
                                    Jatilawang Adventure tidak mentolerir perilaku yang melanggar hukum terhadap karyawan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Note Penting --}}
                <div class="mt-12 p-6 bg-emerald-50 border border-emerald-200 rounded-lg">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-2">Penting!</h3>
                    <p class="text-emerald-800">
                        Dengan menggunakan layanan Jatilawang Adventure, Anda menyetujui semua syarat dan ketentuan di atas. 
                        Disarankan untuk membaca dengan seksama sebelum melakukan pemesanan.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection