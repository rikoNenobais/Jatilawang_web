@php
    $title = 'Sering Disewa Bersamaan';
    $subtitle = $source === 'buy'
        ? 'Ditampilkan berdasar riwayat pembelian karena stok sewa sedang kosong.'
        : 'Ditampilkan berdasar riwayat penyewaan pelanggan.';
@endphp

<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-2xl font-semibold text-gray-900">{{ $title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
            </div>
            <span class="inline-flex items-center text-xs font-medium text-emerald-900 bg-emerald-50 border border-emerald-100 rounded-full px-4 py-1">
                {{ $source === 'buy' ? 'Fallback Pembelian' : 'Data Penyewaan' }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($items as $recommended)
                <div class="space-y-2">
                    <x-product-card :item="$recommended" />
                    @if($recommended->recommendation_frequency ?? false)
                        <p class="text-xs text-gray-500 text-center">
                            Muncul {{ $recommended->recommendation_frequency }}x dalam transaksi {{ $source === 'buy' ? 'pembelian' : 'penyewaan' }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
