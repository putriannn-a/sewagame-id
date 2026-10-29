@extends('layouts.admin', ['title' => 'Master Game'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-extrabold text-white">Kelola Game Fisik</h1>
        <p class="text-xs text-[#8F98A0] mt-1">Daftar semua kaset game, stok, harga, dan ketersediaan</p>
    </div>
    <a href="{{ route('admin.games.create') }}" class="bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold text-xs px-4 py-2 rounded transition shadow">
        + Tambah Game Baru
    </a>
</div>

<div class="bg-[#223347] rounded overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="text-[#8F98A0] uppercase tracking-wider text-[11px] border-b border-[#30455E] bg-[#171A21]">
                <tr>
                    <th class="px-5 py-3.5">COVER & JUDUL</th>
                    <th class="px-5 py-3.5">PLATFORM</th>
                    <th class="px-5 py-3.5">KONDISI</th>
                    <th class="px-5 py-3.5">STOK FISIK</th>
                    <th class="px-5 py-3.5">TARIF / HARI</th>
                    <th class="px-5 py-3.5">DEPOSIT</th>
                    <th class="px-5 py-3.5 text-right">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#30455E] text-white">
                @foreach($games as $game)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-5 py-3 flex items-center space-x-3">
                            <div class="w-10 h-10 rounded bg-[#10141A] overflow-hidden flex-shrink-0">
                                <img src="{{ $game->coverUrl() }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                            </div>
                            <span class="font-bold">{{ $game->title }}</span>
                        </td>
                        <td class="px-5 py-3 text-[#66C0F4] font-semibold">{{ $game->platform->name }}</td>
                        <td class="px-5 py-3 uppercase text-[10px] text-[#C7D5E0]">{{ $game->condition }}</td>
                        <td class="px-5 py-3">
                            <span class="font-bold {{ $game->stock > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $game->stock }} unit
                            </span>
                        </td>
                        <td class="px-5 py-3 font-mono">Rp {{ number_format($game->rent_daily_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 font-mono">Rp {{ number_format($game->deposit_amount, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-right space-x-2">
                            <a href="{{ route('admin.games.edit', $game->id) }}" class="text-[#66C0F4] hover:underline font-semibold">
                                Edit
                            </a>
                            <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus game ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 hover:underline font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-[#30455E]">
        {{ $games->links() }}
    </div>
</div>
@endsection