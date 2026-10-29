<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Halaman Utama / Toko
     */
    public function index(Request $request): View
    {
        $platforms = Platform::orderBy('id', 'asc')->get();

        // Base query: Eager loading platform
        $query = Game::with('platform')->where('is_active', true);

        // 1. Filter Pencarian Judul
        if ($request->filled('q')) {
            $keyword = trim($request->input('q'));
            $query->where('title', 'like', "%{$keyword}%");
        }

        // 2. Filter Platform (Mendukung alias seperti PS5, PS4, Switch)
        if ($request->filled('platform') && $request->input('platform') !== 'all') {
            $platformInput = trim($request->input('platform'));
            
            // Mapping alias tombol ke nama resmi di database
            $searchPlatform = match (strtoupper($platformInput)) {
                'PS5' => 'PlayStation 5',
                'PS4' => 'PlayStation 4',
                'SWITCH' => 'Nintendo Switch',
                'XBOX' => 'Xbox',
                'RETRO' => 'Retro',
                default => $platformInput,
            };

            $query->whereHas('platform', function ($q) use ($searchPlatform) {
                $q->where('name', 'like', "%{$searchPlatform}%");
            });
        }

        // Ambil hasil query
        $allGames = (clone $query)->latest()->get();
        $featuredHero = $allGames->first();
        $featuredList = $allGames->skip(1)->take(5);

        $recentGames = (clone $query)->latest()->paginate(8)->withQueryString();

        return view('catalog.index', [
            'platforms'    => $platforms,
            'featuredHero' => $featuredHero,
            'featuredList' => $featuredList,
            'recentGames'  => $recentGames,
            'activeFilter' => $request->input('platform', 'all'),
            'searchQuery'  => $request->input('q', ''),
        ]);
    }

    /**
     * Halaman Detail Game
     */
    public function show(int $id): View
    {
        $game = Game::with('platform')->where('is_active', true)->findOrFail($id);
        $allowedDurations = config('rental.allowed_durations', [3, 7, 14]);
        $lateFeePerDay    = config('rental.late_fee_per_day', 10000);

        return view('catalog.show', [
            'game'             => $game,
            'allowedDurations' => $allowedDurations,
            'lateFeePerDay'    => $lateFeePerDay,
        ]);
    }

    /**
     * Halaman Khusus: Sewa Konsol, Mesin Unit, Aksesoris & Layar
     */
    public function units(): View
    {
        // Daftar paket unit mesin & aksesoris rental
        $units = [
            [
                'id'          => 101,
                'title'       => 'Paket Mesin PlayStation 5 Disc Edition',
                'category'    => 'Konsol Utama',
                'desc'        => 'Unit mesin PS5 + 1 Stik DualSense + Kabel HDMI & Power. Siap main di TV rumah.',
                'stock'       => 3,
                'daily_price' => 120000,
                'deposit'     => 800000,
            ],
            [
                'id'          => 102,
                'title'       => 'Paket Mesin Nintendo Switch OLED',
                'category'    => 'Konsol Utama',
                'desc'        => 'Unit tablet OLED + Docking TV + Joy-Con Grip + Charger & Kabel HDMI.',
                'stock'       => 2,
                'daily_price' => 75000,
                'deposit'     => 500000,
            ],
            [
                'id'          => 103,
                'title'       => 'Stik Tambahan DualSense PS5 Wireless Controller',
                'category'    => 'Aksesoris & Controller',
                'desc'        => 'Controller tambahan untuk mabar hingga 4 orang (FIFA / Tekken).',
                'stock'       => 6,
                'daily_price' => 20000,
                'deposit'     => 150000,
            ],
            [
                'id'          => 104,
                'title'       => 'PlayStation VR2 Headset + Sense Controller',
                'category'    => 'Perangkat VR',
                'desc'        => 'Headset virtual reality 4K HDR generasi terbaru untuk PS5.',
                'stock'       => 1,
                'daily_price' => 150000,
                'deposit'     => 1000000,
            ],
            [
                'id'          => 105,
                'title'       => 'Playbox Portable Gaming Monitor 15.6 Inch Full HD',
                'category'    => 'Display / Layar',
                'desc'        => 'Layar monitor portabel praktis untuk acara gathering, camping, atau luar rumah.',
                'stock'       => 2,
                'daily_price' => 60000,
                'deposit'     => 400000,
            ],
        ];

        return view('catalog.units', compact('units'));
    }
}