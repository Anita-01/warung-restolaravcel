<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Masukkan Data Kategori (pakai firstOrCreate supaya tidak duplikat dengan CategorySeeder)
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
            'name' => 'Chicken Burger Breakfast',
            'description' => 'Ipsum ipsum clita erat amet dolor justo diam',
            'price' => 115,
            'image' => 'menu-1.jpg'
        ]);

        // Menu untuk Lunch
        Menu::create([
            'category_id' => $lunch->id,
            'name' => 'Special Lunch Burger',
            'description' => 'Ipsum ipsum clita erat amet dolor justo diam',
            'price' => 125,
            'image' => 'menu-2.jpg'
        ]);

        // Menu untuk Dinner
        Menu::create([
            'category_id' => $dinner->id,
            'name' => 'Lovely Dinner Pack',
            'description' => 'Ipsum ipsum clita erat amet dolor justo diam',
            'price' => 150,
            'image' => 'menu-3.jpg'
        ]);
    }
}