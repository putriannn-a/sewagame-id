<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Demo
        User::updateOrCreate(
            ['email' => 'admin@sewagame.id'],
            [
                'name'     => 'Pemilik Toko (Admin)',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // 2. Akun Customer Demo
        User::updateOrCreate(
            ['email' => 'cierlary@gmail.com'],
            [
                'name'     => 'Cierlary',
                'password' => Hash::make('customer123'),
                'role'     => 'customer',
            ]
        );
    }
}