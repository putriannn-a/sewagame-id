@extends('layouts.app', ['title' => 'Sewa Konsol & Unit'])

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-white">Sewa Konsol & Unit Perlengkapan</h1>
    <p class="text-xs text-[#8F98A0] mt-1">Paket rental mesin konsol harian, stik mabar tambahan, VR2, dan monitor portabel</p>
</div>

<!-- Grid Unit & Mesin -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($units as $unit)
        <div class="bg-[#223347] rounded-md overflow-hidden flex flex-col justify-between border border-black/20 p-5">
            <div>
                <div class="h-36 bg-[#16212E] rounded flex items-center justify-center text-5xl mb-4 border border-black/20">
                </div>

                <span class="text-[10px] font-bold text-[#66C0F4] uppercase tracking-wider block mb-1">
                    {{ $unit['category'] }}
                </span>
                <h3 class="text-base font-bold text-white">{{ $unit['title'] }}</h3>
                <p class="text-xs text-[#8F98A0] mt-2 leading-relaxed">
                    {{ $unit['desc'] }}
                </p>
            </div>

            <div class="mt-6 pt-4 border-t border-[#30455E]">
                <div class="flex items-baseline justify-between mb-3 text-xs">
                    <div>
                        <span class="text-[#8F98A0] block text-[11px]">Tarif Sewa:</span>
                        <span class="text-base font-extrabold text-[#66C0F4]">
                            Rp {{ number_format($unit['daily_price'], 0, ',', '.') }} <span class="text-xs font-normal text-[#8F98A0]">/ hari</span>
                        </span>
                    </div>
                    <div class="text-right">
                        <span class="text-[#8F98A0] block text-[11px]">Jaminan (Deposit):</span>
                        <span class="text-white font-semibold">Rp {{ number_format($unit['deposit'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <button onclick="alert('Untuk reservasi unit mesin konsol, stik tambahan, atau monitor portabel, silakan konfirmasi langsung ke nomor WhatsApp toko kami di 0812-9900-7821. Unit akan disiapkan lengkap dengan kabel.')" class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold text-xs py-2.5 rounded transition uppercase tracking-wider shadow">
                    Hubungi Toko / Booking Unit
                </button>
            </div>
        </div>
    @endforeach
</div>
@endsection