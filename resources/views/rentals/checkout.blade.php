@extends('layouts.app', ['title' => 'Checkout Sewa - ' . $game->title])

@section('content')
<div class="max-w-4xl mx-auto my-6">
    <!-- Breadcrumb -->
    <div class="text-xs text-[#8F98A0] mb-3 space-x-1.5">
        <a href="{{ route('catalog.index') }}" class="hover:text-white">Toko</a>
        <span>&gt;</span>
        <a href="{{ route('catalog.show', $game->id) }}" class="hover:text-white">{{ $game->title }}</a>
        <span>&gt;</span>
        <span class="text-white">Konfirmasi Sewa</span>
    </div>

    <h1 class="text-2xl font-extrabold text-white mb-6">Konfirmasi & Pembayaran Sewa</h1>

    <form action="{{ route('rentals.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        @csrf
        <input type="hidden" name="game_id" value="{{ $game->id }}">
        <input type="hidden" name="duration_days" value="{{ $duration }}">

        <!-- Kolom Kiri: Rincian Game & Pilihan Metode (8 Kolom) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Card Rincian Game -->
            <div class="bg-[#223347] p-5 rounded-md flex items-center space-x-4 border border-black/20">
                <div class="w-20 h-20 rounded bg-[#10141A] overflow-hidden flex-shrink-0">
                    <img src="{{ $game->coverUrl() }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-[11px] font-bold text-[#66C0F4] uppercase">{{ $game->platform->name }}</span>
                    <h2 class="text-lg font-bold text-white">{{ $game->title }}</h2>
                    <p class="text-xs text-[#8F98A0] mt-1">
                        Durasi: <span class="text-white font-semibold">{{ $duration }} Hari</span> &bull; 
                        Mulai: <span class="text-white">{{ $startDate->translatedFormat('d M Y') }}</span> &bull; 
                        Jatuh Tempo: <span class="text-white">{{ $dueDate->translatedFormat('d M Y') }}</span>
                    </p>
                </div>
            </div>

            <!-- Card Metode Pengambilan -->
            <div class="bg-[#223347] p-5 rounded-md border border-black/20 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-white">1. Metode Pengambilan Kaset</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <label class="flex items-center space-x-3 p-3 rounded bg-[#171A21] border border-[#30455E] cursor-pointer hover:border-[#66C0F4]">
                        <input type="radio" name="delivery_method" value="pickup" checked class="text-[#66C0F4] focus:ring-0">
                        <div>
                            <span class="font-bold text-white block">Ambil di Toko</span>
                            <span class="text-[11px] text-[#8F98A0]">Gratis ongkir, ambil langsung ke toko</span>
                        </div>
                    </label>

                    <label class="flex items-center space-x-3 p-3 rounded bg-[#171A21] border border-[#30455E] cursor-pointer hover:border-[#66C0F4]">
                        <input type="radio" name="delivery_method" value="courier" class="text-[#66C0F4] focus:ring-0">
                        <div>
                            <span class="font-bold text-white block">Kurir Instan</span>
                            <span class="text-[11px] text-[#8F98A0]">Ongkir kurir dibayar di tempat</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Card Metode Pembayaran (Simulasi) -->
            <div class="bg-[#223347] p-5 rounded-md border border-black/20 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-white">2. Metode Pembayaran (Simulasi)</h3>
                <div class="grid grid-cols-3 gap-3 text-xs">
                    <label class="p-3 rounded bg-[#171A21] border border-[#30455E] cursor-pointer hover:border-[#66C0F4] text-center block">
                        <input type="radio" name="payment_method" value="qris" checked class="text-[#66C0F4] focus:ring-0">
                        <span class="font-bold text-white block mt-1">QRIS</span>
                        <span class="text-[10px] text-[#8F98A0]">Scan instan</span>
                    </label>

                    <label class="p-3 rounded bg-[#171A21] border border-[#30455E] cursor-pointer hover:border-[#66C0F4] text-center block">
                        <input type="radio" name="payment_method" value="bank" class="text-[#66C0F4] focus:ring-0">
                        <span class="font-bold text-white block mt-1">Transfer Bank</span>
                        <span class="text-[10px] text-[#8F98A0]">BCA / Mandiri</span>
                    </label>

                    <label class="p-3 rounded bg-[#171A21] border border-[#30455E] cursor-pointer hover:border-[#66C0F4] text-center block">
                        <input type="radio" name="payment_method" value="ewallet" class="text-[#66C0F4] focus:ring-0">
                        <span class="font-bold text-white block mt-1">E-Wallet</span>
                        <span class="text-[10px] text-[#8F98A0]">GoPay / OVO</span>
                    </label>
                </div>
                <p class="text-[11px] text-[#8F98A0] italic mt-2">
                    * Catatan: Ini adalah simulasi pembayaran. Transaksi akan langsung berstatus menunggu konfirmasi admin.
                </p>
            </div>

        </div>

        <!-- Kolom Kanan: Ringkasan Biaya & Tombol Bayar (4 Kolom) -->
        <div class="lg:col-span-4 bg-[#223347] rounded-md p-6 border border-black/20">
            <h2 class="text-xs font-bold uppercase tracking-widest text-[#C7D5E0] mb-4">RINGKASAN BIAYA</h2>

            <div class="space-y-3 text-sm pb-5 border-b border-[#30455E]">
                <div class="flex justify-between">
                    <span class="text-[#8F98A0]">Tarif ({{ $duration }} hari)</span>
                    <span class="text-white font-semibold">Rp {{ number_format($rentTotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#8F98A0]">Deposit jaminan</span>
                    <span class="text-white font-semibold">Rp {{ number_format($deposit, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="pt-5 mb-6">
                <div class="flex justify-between items-baseline">
                    <span class="text-base font-bold text-white">Total bayar</span>
                    <span class="text-xl font-extrabold text-[#66C0F4]">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
                <p class="text-xs text-[#8F98A0] mt-2">
                    Deposit jaminan Rp {{ number_format($deposit, 0, ',', '.') }} dikembalikan utuh saat kaset kembali tepat waktu.
                </p>
            </div>

            <button type="submit" class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold text-sm py-3 rounded transition shadow">
                Konfirmasi & Sewa Sekarang
            </button>
        </div>

    </form>
</div>
@endsection