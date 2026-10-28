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
}