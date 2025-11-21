<div id="product-reviews" class="mt-10" data-product-key="{{ $item->item_id }}">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg p-6 border">
      <div id="reviews-summary" class="mb-6">
        <div class="flex items-center gap-6">
          <div class="text-center p-6 bg-gray-50 rounded-md">
            <div id="avgRating" class="text-4xl font-bold">-</div>
            <div class="text-sm text-gray-500">of <span id="totalReviews">-</span> reviews</div>
            <div class="mt-2 text-amber-400" id="avgStars"> </div>
          </div>
          <div class="flex-1" id="ratingBars"><!-- bars via JS --></div>
        </div>
      </div>

      <div id="reviewsList" class="space-y-4"> <!-- reviews injected here -->
      </div>

      @auth
      <form id="reviewForm" class="mt-6">
        @csrf
        <div class="mb-2">Rate:</div>
        <div class="flex items-center gap-2 mb-3" id="starInput">
          @for($i=5;$i>=1;$i--)
            <label class="cursor-pointer">
              <input type="radio" name="rating" value="{{ $i }}" class="hidden star-radio" />
              <span class="px-2 py-1 border rounded text-sm">{{ $i }} ★</span>
            </label>
          @endfor
        </div>
        <textarea name="comment" id="comment" rows="3" class="w-full border rounded p-2" placeholder="Leave Comment"></textarea>
        <div class="mt-3 text-right">
          <button type="submit" class="px-4 py-2 bg-emerald-900 text-white rounded">Kirim Review</button>
        </div>
      </form>
      @else
        <div class="mt-6 text-sm text-gray-600">Silakan <a href="{{ route('login') }}" class="text-emerald-800">login</a> untuk mengirim review.</div>
      @endauth

    </div>
  </div>
</div>

<script>
(function(){
  const root = document.getElementById('product-reviews');
  if(!root) return;
  const productKey = encodeURIComponent(root.dataset.productKey);
  const reviewsUrl = `/products/${productKey}/reviews`;

  function el(tag, attrs = {}, children = []){
    const e = document.createElement(tag);
    Object.keys(attrs).forEach(k=> e.setAttribute(k, attrs[k]));
    (Array.isArray(children) ? children : [children]).forEach(c=>{
      if(typeof c === 'string') e.appendChild(document.createTextNode(c)); else if(c) e.appendChild(c);
    });
    return e;
  }

  function renderBars(stats){
    const container = document.getElementById('ratingBars');
    container.innerHTML = '';
    const total = stats.total || 0;
    for(let star=5; star>=1; star--){
      const count = stats.counts[star] || 0;
      const pct = total ? Math.round((count/total)*100) : 0;
      const row = el('div', {class:'flex items-center gap-3 mb-2'});
      row.appendChild(el('div', {class:'w-24 text-sm text-gray-700'}, [`${['','Kurang Baik','Biasa','Lumayan','Baik','Luar Biasa'][star] || star}`]));
      const barWrap = el('div', {class:'flex-1 bg-gray-200 h-3 rounded overflow-hidden'});
      const bar = el('div', {class:'bg-amber-400 h-3', style:`width:${pct}%`});
      barWrap.appendChild(bar);
      row.appendChild(barWrap);
      row.appendChild(el('div', {class:'w-8 text-sm text-gray-600 text-right'}, [`${count}`]));
      container.appendChild(row);
    }
  }

  function renderReviews(list){
    const container = document.getElementById('reviewsList');
    container.innerHTML = '';
    list.data.forEach(r=>{
      const card = el('div', {class:'p-4 bg-gray-50 rounded-md'});
      const top = el('div', {class:'flex items-center justify-between mb-2'});
      top.appendChild(el('div', {class:'font-semibold'}, [r.user?.name || 'User']));
      top.appendChild(el('div', {class:'text-sm text-gray-500'}, [new Date(r.created_at).toLocaleDateString()]));
      card.appendChild(top);
      const stars = el('div', {class:'text-amber-400 mb-2'}, [ '★'.repeat(r.rating) ]);
      card.appendChild(stars);
      card.appendChild(el('div', {}, [r.comment || '']));
      container.appendChild(card);
    });
  }

  async function refresh(){
    try{
      const res = await fetch(reviewsUrl);
      if(!res.ok) return;
      const json = await res.json();
      const stats = json.stats || {avg:0,total:0,counts:{}};
      document.getElementById('avgRating').textContent = stats.avg.toFixed(1);
      document.getElementById('totalReviews').textContent = stats.total;
      document.getElementById('avgStars').textContent = '★'.repeat(Math.round(stats.avg));
      renderBars({counts: stats.counts, total: stats.total});
      renderReviews(json.reviews);
    }catch(err){
      console.error(err);
    }
  }

  refresh();

  const form = document.getElementById('reviewForm');
  if(form){
    form.addEventListener('submit', async function(e){
      e.preventDefault();
      const fd = new FormData(form);
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      try{
        const res = await fetch(reviewsUrl, {method:'POST', headers:{'X-CSRF-TOKEN': token}, body: fd});
        if(res.ok){
          form.reset();
          await refresh();
          alert('Terima kasih atas review Anda');
        }else{
          const data = await res.json();
          alert(data.message || 'Gagal mengirim review');
        }
      }catch(err){
        console.error(err); alert('Network error');
      }
    });
  }
})();
</script>