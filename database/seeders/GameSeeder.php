<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $ps5    = Platform::where('name', 'PlayStation 5')->first();
        $ps4    = Platform::where('name', 'PlayStation 4')->first();
        $switch = Platform::where('name', 'Nintendo Switch')->first();
        $xbox   = Platform::where('name', 'Xbox Series X')->first();
        $retro  = Platform::where('name', 'Retro Console')->first();

        $games = [
            // PlayStation 5
            [
                'platform_id'      => $ps5->id,
                'title'            => 'Marvel\'s Spider-Man 2',
                'condition'        => 'bnib',
                'stock'            => 4,
                'rent_daily_price' => 35000,
                'deposit_amount'   => 300000,
                'is_active'        => true,
            ],
            [
                'platform_id'      => $ps5->id,
                'title'            => 'God of War Ragnarök',
                'condition'        => 'like_new',
                'stock'            => 3,
                'rent_daily_price' => 30000,
                'deposit_amount'   => 250000,
                'is_active'        => true,
            ],
            // PlayStation 4
            [
                'platform_id'      => $ps4->id,
                'title'            => 'Elden Ring',
                'condition'        => 'good',
                'stock'            => 5,
                'rent_daily_price' => 25000,
                'deposit_amount'   => 200000,
                'is_active'        => true,
            ],
            // Nintendo Switch
            [
                'platform_id'      => $switch->id,
                'title'            => 'The Legend of Zelda: Tears of the Kingdom',
                'condition'        => 'like_new',
                'stock'            => 4,
                'rent_daily_price' => 35000,
                'deposit_amount'   => 300000,
                'is_active'        => true,
            ],
            [
                'platform_id'      => $switch->id,
                'title'            => 'Super Mario Odyssey',
                'condition'        => 'good',
                'stock'            => 2,
                'rent_daily_price' => 20000,
                'deposit_amount'   => 180000,
                'is_active'        => true,
            ],
            // Xbox Series X
            [
                'platform_id'      => $xbox->id,
                'title'            => 'Forza Horizon 5',
                'condition'        => 'like_new',
                'stock'            => 3,
                'rent_daily_price' => 25000,
                'deposit_amount'   => 200000,
                'is_active'        => true,
            ],
            // Retro Console
            [
                'platform_id'      => $retro->id,
                'title'            => 'Tekken 3 (PS1 Original Disc)',
                'condition'        => 'good',
                'stock'            => 1,
                'rent_daily_price' => 15000,
                'deposit_amount'   => 150000,
                'is_active'        => true,
            ],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(
                ['title' => $game['title'], 'platform_id' => $game['platform_id']],
                $game
            );
        }
    }
}