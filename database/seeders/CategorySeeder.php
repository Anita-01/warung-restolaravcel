<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Breakfast',
                'icon' => 'fa-coffee',
                'subtitle' => 'Popular'
            ],
            [
                'name' => 'Lunch',
                'icon' => 'fa-utensils',
                'subtitle' => 'Favorite'
            ],
            [
                'name' => 'Dinner',
                'icon' => 'fa-moon',
                'subtitle' => 'Recommended'
            ],
            [
                'name' => 'Snack',
                'icon' => 'fa-moon',
                'subtitle' => 'Recommended'
            ],


        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'icon' => $category['icon'],
                    'subtitle' => $category['subtitle'],
                ]
            );
        }
    }
}
