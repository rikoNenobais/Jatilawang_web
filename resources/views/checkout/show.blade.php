@extends('layouts.public')

@section('title', 'Checkout - Jatilawang Adventure')

@section('content')
<section class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="text-gray-600 mt-2">Lengkapi data untuk menyelesaikan pesanan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Checkout Form --}}
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                    @csrf

                    {{-- Delivery Option --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Opsi Pengiriman</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition delivery-option">
                                <input type="radio" name="delivery_option" value="pickup" 
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500" checked>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Ambil di Tempat</span>
                                    <p class="text-xs text-gray-500 mt-1">Ambil produk langsung di toko kami</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition delivery-option">
                                <input type="radio" name="delivery_option" value="delivery" 
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Antar ke Alamat</span>
                                    <p class="text-xs text-gray-500 mt-1">Pengiriman menggunakan GoSend - Biaya: Rp 18.000 (Area Jogja)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Shipping Address (muncul hanya jika delivery dipilih) --}}
                    <div id="shippingAddressSection" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 hidden">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Alamat Pengiriman</h3>
                        <textarea name="shipping_address" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600"
                                  placeholder="Masukkan alamat lengkap pengiriman di area Jogja...">{{ old('shipping_address', auth()->user()->address) }}</textarea>
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
                                    class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500" required>
                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Identity Upload (jika ada items sewa) --}}
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
                                           class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500" required>
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- File Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload File Identitas</label>
                            <input type="file" name="identity_file" 
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                   required>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        </div>
                    </div>
                    @endif

                    <button type="submit" 
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 px-6 rounded-lg font-semibold text-lg transition">
                        Bayar Sekarang - Rp <span id="finalTotal">{{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </button>
                </form>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                    
                    {{-- Rental Items --}}
                    @if($rentalItems->count() > 0)
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <h4 class="font-medium text-gray-700 mb-2">Produk Disewa</h4>
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
                        <h4 class="font-medium text-gray-700 mb-2">Produk Dibeli</h4>
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
    const deliveryFee = 18000; // Rp 18.000 untuk semua area Jogja

    function updateTotals() {
        const selectedDelivery = document.querySelector('input[name="delivery_option"]:checked').value;
        const hasDelivery = selectedDelivery === 'delivery';
        const finalDeliveryFee = hasDelivery ? deliveryFee : 0;
        const finalTotalAmount = baseTotal + finalDeliveryFee;

        deliveryFeeText.textContent = `Rp ${finalDeliveryFee.toLocaleString('id-ID')}`;
        totalAmountText.textContent = `Rp ${finalTotalAmount.toLocaleString('id-ID')}`;
        finalTotal.textContent = finalTotalAmount.toLocaleString('id-ID');
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