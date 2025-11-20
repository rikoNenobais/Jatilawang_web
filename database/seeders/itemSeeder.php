<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class itemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $url = 'https://tse3.mm.bing.net/th/id/OIP.X6f2A8mSHHPKX5jqbwNDewHaE7?pid=Api&P=0&h=180';

$items = [
    // ============================
    // 1. HANYA BISA DISEWA
    // ============================

    // Tenda
    ['item_name' => 'Tenda Dome Consina 4 Orang Double Layer', 'category' => 'Tenda', 'url_image' => $url, 'rental_price_per_day' => 85000, 'sale_price' => null, 'rental_stock' => 18, 'sale_stock' => 0, 'penalty_per_days' => 60000, 'is_rentable' => true,  'is_sellable' => false],
    ['item_name' => 'Flysheet 3x4m Waterproof',                 'category' => 'Tenda', 'url_image' => $url, 'rental_price_per_day' => 35000, 'sale_price' => null, 'rental_stock' => 22, 'sale_stock' => 0, 'penalty_per_days' => 25000, 'is_rentable' => true,  'is_sellable' => false],

    // Tas
    ['item_name' => 'Carrier Rei Arei 60L + Raincover',         'category' => 'Tas', 'url_image' => $url, 'rental_price_per_day' => 55000, 'sale_price' => null, 'rental_stock' => 20, 'sale_stock' => 0, 'penalty_per_days' => 40000, 'is_rentable' => true,  'is_sellable' => false],
    ['item_name' => 'Daypack Eiger Pacet 25L',                  'category' => 'Tas', 'url_image' => $url, 'rental_price_per_day' => 35000, 'sale_price' => 590000, 'rental_stock' => 15, 'sale_stock' => 6, 'penalty_per_days' => 25000, 'is_rentable' => true,  'is_sellable' => true],

    // Sleeping Bag
    ['item_name' => 'Sleeping Bag Naturehike -5°C',             'category' => 'Sleeping Bag', 'url_image' => $url, 'rental_price_per_day' => 40000, 'sale_price' => null, 'rental_stock' => 25, 'sale_stock' => 0, 'penalty_per_days' => 30000, 'is_rentable' => true,  'is_sellable' => false],

    // Alat Masak
    ['item_name' => 'Kompor Windproof + Gas 230g',              'category' => 'Alat Masak', 'url_image' => $url, 'rental_price_per_day' => 30000, 'sale_price' => null, 'rental_stock' => 30, 'sale_stock' => 0, 'penalty_per_days' => 20000, 'is_rentable' => true,  'is_sellable' => false],

    // Perlengkapan
    ['item_name' => 'Headlamp Naturehike 300 Lumen',            'category' => 'Perlengkapan', 'url_image' => $url, 'rental_price_per_day' => 22000, 'sale_price' => null, 'rental_stock' => 35, 'sale_stock' => 0, 'penalty_per_days' => 15000, 'is_rentable' => true,  'is_sellable' => false],
    ['item_name' => 'P3K Standar Pendakian Lengkap',            'category' => 'Perlengkapan', 'url_image' => $url, 'rental_price_per_day' => 25000, 'sale_price' => null, 'rental_stock' => 28, 'sale_stock' => 0, 'penalty_per_days' => 18000, 'is_rentable' => true,  'is_sellable' => false],
    ['item_name' => 'Lampu Tenda Naturehike 1000 Lumen',        'category' => 'Perlengkapan', 'url_image' => $url, 'rental_price_per_day' => 25000, 'sale_price' => null, 'rental_stock' => 32, 'sale_stock' => 0, 'penalty_per_days' => 18000, 'is_rentable' => true,  'is_sellable' => false],
    ['item_name' => 'Trekking Pole Consina Anti-Shock',         'category' => 'Perlengkapan', 'url_image' => $url, 'rental_price_per_day' => 30000, 'sale_price' => 420000, 'rental_stock' => 20, 'sale_stock' => 8, 'penalty_per_days' => 20000, 'is_rentable' => true,  'is_sellable' => true],
    ['item_name' => 'Headlamp Naturehike 300 Lumen',            'category' => 'Perlengkapan', 'url_image' => $url, 'rental_price_per_day' => 22000, 'sale_price' => null, 'rental_stock' => 35, 'sale_stock' => 0, 'penalty_per_days' => 15000, 'is_rentable' => true,  'is_sellable' => false],

    // ============================
    // 2. HANYA BISA DIBELI
    // ============================

    ['item_name' => 'Buff Multifungsi Consina Original',         'category' => 'Buff', 'url_image' => $url, 'rental_price_per_day' => null, 'sale_price' => 65000, 'rental_stock' => 0, 'sale_stock' => 80, 'penalty_per_days' => 0, 'is_rentable' => false, 'is_sellable' => true],
    ['item_name' => 'Tumbler Stainless 500ml Consina',           'category' => 'Perlengkapan', 'url_image' => $url, 'rental_price_per_day' => null, 'sale_price' => 135000, 'rental_stock' => 0, 'sale_stock' => 50, 'penalty_per_days' => 0, 'is_rentable' => false, 'is_sellable' => true],
    ['item_name' => 'Kaos Kaki Gunung Eiger Anti Blister',       'category' => 'Perlengkapan', 'url_image' => $url, 'rental_price_per_day' => null, 'sale_price' => 89000, 'rental_stock' => 0, 'sale_stock' => 120, 'penalty_per_days' => 0, 'is_rentable' => false, 'is_sellable' => true],

    // ============================
    // 3. BISA DISEWA & DIBELI
    // ============================

    // Sepatu
    ['item_name' => 'Sepatu Gunung Eiger Oblivion Mid',          'category' => 'Sepatu', 'url_image' => $url, 'rental_price_per_day' => 75000, 'sale_price' => 1399000, 'rental_stock' => 10, 'sale_stock' => 5, 'penalty_per_days' => 50000, 'is_rentable' => true,  'is_sellable' => true],
    ['item_name' => 'Gaiter Anti Lumpur Consina',                'category' => 'Sepatu', 'url_image' => $url, 'rental_price_per_day' => null, 'sale_price' => 175000, 'rental_stock' => 0, 'sale_stock' => 40, 'penalty_per_days' => 0, 'is_rentable' => false, 'is_sellable' => true],

    // Jaket
    ['item_name' => 'Jaket Gunung Consina Avalanche',            'category' => 'Jaket', 'url_image' => $url, 'rental_price_per_day' => 70000, 'sale_price' => 990000, 'rental_stock' => 12, 'sale_stock' => 4, 'penalty_per_days' => 50000, 'is_rentable' => true,  'is_sellable' => true],

    // Raincoat
    ['item_name' => 'Raincoat Ponco Multifungsi',                'category' => 'Raincoat', 'url_image' => $url, 'rental_price_per_day' => 20000, 'sale_price' => 185000, 'rental_stock' => 25, 'sale_stock' => 15, 'penalty_per_days' => 15000, 'is_rentable' => true,  'is_sellable' => true],

    // Sandal
    ['item_name' => 'Sandal Gunung Eiger Caldera',               'category' => 'Sandal', 'url_image' => $url, 'rental_price_per_day' => null, 'sale_price' => 375000, 'rental_stock' => 0, 'sale_stock' => 30, 'penalty_per_days' => 0, 'is_rentable' => false, 'is_sellable' => true],
    ['item_name' => 'Sandal Gunung Hokben ',               'category' => 'Sandal', 'url_image' => $url, 'rental_price_per_day' => null, 'sale_price' => 375000, 'rental_stock' => 0, 'sale_stock' => 30, 'penalty_per_days' => 0, 'is_rentable' => false, 'is_sellable' => true],
];

foreach ($items as $data) {
    Item::create(array_merge($data, [
        'description' => $data['item_name'] . ' – Kualitas premium, siap pakai untuk pendakian gunung di Jawa & luar Jawa.',
    ]));
}

$this->command->info('20 Item berhasil ditambahkan dengan URL gambar yang sama!');

    }
}
