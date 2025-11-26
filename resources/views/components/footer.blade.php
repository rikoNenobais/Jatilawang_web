<footer class="bg-emerald-950 text-gray-200 py-6">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- LOGO + Teks di BAWAH logo -->
            <div class="lg:col-span-3 text-center lg:text-left">
                <div class="mb-6">
                    <img src="{{ asset('storage/logo/logo-jatilawang.png') }}"
                         alt="Jatilawang Adventure"
                         class="w-24 h-24 mx-auto lg:mx-0 object-contain bg-white p-3 rounded">
                </div>

                <div>
                    <h1 class="text-4xl font-black text-white tracking-wider">
                        JATILAWANG<sup class="text-sm align-super">®</sup>
                    </h1>
                    <p class="text-xl font-bold text-white -mt-1">Adventure</p>
                </div>
            </div>

            <!-- INFORMASI -->
            <div class="lg:col-span-2">
                <h3 class="text-white font-bold text-lg mb-6">Informasi</h3>
                <ul class="space-y-4 text-gray-400 text-sm">
                    <li><a href="{{ route('cara-sewa') }}" class="hover:text-white transition">Cara sewa</a></li>
                    <li><a href="{{ route('cara-pengembalian') }}" class="hover:text-white transition">Cara pengembalian</a></li>
                    <li><a href="{{ route('syarat-ketentuan') }}" class="hover:text-white transition">Syarat dan Ketentuan</a></li>
                </ul>
            </div>

            <!-- TENTANG JATILAWANG -->
            <div class="lg:col-span-3">
                <h3 class="text-white font-bold text-lg mb-6">Tentang Jatilawang</h3>
                <ul class="space-y-4 text-gray-400 text-sm">
                    <li><a href="{{ route('tentang-kami') }}" class="hover:text-white transition">Tentang Kami</a></li>
                </ul>
            </div>

            <!-- LAYANAN BANTUAN + KONTAK -->
            <div class="lg:col-span-4">
                <h3 class="text-white font-bold text-lg mb-6">Layanan Bantuan</h3>
                <ul class="space-y-6 text-sm">

                    <li><a href="{{route('kontak')  }}" class="text-gray-400 hover:text-white transition">Kontak Kami</a></li>

                    <!-- Alamat -->
                    <li class="flex gap-4 items-start">
                        <svg class="w-5 h-5 text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div class="text-gray-400 leading-tight">
                            Jl. Timbulrejo, Krodan, Maguwoharjo,<br>
                            Kec. Depok, Kabupaten Sleman,<br>
                            Daerah Istimewa Yogyakarta 55282
                        </div>
                    </li>

                    <!-- Jam -->
                    <li class="flex gap-4 items-center">
                        <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-400">Setiap hari, 09:00 - 20:00 WIB</span>
                    </li>

                    <!-- Email -->
                    <li class="flex gap-4 items-center">
                        <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:jatilawang@gmail.com" class="text-gray-400 hover:text-white transition">
                            jatilawang@gmail.com
                        </a>
                    </li>

                    <!-- WhatsApp -->
                    <li class="flex items-center gap-4 pt-6">
                        <svg class="w-9 h-9 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.198-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.297-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.626.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.265c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C6.06 0 1.146 4.914.996 10.925c-.009.058-.007.119.008.176l1.4 4.204a1 1 0 00.95.69h.002l4.204 1.4a1 1 0 00.335.058c.188.018.377.027.57.027 6.105 0 11.05-4.945 11.05-11.05 0-2.935-1.147-5.706-3.23-7.783"/>
                        </svg>
                        <div>
                            <p class="text-green-500 font-bold text-2xl leading-none"> 0857-4234-1424</p>
                            <p class="text-gray-400 text-sm">WhatsApp Kami</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- COPYRIGHT + SOSMED -->
        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col lg:flex-row justify-between items-center text-sm text-gray-500">
            <p>© {{ date('Y') }} Jatilawang Adventure. All rights reserved.</p>
            <div class="flex gap-8 mt-4 lg:mt-0">
                <a href="#" class="hover:text-white transition">Facebook</a>
                <a href="#" class="hover:text-white transition">Instagram</a>
                <a href="#" class="hover:text-white transition">Twitter</a>
            </div>
        </div>
    </div>
</footer>