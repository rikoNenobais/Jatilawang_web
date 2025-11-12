<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            [
                'slug'  => 'sepatu-gunung-eiger-anaconda-25',
                'name'  => 'Sepatu Gunung Eiger Anaconda 2.5',
                'price' => 'Rp 25.000 / Hari',
                'img'   => 'sepatu-eiger-plum.png',
                'desc'  => 'Sepatu hiking mid cut dengan bahan tahan air dan sol anti slip untuk medan berat.'
            ],
            [
                'slug'  => 'tenda-camping-antarestar',
                'name'  => 'Tenda Camping Antarestar (2 Orang)',
                'price' => 'Rp 35.000 / Hari',
                'img'   => 'tenda-camping.png',
                'desc'  => 'Tenda ringan berkapasitas 2 orang dengan ventilasi udara ganda dan bahan waterproof.'
            ],
            [
                'slug'  => 'sleeping-bag-bigadventure-bunaken',
                'name'  => 'Sleeping Bag Bigadventure Bunaken',
                'price' => 'Rp 25.000 / Hari',
                'img'   => 'sleeping-bag-hijau.png',
                'desc'  => 'Sleeping bag dengan bahan halus dan lapisan hangat untuk suhu dingin pegunungan.'
            ],
            [
                'slug'  => 'sandal-gunung-eiger-kinkajou',
                'name'  => 'Sandal Gunung Eiger Kinkajou',
                'price' => 'Rp 20.000 / Hari',
                'img'   => 'sandal-eiger.png',
                'desc'  => 'Sandal outdoor ringan dan nyaman dengan grip kuat untuk kegiatan hiking.'
            ],
            [
                'slug'  => 'kaos-kaki-eiger-kalahari',
                'name'  => 'Kaos Kaki Eiger Kalahari',
                'price' => 'Rp 10.000 / Hari',
                'img'   => 'kaos-kaki-oren.png',
                'desc'  => 'Kaos kaki outdoor dengan bahan breathable yang cepat kering dan tahan lama.'
            ],
            [
                'slug'  => 'botol-minum-eiger-selfoss',
                'name'  => 'Botol Minum Eiger Selfoss',
                'price' => 'Rp 15.000 / Hari',
                'img'   => 'botol-minum-eiger.png',
                'desc'  => 'Botol minum 1L tahan banting, cocok untuk kegiatan outdoor.'
            ],
            [
                'slug'  => 'headlamp-bigadventure',
                'name'  => 'Headlamp Big Adventure',
                'price' => 'Rp 10.000 / Hari',
                'img'   => 'headlamp-bigadventure.png',
                'desc'  => 'Headlamp terang dan hemat daya, ideal untuk aktivitas malam hari.'
            ],
            [
                'slug'  => 'carrier-eiger-streamline',
                'name'  => 'Tas Gunung Streamline Eiger 40L',
                'price' => 'Rp 35.000 / Hari',
                'img'   => 'carrier-eiger-streamline.png',
                'desc'  => 'Carrier berkapasitas 40L dengan bantalan punggung ergonomis dan ventilasi udara.'
            ],
        ];

        return view('products.index', compact('products'));
    }

    public function show($slug)
    {
        // Data produk dengan gambar dari storage/foto-produk
        $products = [
            [
                'name'  => 'Sepatu Gunung Eiger Anaconda 2.5',
                'price' => 'Rp 25.000 / Hari',
                'img'   => 'sepatu-eiger-plum.png',
                'desc'  => 'Sepatu hiking mid cut dengan bahan tahan air dan sol anti slip untuk medan berat.'
            ],
            [
                'name'  => 'Tenda Camping Antarestar (2 Orang)',
                'price' => 'Rp 35.000 / Hari',
                'img'   => 'tenda-camping.png',
                'desc'  => 'Tenda ringan berkapasitas 2 orang dengan ventilasi udara ganda dan bahan waterproof.'
            ],
            [
                'name'  => 'Sleeping Bag Bigadventure Bunaken',
                'price' => 'Rp 25.000 / Hari',
                'img'   => 'sleeping-bag-hijau.png',
                'desc'  => 'Sleeping bag dengan bahan halus dan lapisan hangat untuk suhu dingin pegunungan.'
            ],
            [
                'name'  => 'Sandal Gunung Eiger Kinkajou',
                'price' => 'Rp 20.000 / Hari',
                'img'   => 'sandal-eiger.png',
                'desc'  => 'Sandal outdoor ringan dan nyaman dengan grip kuat untuk kegiatan hiking.'
            ],
            [
                'name'  => 'Kaos Kaki Eiger Kalahari',
                'price' => 'Rp 10.000 / Hari',
                'img'   => 'kaos-kaki-oren.png',
                'desc'  => 'Kaos kaki outdoor dengan bahan breathable yang cepat kering dan tahan lama.'
            ],
            [
                'name'  => 'Botol Minum Eiger Selfoss',
                'price' => 'Rp 15.000 / Hari',
                'img'   => 'botol-minum-eiger.png',
                'desc'  => 'Botol minum 1L tahan banting, cocok untuk kegiatan outdoor.'
            ],
            [
                'name'  => 'Headlamp Big Adventure',
                'price' => 'Rp 10.000 / Hari',
                'img'   => 'headlamp-bigadventure.png',
                'desc'  => 'Headlamp terang dan hemat daya, ideal untuk aktivitas malam hari.'
            ],
            [
                'name'  => 'Tas Gunung Streamline Eiger 40L',
                'price' => 'Rp 35.000 / Hari',
                'img'   => 'carrier-eiger-streamline.png',
                'desc'  => 'Carrier berkapasitas 40L dengan bantalan punggung ergonomis dan ventilasi udara.'
            ],
        ];

        // Temukan produk berdasarkan slug
        $product = collect($products)->first(fn($p) => Str::slug($p['name']) === $slug);

        abort_if(!$product, 404);

        // Tambahkan URL gambar agar bisa langsung digunakan di view
        $product['img_url'] = asset('storage/foto-produk/' . $product['img']);

        return view('products.show', compact('product'));
    }
}
