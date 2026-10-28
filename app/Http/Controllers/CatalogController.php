<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Halaman Utama / Toko (Menampilkan Game Pilihan, Baru Masuk, & Filter)
     */
    public function index(Request $request): View
    {
        // 1. Ambil semua platform untuk tombol filter dan jelajahi platform
        $platforms = Platform::orderBy('id', 'asc')->get();

        // 2. Query dasar game aktif menggunakan Eager Loading untuk mencegah N+1 Query
        $query = Game::with('platform')->where('is_active', true);

        // Filter Pencarian Judul (Parameterized Query aman dari SQL Injection)
        if ($request->filled('q')) {
            $keyword = trim($request->input('q'));
            $query->where('title', 'like', "%{$keyword}%");
        }

        // Filter Berdasarkan Platform
        if ($request->filled('platform') && $request->input('platform') !== 'all') {
            $platformParam = $request->input('platform');
            $query->whereHas('platform', function ($q) use ($platformParam) {
                $q->where('name', 'like', "%{$platformParam}%");
            });
        }

        // 3. Ambil data game pilihan (featured) untuk seksi atas
        // Ambil 6 game pertama: game ke-1 jadi kartu besar kiri, 5 game sisanya jadi list kanan
        $allGames = (clone $query)->latest()->get();
        $featuredHero = $allGames->first();
        $featuredList = $allGames->skip(1)->take(5);

        // 4. Data grid "Baru Masuk"
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
     * Halaman Detail Game & Kalkulator Sewa (Screenshot 1)
     */
    public function show(int $id): View
    {
        // Eager loading relasi platform
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