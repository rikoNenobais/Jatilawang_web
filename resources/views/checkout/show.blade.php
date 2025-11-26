@extends('layouts.public')

@section('title', 'Checkout - Jatilawang Adventure')

@section('content')
{{-- BACKGROUND FOTO UNTUK SELURUH HALAMAN --}}
<div class="fixed inset-0 -z-10">
    <img src="{{ asset('storage/hero/peaks.jpg') }}" 
        alt="Pegunungan Jatilawang Adventure" 
        class="w-full h-full object-cover">
    {{-- Overlay Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/80 via-emerald-800/70 to-teal-700/80"></div>
</div>

{{-- Efek Blur --}}
<div class="pointer-events-none absolute -top-40 -left-40 h-[700px] w-[700px] rounded-full bg-emerald-900/20 blur-3xl -z-10"></div>

{{-- ===================== CHECKOUT SECTION ===================== --}}
<section class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Checkout</h1>
            <p class="text-white mt-2">Lengkapi data untuk menyelesaikan pesanan</p>
        </div>

        {{-- Error Display --}}
        @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <strong class="font-bold">Terjadi kesalahan:</strong>
            <ul class="mt-1 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Checkout Form --}}
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="shipping_lat" id="shipping_lat" value="{{ old('shipping_lat') }}">
                    <input type="hidden" name="shipping_lng" id="shipping_lng" value="{{ old('shipping_lng') }}">

                    {{-- Rental Dates Section --}}
                    @if($hasRentalItems)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tanggal Sewa</h3>
                        
                        {{-- Start Date --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai Sewa</label>
                            <input type="date" 
                                   name="rental_start_date" 
                                   id="rental_start_date"
                                   value="{{ old('rental_start_date', $defaultRentalDates['start_date']) }}"
                                   min="{{ now()->format('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 @error('rental_start_date') border-red-500 @enderror"
                                   required>
                            @error('rental_start_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Pilih tanggal mulai penyewaan</p>
                        </div>

                        {{-- Rental Days --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lama Sewa (Hari)</label>
                            <select name="rental_days" 
                                    id="rental_days"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 @error('rental_days') border-red-500 @enderror"
                                    required>
                                @for($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}" {{ old('rental_days', $defaultRentalDates['days']) == $i ? 'selected' : '' }}>
                                        {{ $i }} Hari
                                    </option>
                                @endfor
                            </select>
                            @error('rental_days')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- End Date Display --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai Sewa</label>
                            <p class="text-lg font-semibold text-emerald-600" id="end_date_display">
                                {{ \Carbon\Carbon::parse($defaultRentalDates['end_date'])->format('d F Y') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Tanggal pengembalian barang</p>
                        </div>
                    </div>
                    @endif

                    {{-- Delivery Option --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Opsi Pengiriman</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition delivery-option">
                                <input type="radio" name="delivery_option" value="pickup" 
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500" 
                                    {{ old('delivery_option', 'pickup') == 'pickup' ? 'checked' : '' }}>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Ambil di Tempat</span>
                                    <p class="text-xs text-gray-500 mt-1">Ambil produk langsung di toko kami</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition delivery-option">
                                <input type="radio" name="delivery_option" value="delivery" 
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500"
                                    {{ old('delivery_option') == 'delivery' ? 'checked' : '' }}>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Antar ke Alamat</span>
                                    <p class="text-xs text-gray-500 mt-1">Pengiriman menggunakan GoSend - Biaya: Rp 18.000 (Area Jogja)</p>
                                </div>
                            </label>
                        </div>
                        @error('delivery_option')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Shipping Address --}}
                    <div id="shippingAddressSection" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 {{ old('delivery_option') == 'delivery' ? '' : 'hidden' }}">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Alamat Pengiriman</h3>
                        <div class="space-y-3">
                            <textarea id="shippingAddressField" name="shipping_address" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 @error('shipping_address') border-red-500 @enderror"
                                      placeholder="Masukkan alamat lengkap pengiriman di area Jogja...">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <button type="button" id="detectLocationButton"
                                        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Gunakan Lokasi Saya
                                </button>
                                <p id="locationStatus" class="text-xs text-slate-500">
                                    Izinkan browser mengakses lokasi agar alamat terisi otomatis.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h3>
                        <div class="space-y-3">
                            @foreach([
                                'qris' => 'QRIS', 
                                'transfer' => 'Transfer Bank', 
                                'cash' => 'Cash (Bayar di Tempat)'
                            ] as $value => $label)
                            <label class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                <input type="radio" name="payment_method" value="{{ $value }}" 
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500" 
                                    {{ old('payment_method') == $value ? 'checked' : '' }}
                                    required>
                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Identity Upload --}}
                    @if($hasRentalItems)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Verifikasi Identitas (Sewa)</h3>
                        
                        {{-- Identity Type --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Identitas</label>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach(['ktp' => 'KTP', 'ktm' => 'KTM', 'sim' => 'SIM'] as $value => $label)
                                <label class="flex items-center gap-2 p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="identity_type" value="{{ $value }}" 
                                           class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500" 
                                           {{ old('identity_type') == $value ? 'checked' : '' }}
                                           required>
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('identity_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- File Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload File Identitas</label>
                            <input type="file" name="identity_file" 
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 @error('identity_file') border-red-500 @enderror"
                                   required>
                            @error('identity_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        </div>
                    </div>
                    @endif

                    <button type="submit" 
                            class="w-full bg-amber-500 hover:bg-amber-600 text-white py-4 px-6 rounded-lg font-semibold text-lg transition">
                        Bayar Sekarang - Rp <span id="finalTotal">{{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </button>
                </form>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                    
                    {{-- Rental Items --}}
                    @if($rentalItems->count() > 0)
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-2 mb-2"> 
                            <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                            <h4 class="font-medium text-gray-700">Produk Disewa</h4>
                        </div>
                        @foreach($rentalItems as $item)
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>{{ $item->item->item_name }} ({{ $item->days }} hari)</span>
                            <span>Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Purchase Items --}}
                    @if($purchaseItems->count() > 0)
                    <div class="mb-4 pb-4 border-b border-gray-200">
                         <div class="flex items-center gap-2 mb-2"> 
                            <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                            <h4 class="font-medium text-gray-700">Produk Dibeli</h4>
                        </div>
                        @foreach($purchaseItems as $item)
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>{{ $item->item->item_name }}</span>
                            <span>Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Delivery Fee --}}
                    <div class="mb-2 border-b border-gray-200 pb-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Biaya Pengiriman</span>
                            <span id="deliveryFeeText">Rp 0</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between text-lg font-semibold text-gray-900">
                            <span>Total</span>
                            <span id="totalAmountText">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryOptions = document.querySelectorAll('input[name="delivery_option"]');
    const shippingAddressSection = document.getElementById('shippingAddressSection');
    const shippingAddressField = document.getElementById('shippingAddressField');
    const deliveryFeeText = document.getElementById('deliveryFeeText');
    const totalAmountText = document.getElementById('totalAmountText');
    const finalTotal = document.getElementById('finalTotal');
    const detectLocationButton = document.getElementById('detectLocationButton');
    const locationStatus = document.getElementById('locationStatus');
    const shippingLatInput = document.getElementById('shipping_lat');
    const shippingLngInput = document.getElementById('shipping_lng');

    const baseTotal = Number('{{ $totalAmount }}');
    const deliveryFee = 18000; // Rp 18.000 untuk semua area Jogja

    // Elements untuk rental dates
    const rentalStartDate = document.getElementById('rental_start_date');
    const rentalDays = document.getElementById('rental_days');
    const endDateDisplay = document.getElementById('end_date_display');

    function updateEndDate() {
        if (rentalStartDate && rentalDays && endDateDisplay) {
            const startDate = new Date(rentalStartDate.value);
            const days = parseInt(rentalDays.value, 10);
            const endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + (isNaN(days) ? 0 : days));
            
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            endDateDisplay.textContent = endDate.toLocaleDateString('id-ID', options);
        }
    }

    function updateTotals() {
        const selectedDelivery = document.querySelector('input[name="delivery_option"]:checked');
        const hasDelivery = selectedDelivery ? selectedDelivery.value === 'delivery' : false;
        const finalDeliveryFee = hasDelivery ? deliveryFee : 0;
        const finalTotalAmount = baseTotal + finalDeliveryFee;

        deliveryFeeText.textContent = `Rp ${finalDeliveryFee.toLocaleString('id-ID')}`;
        totalAmountText.textContent = `Rp ${finalTotalAmount.toLocaleString('id-ID')}`;
        finalTotal.textContent = finalTotalAmount.toLocaleString('id-ID');
    }

    // Event listeners untuk rental dates
    if (rentalStartDate && rentalDays) {
        rentalStartDate.addEventListener('change', updateEndDate);
        rentalDays.addEventListener('change', updateEndDate);
        
        // Initialize end date
        updateEndDate();
    }

    deliveryOptions.forEach(option => {
        option.addEventListener('change', function() {
            const showAddress = this.value === 'delivery';
            
            if (showAddress) {
                shippingAddressSection.classList.remove('hidden');
                shippingAddressField.setAttribute('required', 'required');
                setLocationStatus('Izinkan akses lokasi atau isi alamat secara manual.', 'info');
            } else {
                shippingAddressSection.classList.add('hidden');
                shippingAddressField.removeAttribute('required');
                shippingLatInput.value = '';
                shippingLngInput.value = '';
                setLocationStatus('Opsi antar nonaktif, koordinat dibersihkan.', 'info');
            }
            
            updateTotals();
        });
    });

    // Initialize on page load
    updateTotals();

    if (detectLocationButton) {
        detectLocationButton.addEventListener('click', async function () {
            if (! navigator.geolocation) {
                setLocationStatus('Browser tidak mendukung geolokasi. Isi alamat secara manual.', 'warn');
                return;
            }

            setLocationStatus('Meminta izin lokasi...', 'info');
            detectLocationButton.disabled = true;

            navigator.geolocation.getCurrentPosition(async (position) => {
                const { latitude, longitude } = position.coords;
                shippingLatInput.value = latitude.toFixed(7);
                shippingLngInput.value = longitude.toFixed(7);
                setLocationStatus('Lokasi ditemukan, mengisi alamat...', 'info');

                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json&zoom=18&addressdetails=0`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Reverse geocoding gagal');
                    }

                    const data = await response.json();
                    if (data?.display_name && (!shippingAddressField.value || shippingAddressField.value.length < 10)) {
                        shippingAddressField.value = data.display_name;
                    }
                    setLocationStatus('Koordinat tersimpan. Pastikan alamat sudah sesuai.', 'success');
                } catch (error) {
                    console.error(error);
                    setLocationStatus('Koordinat tersimpan. Silakan isi alamat manual jika belum lengkap.', 'warn');
                } finally {
                    detectLocationButton.disabled = false;
                }
            }, (error) => {
                console.error(error);
                detectLocationButton.disabled = false;
                if (error.code === error.PERMISSION_DENIED) {
                    setLocationStatus('Izin lokasi ditolak. Isi alamat secara manual.', 'warn');
                } else {
                    setLocationStatus('Gagal mendapatkan lokasi. Coba lagi atau isi alamat manual.', 'warn');
                }
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            });
        });
    }

    function setLocationStatus(message, variant) {
        if (!locationStatus) return;
        const palette = {
            success: 'text-emerald-600',
            warn: 'text-amber-600',
            info: 'text-slate-500'
        };

        locationStatus.textContent = message;
        locationStatus.className = `text-xs ${palette[variant] || palette.info}`;
    }
});
</script>
@endsection