<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    public function run(): void
{
    User::firstOrCreate(
        ['email' => 'admin1@gmail.com'],
        [
            'name' => 'admin1',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'is_active' => true,
        ]
    );

    User::firstOrCreate(
        ['email' => 'admin2@gmail.com'],
        [
            'name' => 'admin2',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'is_active' => true,
        ]
    );

    User::firstOrCreate(
        ['email' => 'admin3@gmail.com'],
        [
            'name' => 'admin3',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'is_active' => true,
        ]
    );

     User::firstOrCreate(
        ['email' => 'adminlia@gmail.com'],
        [
            'name' => 'adminlia',
            'password' => Hash::make('12345'),
            'role' => 'admin',
            'is_active' => true,
        ]
    );

    }
}