@extends('layouts.public')

@section('title', 'Kontak Kami - Jatilawang Adventure')

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
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Kontak Kami</h1>
                <p class="text-xl text-emerald-200 max-w-3xl mx-auto">
                    Hubungi kami untuk informasi dan bantuan
                </p>
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-8">
            <div class="grid lg:grid-cols-2 gap-12">
                {{-- ===================== FORM KONTAK ===================== --}}
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan via WhatsApp</h2>
                    
                    {{-- Simple Form langsung buka WhatsApp --}}
                    <form id="whatsappForm" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Depan</label>
                                <input type="text" id="first_name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Nama depan">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Belakang</label>
                                <input type="text" id="last_name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                       placeholder="Nama belakang">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="email@anda.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp Anda</label>
                            <input type="tel" id="user_whatsapp"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                   placeholder="087812345678">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                            <textarea id="message" rows="6" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                      placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>

                        <button type="button" onclick="sendToWhatsApp()"
                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Kirim via WhatsApp
                        </button>
                    </form>

                    <script>
                    function sendToWhatsApp() {
                        const firstName = document.getElementById('first_name').value;
                        const lastName = document.getElementById('last_name').value;
                        const email = document.getElementById('email').value;
                        const userWhatsapp = document.getElementById('user_whatsapp').value;
                        const message = document.getElementById('message').value;
                        
                        const fullName = `${firstName} ${lastName}`;
                        const phoneNumber = '6287812000155'; // Nomor WhatsApp Jatilawang Adventure
                        
                        // Template pesan otomatis
                        const text = `Halo Jatilawang Adventure!%0A%0A` +
                                     `Saya ${fullName} ingin bertanya:%0A%0A` +
                                     `${message}%0A%0A` +
                                     `*Data Kontak:*%0A` +
                                     `📧 Email: ${email}%0A` +
                                     `📱 WhatsApp: ${userWhatsapp || 'Tidak diisi'}%0A%0A` +
                                     `Terima kasih!`;
                        
                        const url = `https://wa.me/${phoneNumber}?text=${text}`;
                        window.open(url, '_blank');
                    }
                    </script>
                </div>

                {{-- ===================== INFORMASI KONTAK ===================== --}}
                <div class="space-y-8">
                    {{-- Info Kontak --}}
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Lokasi Kami</h2>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-emerald-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-gray-700 font-medium">Jatilawang Adventure</p>
                                    <p class="text-gray-600">JJl. Timbulrejo, Krodan, Maguwoharjo,<br>
                                                                Kec. Depok, Kabupaten Sleman,<br>
                                                                Daerah Istimewa Yogyakarta 55282
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-emerald-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-gray-700 font-medium">Jam Operasional</p>
                                    <p class="text-gray-600">Setiap hari, 09:00 - 20:00 WIB</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-emerald-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-gray-700 font-medium">Email</p>
                                    <p class="text-gray-600">jatilawangadventure@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- WhatsApp Direct --}}
                    <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-100">
                        <h3 class="text-lg font-semibold text-emerald-900 mb-3">WhatsApp Kami</h3>
                        <a href="https://wa.me/6287812000155" 
                           target="_blank"
                           class="inline-flex items-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            0878 1200 0155
                        </a>
                        <p class="text-sm text-emerald-700 mt-2">Klik untuk chat langsung via WhatsApp</p>
                    </div>

                  {{-- Google Maps Embed untuk Jatilawang Adventure Jogja --}}
                <div class="bg-gray-100 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Lokasi di Google Maps</h3>
                    <div class="aspect-video bg-gray-200 rounded-lg overflow-hidden">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.286112647737!2d110.42109087416506!3d-7.759450492259628!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5981ee4f76d1%3A0x4a47f6a05a068fd!2sPersewaan%20alat%20camping%20jogja%20terdekat%20(Jatilawang%20Adventure)!5e0!3m2!1sid!2sid!4v1763807127374!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Jatilawang Adventure Jogja">
                        </iframe>
                    </div>
                    <a href="https://maps.app.goo.gl/YMPtGVzuk8XShJ129" 
                    target="_blank"
                    class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 mt-3 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>
                </div>
                </div>
            </div>
        </div>
    </section>
@endsection