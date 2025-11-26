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
                        <textarea name="shipping_address" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 @error('shipping_address') border-red-500 @enderror"
                                  placeholder="Masukkan alamat lengkap pengiriman di area Jogja...">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
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
    const deliveryFeeText = document.getElementById('deliveryFeeText');
    const totalAmountText = document.getElementById('totalAmountText');
    const finalTotal = document.getElementById('finalTotal');
    
    const baseTotal = {{ $totalAmount }};
    const deliveryFee = 18000;

    // Elements untuk rental dates
    const rentalStartDate = document.getElementById('rental_start_date');
    const rentalDays = document.getElementById('rental_days');
    const endDateDisplay = document.getElementById('end_date_display');

    function updateEndDate() {
        if (rentalStartDate && rentalDays) {
            const startDate = new Date(rentalStartDate.value);
            const days = parseInt(rentalDays.value);
            const endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + days);
            
            // Format tanggal ke Indonesia
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
                document.querySelector('textarea[name="shipping_address"]').setAttribute('required', 'required');
            } else {
                shippingAddressSection.classList.add('hidden');
                document.querySelector('textarea[name="shipping_address"]').removeAttribute('required');
            }
            
            updateTotals();
        });
    });

    // Initialize on page load
    updateTotals();
});
</script>
@endsection