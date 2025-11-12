@if(!empty($relatedProducts) && count($relatedProducts) > 0)
<section class="bg-white py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">Produk Terkait</h3>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach($relatedProducts as $rp)
        <a href="{{ route('products.show', $rp['slug'] ?? '') }}" class="block border rounded-lg overflow-hidden hover:shadow-md bg-white">
          <div class="w-full h-40 bg-gray-50 flex items-center justify-center">
            <img src="{{ $rp['img_url'] ?? asset('storage/foto-produk/' . ($rp['img'] ?? '')) }}" alt="{{ $rp['name'] }}" class="max-h-full object-contain">
          </div>
          <div class="p-3">
            <h4 class="text-sm font-medium text-gray-800 truncate">{{ $rp['name'] }}</h4>
            <p class="text-sm text-emerald-900 mt-1">{{ $rp['price'] ?? '' }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif
