<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            ['name' => 'PlayStation 5'],
            ['name' => 'PlayStation 4'],
            ['name' => 'Nintendo Switch'],
            ['name' => 'Xbox Series X'],
            ['name' => 'Retro Console'],
        ];

        foreach ($platforms as $platform) {
            Platform::updateOrCreate(['name' => $platform['name']]);
        }
    }
}