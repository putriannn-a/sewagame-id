@extends('layouts.app', ['title' => 'Toko'])

@section('filter_bar')
<div class="py-3 pb-4 flex flex-wrap items-center gap-3">
    <div class="w-full sm:w-72">
        <input type="text" placeholder="Cari game" class="w-full bg-[#10141A] border border-[#223347] rounded px-3 py-2 text-xs text-white placeholder-[#5A697A] focus:outline-none focus:border-[#66C0F4]">
    </div>
    <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold">
        <button class="px-3.5 py-1.5 rounded bg-[#324965] text-white">Semua</button>
        <button class="px-3.5 py-1.5 rounded text-[#C7D5E0] hover:text-white">PS5</button>
        <button class="px-3.5 py-1.5 rounded text-[#C7D5E0] hover:text-white">PS4</button>
        <button class="px-3.5 py-1.5 rounded text-[#C7D5E0] hover:text-white">Switch</button>
        <button class="px-3.5 py-1.5 rounded text-[#C7D5E0] hover:text-white">Xbox</button>
        <button class="px-3.5 py-1.5 rounded text-[#C7D5E0] hover:text-white">Retro</button>
    </div>
</div>
@endsection

@section('content')
<div class="bg-[#223347] p-8 rounded-md text-center">
    <h2 class="text-xl font-bold text-white">Toko Rental Game Fisik SEWAGAME.ID</h2>
</div>
@endsection