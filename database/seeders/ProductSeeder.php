<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Product::insert([
        [
                'name' => 'Nasi Goreng',
                'category_id' => 1,
                'qty' => 20,
                'price' => 20000,
                'image' => 'nasigoreng.jpg'
            ],
            [
                'name' => 'Mie Goreng',
                'category_id' => 1,
                'qty' => 15,
                'price' => 18000,
                'image' => 'miegoreng.jpg'
            ],

            // ======================
            // LUNCH (id = 2)
            // ======================
            [
                'name' => 'Ayam Bakar',
                'category_id' => 2,
                'qty' => 10,
                'price' => 25000,
                'image' => 'ayambakar.jpg'
            ],
            [
                'name' => 'Ayam Goreng',
                'category_id' => 2,
                'qty' => 12,
                'price' => 22000,
                'image' => 'ayamgoreng.jpg'
            ],
            [
                'name' => 'Sate Ayam',
                'category_id' => 2,
                'qty' => 25,
                'price' => 23000,
                'image' => 'sate.jpg'
            ],

            // ======================
            // DINNER (id = 3)
            // ======================
            [
                'name' => 'Soto Ayam',
                'category_id' => 3,
                'qty' => 18,
                'price' => 15000,
                'image' => 'soto.jpg'
            ],
            [
                'name' => 'Lontong Sayur',
                'category_id' => 3,
                'qty' => 14,
                'price' => 15000,
                'image' => 'lontong.jpg'
            ],

            // ======================
            // SNACK (id = 4)
            // ======================
            [
                'name' => 'Klepon',
                'category_id' => 4,
                'qty' => 35,
                'price' => 15000,
                'image' => 'klepon.jpg'
            ],
            [
                'name' => 'Lupis',
                'category_id' => 4,
                'qty' => 20,
                'price' => 9000,
                'image' => 'lupis.jpg'
            ],
            [
                'name' => 'Pisang Goreng',
                'category_id' => 4,
                'qty' => 30,
                'price' => 10000,
                'image' => 'pisang.jpg'
            ],
            [
                'name' => 'Risol',
                'category_id' => 4,
                'qty' => 40,
                'price' => 8000,
                'image' => 'risol.jpg'
            ],
            [
                'name' => 'Pastel',
                'category_id' => 4,
                'qty' => 35,
                'price' => 8000,
                'image' => 'pastel.jpg'
            ],
    ]);
}
    }
