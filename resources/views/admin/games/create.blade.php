@extends('layouts.admin', ['title' => 'Tambah Game Baru'])

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-extrabold text-white">Tambah Kaset Game Baru</h1>
        <a href="{{ route('admin.games.index') }}" class="text-xs text-[#8F98A0] hover:text-white">&larr; Kembali</a>
    </div>

    <div class="bg-[#223347] p-6 rounded-md">
        <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block text-[#8F98A0] uppercase font-bold mb-1">Judul Game</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full bg-[#171A21] border border-[#30455E] rounded px-3 py-2 text-white text-xs focus:border-[#66C0F4]">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#8F98A0] uppercase font-bold mb-1">Platform</label>
                    <select name="platform_id" required class="w-full bg-[#171A21] border border-[#30455E] rounded px-3 py-2 text-white text-xs focus:border-[#66C0F4]">
                        @foreach($platforms as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[#8F98A0] uppercase font-bold mb-1">Kondisi</label>
                    <select name="condition" required class="w-full bg-[#171A21] border border-[#30455E] rounded px-3 py-2 text-white text-xs focus:border-[#66C0F4]">
                        <option value="bnib">BNIB (Segel Baru)</option>
                        <option value="like_new">Like New (Mulus)</option>
                        <option value="good" selected>Good (Baik & Terawat)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[#8F98A0] uppercase font-bold mb-1">Stok Fisik</label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0" required class="w-full bg-[#171A21] border border-[#30455E] rounded px-3 py-2 text-white text-xs">
                </div>
                <div>
                    <label class="block text-[#8F98A0] uppercase font-bold mb-1">Tarif / Hari (Rp)</label>
                    <input type="number" name="rent_daily_price" value="{{ old('rent_daily_price', 15000) }}" required class="w-full bg-[#171A21] border border-[#30455E] rounded px-3 py-2 text-white text-xs">
                </div>
                <div>
                    <label class="block text-[#8F98A0] uppercase font-bold mb-1">Deposit (Rp)</label>
                    <input type="number" name="deposit_amount" value="{{ old('deposit_amount', 100000) }}" required class="w-full bg-[#171A21] border border-[#30455E] rounded px-3 py-2 text-white text-xs">
                </div>
            </div>

            <div>
                <label class="block text-[#8F98A0] uppercase font-bold mb-1">Upload File Gambar Cover</label>
                <input type="file" name="cover_image" accept="image/*" class="w-full text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#2A475E] file:text-white hover:file:bg-[#345976]">
            </div>

            <button type="submit" class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold py-2.5 rounded mt-4 text-xs transition uppercase">
                Simpan Game ke Katalog
            </button>
        </form>
    </div>
</div>
@endsection