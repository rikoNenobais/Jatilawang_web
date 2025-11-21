<section class="bg-white py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">Produk Terkait</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach($relatedProducts as $rp)
        <x-product-card :item="$rp" />
      @endforeach
    </div>
  </div>
</section>
