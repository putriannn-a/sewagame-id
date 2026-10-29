<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGameRequest;
use App\Http\Requests\Admin\UpdateGameRequest;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {
        $games = Game::with('platform')->latest()->paginate(10);
        return view('admin.games.index', compact('games'));
    }

    public function create(): View
    {
        $platforms = Platform::orderBy('name')->get();
        return view('admin.games.create', compact('platforms'));
    }

    public function store(StoreGameRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle File Upload Cover Image
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/games'), $filename);
            $data['cover_image'] = $filename;
        }

        Game::create($data);

        return redirect()->route('admin.games.index')
            ->with('success', 'Game fisik baru berhasil ditambahkan ke katalog!');
    }

    public function edit(int $id): View
    {
        $game = Game::findOrFail($id);
        $platforms = Platform::orderBy('name')->get();
        return view('admin.games.edit', compact('game', 'platforms'));
    }

    public function update(UpdateGameRequest $request, int $id): RedirectResponse
    {
        $game = Game::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $file->move(public_path('images/games'), $filename);
            $data['cover_image'] = $filename;
        }

        $game->update($data);

        return redirect()->route('admin.games.index')
            ->with('success', 'Data game berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $game = Game::withCount('rentals')->findOrFail($id);

        if ($game->rentals_count > 0) {
            // Cegah hapus jika memiliki riwayat sewa demi menjaga integritas data (onDelete: restrict)
            return back()->with('error', 'Game ini tidak dapat dihapus karena memiliki riwayat transaksi sewa.');
        }

        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('success', 'Game berhasil dihapus dari sistem.');
    }
}