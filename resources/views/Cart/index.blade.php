@extends('layouts.public')

@section('content')
<section class="container cart-page">
  <a href="{{ url()->previous() }}" class="back-link">← Keranjang Belanja</a>

  <div class="cart-grid">
    {{-- === LIST ITEM === --}}
    <div class="cart-items" id="cart-items"></div>

    {{-- === SUMMARY === --}}
    <aside class="cart-summary">
      <h3>Detail Pesanan</h3>
      <div class="summary-row">
        <span>Subtotal</span>
        <span id="subtotal">Rp 0</span>
      </div>
      <div class="summary-row">
        <span>Pengiriman (estimasi)</span>
        <span id="shipping">Rp 0</span>
      </div>
      <div class="summary-row total">
        <span>Total</span>
        <span id="total">Rp 0</span>
      </div>
      <button id="checkout-btn" class="btn-checkout">Checkout</button>
      <p class="hint">* Ini demo frontend. Pembayaran akan diaktifkan saat backend siap.</p>
    </aside>
  </div>
</section>

<style>
  .container{max-width:1100px;margin:0 auto;padding:24px}
  .back-link{display:inline-block;margin-bottom:16px;color:#111;font-weight:700;text-decoration:none}
  .cart-grid{display:grid;grid-template-columns:1fr 360px;gap:28px}
  .cart-items{background:#fff;border:1px solid #eee;border-radius:14px;padding:10px}
  .cart-item{display:grid;grid-template-columns:96px 1fr auto;gap:14px;align-items:center;padding:16px;border-bottom:1px solid #f1f5f9}
  .cart-item:last-child{border-bottom:none}
  .ci-img{width:96px;height:96px;border-radius:12px;object-fit:cover;background:#f3f4f6}
  .ci-title{font-weight:700;margin-bottom:4px}
  .ci-sku{font-size:12px;color:#6b7280}
  .qty{display:inline-flex;align-items:center;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden}
  .qty button{width:34px;height:34px;border:0;background:#fff;cursor:pointer}
  .qty input{width:46px;text-align:center;border:0;outline:0}
  .ci-price{font-weight:700;margin-left:12px;min-width:120px;text-align:right}
  .ci-remove{margin-left:12px;background:none;border:0;color:#9ca3af;cursor:pointer}
  .cart-summary{background:#fff;border:1px solid #eee;border-radius:14px;padding:20px;height:fit-content}
  .cart-summary h3{margin:0 0 12px}
  .summary-row{display:flex;justify-content:space-between;padding:8px 0}
  .summary-row.total{border-top:1px solid #f1f5f9;margin-top:8px;font-weight:800;padding-top:12px}
  .btn-checkout{width:100%;margin-top:16px;padding:12px 14px;border-radius:10px;border:0;background:#0b3b32;color:#fff;font-weight:700;cursor:pointer}
  .hint{font-size:12px;color:#6b7280;margin-top:8px}
  .empty{padding:32px;text-align:center;color:#6b7280}
  @media (max-width: 960px){ .cart-grid{grid-template-columns:1fr} }
</style>

<script>
  /** ---------- CART STORAGE (frontend only) ---------- **/
  const CKEY = "keujak_cart"; // localStorage key

  function idr(n){ return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(n||0); }

  function normalizeNumber(value){
    const num = typeof value === 'string' ? value.replace(/[^0-9.-]/g,'') : value;
    return Number(num) || 0;
  }

  function normalizeCartShape(raw){
    if (Array.isArray(raw)){
      return raw.map(item => ({
        id: item.id,
        name: item.name || '',
        qty: Math.max(1, Number(item.qty ?? item.quantity) || 1),
        price: normalizeNumber(item.price),
        image: item.image || '',
        sku: item.sku || ''
      }));
    }
    if (raw && typeof raw === 'object'){
      return Object.entries(raw).map(([id,item]) => ({
        id,
        name: item.name || '',
        qty: Math.max(1, Number(item.qty ?? item.quantity) || 1),
        price: normalizeNumber(item.price),
        image: item.image || '',
        sku: item.sku || ''
      }));
    }
    return [];
  }

  function getCart(){
    try{
      const parsed = JSON.parse(localStorage.getItem(CKEY));
      const normalized = normalizeCartShape(parsed || []);
      if(parsed && !Array.isArray(parsed)) saveCart(normalized);
      return normalized;
    }catch{ return []; }
  }
  function saveCart(items){ localStorage.setItem(CKEY, JSON.stringify(items)); }
  function updateBadge(){
    const count = getCart().reduce((a,b)=>a + b.qty, 0);
    document.querySelectorAll('[data-cart-badge]').forEach(el => {
      el.textContent = count;
    });
  }

  /** ---------- UI RENDER ---------- **/
  const elItems   = document.getElementById('cart-items');
  const elSubtotal= document.getElementById('subtotal');
  const elShipping= document.getElementById('shipping');
  const elTotal   = document.getElementById('total');

  // simple shipping rule (demo): Rp 20.000 jika subtotal > 0
  function shippingFee(subtotal){ return subtotal > 0 ? 20000 : 0; }

  function render(){
    const cart = getCart();
    if(cart.length === 0){
      elItems.innerHTML = `<div class="empty">Keranjang masih kosong.</div>`;
      elSubtotal.textContent = idr(0);
      elShipping.textContent = idr(0);
      elTotal.textContent    = idr(0);
      updateBadge();
      return;
    }

    elItems.innerHTML = cart.map(item => `
      <div class="cart-item" data-id="${item.id}">
        <img src="${item.image || 'https://via.placeholder.com/96'}" alt="${item.name}" class="ci-img">
        <div>
          <div class="ci-title">${item.name}</div>
          <div class="ci-sku">#${item.sku || '-'}</div>
        </div>
        <div style="display:flex;align-items:center;">
          <div class="qty">
            <button class="btn-dec" aria-label="Kurangi">−</button>
            <input class="inp-qty" type="text" value="${item.qty}" inputmode="numeric" />
            <button class="btn-inc" aria-label="Tambah">+</button>
          </div>
          <div class="ci-price">${idr(normalizeNumber(item.price) * item.qty)}</div>
          <button class="ci-remove" title="Hapus">×</button>
        </div>
      </div>
    `).join('');

    // events
    elItems.querySelectorAll('.cart-item').forEach(row => {
      const id = row.dataset.id;
      row.querySelector('.btn-inc').addEventListener('click', () => changeQty(id, +1));
      row.querySelector('.btn-dec').addEventListener('click', () => changeQty(id, -1));
      row.querySelector('.inp-qty').addEventListener('change', (e) => setQty(id, parseInt(e.target.value || 1)));
      row.querySelector('.ci-remove').addEventListener('click', () => removeItem(id));
    });

    // totals
    const subtotal = cart.reduce((s,i)=> s + (normalizeNumber(i.price) * i.qty), 0);
    const ship     = shippingFee(subtotal);
    elSubtotal.textContent = idr(subtotal);
    elShipping.textContent = idr(ship);
    elTotal.textContent    = idr(subtotal + ship);
    updateBadge();
  }

  /** ---------- MUTATIONS ---------- **/
  function changeQty(id, delta){
    const cart = getCart();
    const it = cart.find(i=> String(i.id) === String(id));
    if(!it) return;
    it.qty = Math.max(1, (it.qty||1) + delta);
    saveCart(cart); render();
  }
  function setQty(id, qty){
    const cart = getCart();
    const it = cart.find(i=> String(i.id) === String(id));
    if(!it) return;
    it.qty = Math.max(1, isNaN(qty)?1:qty);
    saveCart(cart); render();
  }
  function removeItem(id){
    let cart = getCart().filter(i => String(i.id) !== String(id));
    saveCart(cart); render();
  }

  /** ---------- CHECKOUT (placeholder) ---------- **/
  document.getElementById('checkout-btn').addEventListener('click', () => {
    const items = getCart();
    if(items.length === 0){ alert('Keranjang masih kosong.'); return; }
    // Demo: tampilkan ringkasan. Nanti ganti menuju /checkout dan kirim ke backend.
    alert('Demo checkout: ' + JSON.stringify(items));
  });

  render();
</script>
@endsection
