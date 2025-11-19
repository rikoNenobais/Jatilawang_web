@php use Illuminate\Support\Str; @endphp
@extends('layouts.public')

@section('title', 'Katalog Produk')

@section('content')
<section style="background:#f0fdf4; min-height:100vh; padding:4rem 1rem;">
    <div style="max-width:1200px; margin:auto;">
        <h1 style="text-align:center; color:#166534; font-size:2rem; font-weight:bold; margin-bottom:2rem;">
            Katalog Produk
        </h1>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:1.5rem;">
            @foreach ($items as $item)
                <div style="background:white; border-radius:1rem; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden; text-align:center;">
                    <img src="{{ $item->url_image ?? asset('storage/foto-produk/default.png') }}" alt="{{ $item->item_name }}" style="width:100%; height:220px; object-fit:cover;">
                    <div style="padding:1rem;">
                        <h3 style="font-size:1rem; font-weight:bold; margin-bottom:.5rem;">{{ $item->item_name }}</h3>
                        <p style="color:#166534; font-weight:bold; margin-bottom:1rem;">Rp{{ number_format($item->rental_price_per_day ?? 0, 0, ',', '.') }}</p>
                        <a href="{{ route('products.show', $item->item_id) }}"
                            style="display:inline-block; background:#166534; color:white; padding:0.5rem 1.5rem; border-radius:0.5rem; text-decoration:none;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
