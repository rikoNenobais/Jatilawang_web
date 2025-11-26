@php
    $items = $similarProducts ?? collect();
@endphp

@if($items->isNotEmpty())
<section class="bg-white py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h3 class="text-xl font-semibold text-gray-900">Produk Serupa</h3>
            <p class="text-sm text-gray-500 mt-1">Dipilih berdasarkan kategori dan karakteristik harga yang mirip.</p>
        </div>
        <span class="text-xs text-gray-500">{{ $items->count() }} rekomendasi</span>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      @foreach($items as $rp)
        <x-product-card :item="$rp" />
      @endforeach
    </div>
  </div>
</section>
@endif
