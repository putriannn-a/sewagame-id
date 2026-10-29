@extends('layouts.admin', ['title' => 'Master Platform'])

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Kelola Platform Konsol</h1>
            <p class="text-xs text-[#8F98A0] mt-1">Daftar platform konsol pendukung katalog rental</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        
        <!-- Form Tambah Platform (Kiri) -->
        <div class="md:col-span-5 bg-[#223347] p-5 rounded-md">
            <h2 class="text-xs font-bold uppercase tracking-wider text-white mb-3">Tambah Platform Baru</h2>
            <form action="{{ route('admin.platforms.store') }}" method="POST" class="space-y-3 text-xs">
                @csrf
                <div>
                    <label class="block text-[#8F98A0] mb-1">Nama Platform</label>
                    <input type="text" name="name" required placeholder="Contoh: PlayStation 5" class="w-full bg-[#171A21] border border-[#30455E] rounded px-3 py-2 text-white text-xs focus:border-[#66C0F4]">
                </div>
                <button type="submit" class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold py-2 rounded transition">
                    + Simpan Platform
                </button>
            </form>
        </div>

        <!-- Tabel Platform (Kanan) -->
        <div class="md:col-span-7 bg-[#223347] rounded overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead class="text-[#8F98A0] uppercase tracking-wider text-[11px] border-b border-[#30455E] bg-[#171A21]">
                    <tr>
                        <th class="px-5 py-3">NAMA PLATFORM</th>
                        <th class="px-5 py-3">JUMLAH GAME</th>
                        <th class="px-5 py-3 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#30455E] text-white">
                    @foreach($platforms as $p)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-5 py-3.5 font-bold">{{ $p->name }}</td>
                            <td class="px-5 py-3.5 text-[#66C0F4] font-semibold">{{ $p->games_count }} Game</td>
                            <td class="px-5 py-3.5 text-right">
                                <form action="{{ route('admin.platforms.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus platform {{ $p->name }}?')">
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

    </div>
</div>
@endsection