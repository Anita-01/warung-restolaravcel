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
            'qty' => 10,
            'price' => 20000,
            'image' => 'nasiuduk.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'klepon',
            'category_id' => 1,
            'qty' => 10,
            'price' => 15000,
            'image' => 'klepon.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'lontongsayur',
            'category_id' => 1,
            'qty' => 10,
            'price' => 15000,
            'image' => 'lontongsayur.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ],
    ]);
}
    }
