<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Masukkan Data Kategori
        $breakfast = Category::firstOrCreate(
            ['name' => 'Breakfast'],
            ['icon' => 'fa-coffee', 'subtitle' => 'Popular']
        );

        $lunch = Category::firstOrCreate(
            ['name' => 'Lunch'],
            ['icon' => 'fa-hamburger', 'subtitle' => 'Special']
        );

        $dinner = Category::firstOrCreate(
            ['name' => 'Dinner'],
            ['icon' => 'fa-utensils', 'subtitle' => 'Lovely']
        );

        // 2. Masukkan Data Menu (Contoh)
        // Menu untuk Breakfast
        Menu::create([
            'category_id' => $breakfast->id,
            'name' => 'Paket Sarapan Nusantara',
            'description' => 'Awali harimu dengan hidangan khas Indonesia yang hangat, lezat, dan mengenyangkan.
                                dan pastinya murah meriah',
            'price' => 10000,
            'image' => 'menu-1.jpg'
        ]);

        // Menu untuk Lunch
        Menu::create([
            'category_id' => $lunch->id,
            'name' => 'Paket Makan Siang Hemat',
            'description' => 'Menu lengkap dengan rasa autentik, porsi pas, dan harga terjangkau untuk menemani aktivitas siangmu.',
            'price' => 20000,
            'image' => 'menu-2.jpg'
        ]);

        // Menu untuk Dinner
        Menu::create([
            'category_id' => $dinner->id,
            'name' => 'Menu Makan Malam Spesial',
            'description' => 'Nikmati hidangan malam yang lezat dan menggugah selera, cocok untuk santap bersama keluarga.',
            'price' => 25000,
            'image' => 'menu-3.jpg'
        ]);
    }
}