<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlatformController extends Controller
{
    public function index(): View
    {
        $platforms = Platform::withCount('games')->orderBy('name')->get();
        return view('admin.platforms.index', compact('platforms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:platforms,name'],
        ], [
            'name.required' => 'Nama platform wajib diisi.',
            'name.unique'   => 'Platform ini sudah ada.',
        ]);

        Platform::create(['name' => $request->name]);

        return back()->with('success', 'Platform baru berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $platform = Platform::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:platforms,name,' . $platform->id],
        ]);

        $platform->update(['name' => $request->name]);

        return back()->with('success', 'Platform berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $platform = Platform::withCount('games')->findOrFail($id);

        if ($platform->games_count > 0) {
            return back()->with('error', 'Gagal menghapus: Masih terdapat game yang terdaftar di platform ini.');
        }

        $platform->delete();

        return back()->with('success', 'Platform berhasil dihapus.');
    }
}