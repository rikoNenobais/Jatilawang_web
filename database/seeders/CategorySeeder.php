<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sepatu', 'slug' => 'sepatu', 'description' => 'Berbagai jenis sepatu gunung dan outdoor'],
            ['name' => 'Tenda', 'slug' => 'tenda', 'description' => 'Tenda camping untuk 2–4 orang, tahan angin dan hujan'],
            ['name' => 'Jaket', 'slug' => 'jaket', 'description' => 'Jaket gunung waterproof, windproof, dan breathable'],
            ['name' => 'Tas', 'slug' => 'tas', 'description' => 'Carrier dan daypack berbagai ukuran'],
            ['name' => 'Perlengkapan Hiking', 'slug' => 'perlengkapan-hiking', 'description' => 'Lampu, botol, trekking pole, dan perlengkapan pendukung lainnya'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
