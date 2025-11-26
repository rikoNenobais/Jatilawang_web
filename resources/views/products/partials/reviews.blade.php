<div id="product-reviews" class="mt-12" data-product-key="{{ $item->item_id }}">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-0">
    <!-- Header Section -->
    <div class="mb-8">
      <h2 class="text-2xl font-bold text-gray-900 mb-2">Ulasan Produk</h2>
      <p class="text-gray-600">Lihat pengalaman pengguna lain dengan produk ini</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <!-- Rating Summary -->
      <div id="reviews-summary" class="p-4 sm:p-6 border-b border-gray-200">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-6 lg:gap-8">
          <!-- Average Rating - Mobile Center, Desktop Left -->
          <div class="text-center lg:text-left w-full lg:w-auto">
            <div class="flex flex-col sm:flex-row items-center gap-4">
              <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-4 sm:p-6 w-full sm:w-auto">
                <div id="avgRating" class="text-4xl sm:text-5xl font-bold text-gray-900 mb-1">-</div>
                <div class="flex justify-center lg:justify-start gap-1 mb-2" id="avgStars"></div>
                <div class="text-sm text-gray-600">
                  <span id="totalReviews" class="font-semibold">-</span> ulasan
                </div>
              </div>
            </div>
          </div>

          <!-- Rating Distribution -->
          <div class="flex-1 min-w-0 w-full lg:w-auto">
            <h3 class="font-semibold text-gray-900 mb-4 text-center lg:text-left">Distribusi Rating</h3>
            <div id="ratingBars" class="space-y-3 max-w-md mx-auto lg:mx-0">
              <!-- bars via JS -->
            </div>
          </div>
        </div>
      </div>

      <!-- Reviews List -->
      <div id="reviewsList" class="divide-y divide-gray-200">
        <!-- reviews injected here -->
        <div class="p-6 sm:p-8 text-center text-gray-500" id="loadingReviews">
          <div class="animate-pulse">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-200 rounded-full mx-auto mb-4"></div>
            <div class="h-4 bg-gray-200 rounded w-32 sm:w-48 mx-auto mb-2"></div>
            <div class="h-3 bg-gray-200 rounded w-24 sm:w-32 mx-auto"></div>
          </div>
        </div>
      </div>

      <!-- View All Reviews Link -->
      <div id="viewAllReviews" class="hidden p-4 sm:p-6 border-t border-gray-200 text-center">
        <a href="{{ route('products.reviews.page', $item->item_name) }}" 
           class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors text-sm sm:text-base">
          <span>Lihat Semua Ulasan</span>
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </a>
      </div>

      <!-- Info untuk user yang belum login -->
      @auth
        <div class="p-4 sm:p-6 bg-blue-50 border-t border-blue-200">
          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm text-blue-700">
              <span class="font-semibold">Hanya untuk pembeli terverifikasi:</span> 
              <span class="block sm:inline">Anda dapat memberikan review setelah menyelesaikan transaksi produk ini.</span>
            </div>
          </div>
        </div>
      @else
        <div class="p-4 sm:p-6 bg-gray-50 border-t border-gray-200 text-center">
          <p class="text-sm text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Login</a> 
            untuk melihat apakah Anda dapat memberikan review
          </p>
        </div>
      @endauth
    </div>
  </div>
</div>

<!-- Di bagian BOTTOM file blade, sebelum </body> -->
<script>
console.log('=== REVIEW SCRIPT STARTING ===');

// Tunggu sampai SEMUA HTML selesai load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded, starting reviews...');
    
    // Update debug info
    const debugApiUrl = document.getElementById('debug-api-url');
    const debugStatus = document.getElementById('debug-status');
    
    if (debugApiUrl && debugStatus) {
        debugApiUrl.textContent = `/products/{{ $item->item_id }}/reviews`;
        debugStatus.textContent = 'Status: JavaScript loaded, fetching data...';
    }

    // Simple function to create elements
    function createElement(tag, className, html) {
        const el = document.createElement(tag);
        el.className = className;
        el.innerHTML = html;
        return el;
    }

    // Load reviews function
    function loadReviews() {
        const productId = {{ $item->item_id }};
        const url = `/products/${productId}/reviews`;
        
        console.log('Fetching from:', url);
        
        fetch(url)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                
                // Update debug status
                if (debugStatus) {
                    debugStatus.textContent = `Status: Data loaded successfully (${data.stats.total} reviews)`;
                }
                
                // Update rating summary
                document.getElementById('avgRating').textContent = data.stats.avg.toFixed(1);
                document.getElementById('totalReviews').textContent = data.stats.total;
                
                // Update stars
                const avgStars = Math.round(data.stats.avg);
                const starsContainer = document.getElementById('avgStars');
                starsContainer.innerHTML = '';
                for (let i = 1; i <= 5; i++) {
                    const star = createElement('span', `text-xl sm:text-2xl ${i <= avgStars ? 'text-amber-400' : 'text-gray-300'}`, '★');
                    starsContainer.appendChild(star);
                }
                
                // Update rating bars - responsive
                const barsContainer = document.getElementById('ratingBars');
                barsContainer.innerHTML = '';
                for (let star = 5; star >= 1; star--) {
                    const count = data.stats.counts[star] || 0;
                    const percentage = data.stats.total ? Math.round((count / data.stats.total) * 100) : 0;
                    
                    const barRow = createElement('div', 'flex items-center gap-2 sm:gap-4', '');
                    
                    // Star label - mobile compact
                    barRow.appendChild(createElement('div', 'flex items-center gap-1 sm:gap-2 w-12 sm:w-20', 
                        `<span class="text-xs sm:text-sm font-medium text-gray-900">${star}</span>
                         <span class="text-amber-400 text-sm sm:text-base">★</span>`));
                    
                    // Progress bar
                    const progressBar = createElement('div', 'flex-1 bg-gray-200 rounded-full h-2 overflow-hidden',
                        `<div class="bg-amber-400 h-2 rounded-full transition-all duration-500" style="width: ${percentage}%"></div>`);
                    barRow.appendChild(progressBar);
                    
                    // Count - mobile compact
                    barRow.appendChild(createElement('div', 'w-10 sm:w-16 text-right',
                        `<span class="text-xs sm:text-sm font-medium text-gray-900">${count}</span>
                         <span class="text-xs text-gray-500 hidden sm:inline ml-1">(${percentage}%)</span>`));
                    
                    barsContainer.appendChild(barRow);
                }
                
                // Update reviews list
                const reviewsContainer = document.getElementById('reviewsList');
                const loadingElement = document.getElementById('loadingReviews');
                
                if (loadingElement) {
                    loadingElement.remove();
                }
                
                if (data.reviews.data.length === 0) {
                    reviewsContainer.innerHTML = `
                        <div class="p-6 sm:p-12 text-center">
                            <div class="w-16 h-16 sm:w-24 sm:h-24 mx-auto mb-4 text-gray-300">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada ulasan</h3>
                            <p class="text-gray-500 text-sm sm:text-base">Jadilah yang pertama memberikan ulasan untuk produk ini</p>
                        </div>
                    `;
                } else {
                    reviewsContainer.innerHTML = '';
                    const previewReviews = data.reviews.data.slice(0, 3);
                    
                    previewReviews.forEach(review => {
                        const reviewCard = createElement('div', 'p-4 sm:p-6 hover:bg-gray-50 transition-colors', '');
                        
                        const userInitial = (review.user?.name || 'U').charAt(0).toUpperCase();
                        const userName = review.user?.name || 'Pengguna';
                        const reviewDate = new Date(review.created_at).toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
                        const comment = review.comment || 'Tidak ada komentar tambahan';
                        
                        reviewCard.innerHTML = `
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm sm:text-base">
                                        ${userInitial}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 text-sm sm:text-base">${userName}</div>
                                        <div class="text-xs sm:text-sm text-gray-500">${reviewDate}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-amber-400 text-base sm:text-lg mb-3">${stars}</div>
                            <div class="text-gray-700 leading-relaxed text-sm sm:text-base">${comment}</div>
                        `;
                        
                        reviewsContainer.appendChild(reviewCard);
                    });
                    
                    // Show "View All" link if there are more than 3 reviews
                    if (data.reviews.data.length > 3) {
                        document.getElementById('viewAllReviews').classList.remove('hidden');
                    }
                }
                
                console.log('=== REVIEWS LOADED SUCCESSFULLY ===');
            })
            .catch(error => {
                console.error('Error loading reviews:', error);
                if (debugStatus) {
                    debugStatus.textContent = 'Status: Error - ' + error.message;
                }
                
                const reviewsContainer = document.getElementById('reviewsList');
                const loadingElement = document.getElementById('loadingReviews');
                
                if (loadingElement) {
                    loadingElement.remove();
                }
                
                reviewsContainer.innerHTML = `
                    <div class="p-6 sm:p-8 text-center text-red-600 text-sm sm:text-base">
                        Gagal memuat ulasan. Silakan refresh halaman.
                    </div>
                `;
            });
    }

    // Start loading reviews
    loadReviews();
});

console.log('=== REVIEW SCRIPT INITIALIZED (waiting for DOM) ===');
</script>