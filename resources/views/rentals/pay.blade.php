@extends('layouts.app', ['title' => 'Pembayaran Sewa #' . $rental->id])

@section('content')
<div class="max-w-2xl mx-auto my-6 px-4">
    
    <div class="text-center mb-6">
        <span class="inline-block px-3 py-1 bg-amber-500/20 text-amber-300 border border-amber-500/30 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
            Menunggu Pembayaran
        </span>
        <h1 class="text-2xl font-extrabold text-white">Selesaikan Pembayaran Sewa</h1>
        <p class="text-xs text-[#8F98A0] mt-1">Kode Pesanan: <strong class="text-white">#R-{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</strong></p>
    </div>

    <div class="bg-[#223347] rounded-md p-6 border border-black/20 shadow-xl space-y-6">
        
        <!-- Total Tagihan -->
        <div class="bg-[#171A21] p-4 rounded text-center border border-[#30455E]">
            <span class="text-xs text-[#8F98A0] uppercase font-bold block">Total Tagihan Yang Harus Dibayar:</span>
            <span class="text-3xl font-extrabold text-[#66C0F4] block mt-1">
                Rp {{ number_format($rental->rent_total + $rental->deposit_amount, 0, ',', '.') }}
            </span>
            <span class="text-[11px] text-[#8F98A0] block mt-1">
                (Sewa {{ $rental->duration_days }} hari: Rp {{ number_format($rental->rent_total, 0, ',', '.') }} + Deposit: Rp {{ number_format($rental->deposit_amount, 0, ',', '.') }})
            </span>
        </div>

        <!-- Instruksi Sesuai Pilihan Metode -->
        @if($rental->payment->method === 'qris')
            <div class="text-center space-y-3">
                <h3 class="text-xs font-bold uppercase text-white tracking-wider">Scan Kode QRIS di Bawah Ini:</h3>
                
                <div class="inline-block bg-white p-3 rounded-lg border-2 border-slate-300 shadow">
                    <!-- Simulasi Barcode QRIS -->
                    <svg class="w-44 h-44 text-slate-900 mx-auto" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v2h-3v-2zm-5 0h3v4h-3v-4zm2 4h3v3h-3v-3zm3 0h3v3h-3v-3zm-5 1h2v2h-2v-2zm-3-5h2v2h-2v-2zm-2 2h2v2H7v-2z"/>
                    </svg>
                    <span class="text-[10px] font-black text-slate-900 block mt-1 tracking-widest">NMID: ID10292837461</span>
                </div>
                
                <p class="text-xs text-[#8F98A0] leading-relaxed max-w-sm mx-auto">
                    Mendukung semua aplikasi m-Banking (BCA, Mandiri, BRI, BNI) dan E-Wallet (GoPay, OVO, Dana, ShopeePay).
                </p>
            </div>
        @elseif($rental->payment->method === 'bank')
            <div class="bg-[#171A21] p-4 rounded border border-[#30455E] space-y-2">
                <span class="text-xs text-[#8F98A0] block uppercase font-bold">Nomor Virtual Account BCA:</span>
                <div class="flex items-center justify-between bg-[#10141A] p-3 rounded border border-[#30455E]">
                    <span class="text-lg font-extrabold text-[#66C0F4] tracking-wide">8801 2026 8901 2234</span>
                    <button type="button" onclick="navigator.clipboard.writeText('8801202689012234'); alert('Nomor VA BCA disalin!')" class="bg-[#2A475E] hover:bg-[#345976] text-white text-xs font-bold px-3 py-1.5 rounded transition">
                        Salin
                    </button>
                </div>
                <p class="text-[11px] text-[#8F98A0] pt-1">
                    Atas Nama: <strong>SewaGame.ID - {{ Auth::user()->name }}</strong>
                </p>
            </div>
        @else
            <div class="bg-[#171A21] p-4 rounded border border-[#30455E] space-y-2">
                <span class="text-xs text-[#8F98A0] block uppercase font-bold">Nomor Merchant E-Wallet (GoPay / OVO / Dana):</span>
                <div class="flex items-center justify-between bg-[#10141A] p-3 rounded border border-[#30455E]">
                    <span class="text-lg font-extrabold text-[#66C0F4] tracking-wide">0838-2418-1865</span>
                    <button type="button" onclick="navigator.clipboard.writeText('081299007821'); alert('Nomor E-Wallet disalin!')" class="bg-[#2A475E] hover:bg-[#345976] text-white text-xs font-bold px-3 py-1.5 rounded transition">
                        Salin
                    </button>
                </div>
                <p class="text-[11px] text-[#8F98A0] pt-1">
                    Atas Nama: <strong>SewaGame Store Official</strong>
                </p>
            </div>
        @endif

        <!-- Tombol Aksi Sudah Bayar" -->
        <form action="{{ route('rentals.submitPayment', $rental->id) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-extrabold text-sm py-3.5 rounded transition uppercase tracking-wider shadow">
                Sudah Bayar
            </button>
        </form>

        <a href="{{ route('rentals.my') }}" class="block text-center text-xs text-[#8F98A0] hover:text-white mt-3">
            Bayar nanti &bull; Lihat daftar sewa saya
        </a>

    </div>
</div>
@endsection