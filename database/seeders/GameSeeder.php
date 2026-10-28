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
            [
                'platform_id'      => $ps5->id,
                'title'            => 'Marvel\'s Spider-Man 2',
                'cover_image'      => "Marvel's Spider-Man 2.jpg",
                'condition'        => 'bnib',
                'stock'            => 4,
                'rent_daily_price' => 35000,
                'deposit_amount'   => 300000,
                'is_active'        => true,
            ],
            [
                'platform_id'      => $ps5->id,
                'title'            => 'God of War Ragnarök',
                'cover_image'      => 'God of War Ragnarök.jpg',
                'condition'        => 'like_new',
                'stock'            => 3,
                'rent_daily_price' => 30000,
                'deposit_amount'   => 250000,
                'is_active'        => true,
            ],
            [
                'platform_id'      => $ps4->id,
                'title'            => 'Elden Ring',
                'cover_image'      => 'Elden Ring.jpg',
                'condition'        => 'good',
                'stock'            => 5,
                'rent_daily_price' => 25000,
                'deposit_amount'   => 200000,
                'is_active'        => true,
            ],
            [
                'platform_id'      => $switch->id,
                'title'            => 'The Legend of Zelda: Tears of the Kingdom',
                'cover_image'      => 'Zelda-Tears-Of-Kingdom-Hero-1038x576.jpg',
                'condition'        => 'like_new',
                'stock'            => 4,
                'rent_daily_price' => 35000,
                'deposit_amount'   => 300000,
                'is_active'        => true,
            ],
            [
                'platform_id'      => $switch->id,
                'title'            => 'Super Mario Odyssey',
                'cover_image'      => 'Super Mario Odyssey Is Right Around The Corner_ -___.jpg',
                'condition'        => 'good',
                'stock'            => 2,
                'rent_daily_price' => 20000,
                'deposit_amount'   => 180000,
                'is_active'        => true,
            ],
            [
                'platform_id'      => $xbox->id,
                'title'            => 'Forza Horizon 5',
                'cover_image'      => 'Forza Horizon 5 Review.jpg',
                'condition'        => 'like_new',
                'stock'            => 3,
                'rent_daily_price' => 25000,
                'deposit_amount'   => 200000,
                'is_active'        => true,
            ],
            [
                'platform_id'      => $retro->id,
                'title'            => 'Tekken 3 (PS1 Original Disc)',
                'cover_image'      => 'tekken3.jpg',
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