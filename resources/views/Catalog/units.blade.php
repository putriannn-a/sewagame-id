@extends('layouts.app', ['title' => 'Sewa Konsol & Unit'])

@section('content')
<div class="max-w-6xl mx-auto px-4 py-2">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-white">Sewa Konsol & Unit Perlengkapan</h1>
        <p class="text-xs text-[#8F98A0] mt-1">Paket rental mesin konsol harian, stik mabar tambahan, VR2, dan monitor portabel</p>
    </div>

    <!-- Grid Unit & Mesin -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($units as $unit)
            <div class="bg-[#223347] rounded-md overflow-hidden flex flex-col justify-between border border-black/20 group hover:ring-1 hover:ring-[#66C0F4]/40 transition">
                <div>
                    <!-- Foto Gambar Nyata Unit Milikmu -->
                    <div class="h-44 bg-[#182535] relative overflow-hidden">
                        <img 
                            src="{{ $unit['image'] }}" 
                            alt="{{ $unit['title'] }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#223347] via-transparent to-transparent opacity-70"></div>
                        
                        <!-- Badge Stok di atas gambar -->
                        <span class="absolute top-3 right-3 bg-[#10141A]/90 text-[#66C0F4] text-[10px] font-bold px-2.5 py-1 rounded border border-[#30455E]">
                            Sisa {{ $unit['stock'] }} Unit
                        </span>
                    </div>

                    <!-- Detail Info -->
                    <div class="p-5 pb-0">
                        <span class="text-[10px] font-bold text-[#66C0F4] uppercase tracking-wider block mb-1">
                            {{ $unit['category'] }}
                        </span>
                        <h3 class="text-base font-bold text-white group-hover:text-[#66C0F4] transition">{{ $unit['title'] }}</h3>
                        <p class="text-xs text-[#8F98A0] mt-2 leading-relaxed">
                            {{ $unit['desc'] }}
                        </p>
                    </div>
                </div>

                <div class="p-5 pt-4 mt-4 border-t border-[#30455E]">
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

                    <!-- Tombol Booking Unit Bersih -->
                    <button 
                        type="button"
                        onclick="openContactModal('{{ addslashes($unit['title']) }}')" 
                        class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold text-xs py-2.5 rounded transition uppercase tracking-wider shadow text-center"
                    >
                        Hubungi Toko / Booking Unit
                    </button>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- ================= MODAL KONTAK ADMIN TOKO ================= -->
<div id="contactModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#223347] border border-[#30455E] rounded-lg max-w-md w-full p-6 shadow-2xl relative">
        
        <!-- Tombol Tutup -->
        <button onclick="closeContactModal()" class="absolute top-4 right-4 text-[#8F98A0] hover:text-white text-lg font-bold">
            &times;
        </button>

        <div class="mb-4">
            <h3 class="text-base font-extrabold text-white">Layanan Pelanggan Toko</h3>
            <span class="text-[11px] text-emerald-400 font-semibold block mt-0.5">
                Admin Online (09.00 - 22.00 WIB)
            </span>
        </div>

        <p class="text-xs text-[#C7D5E0] leading-relaxed mb-4">
            Untuk reservasi unit: <strong id="modalUnitTitle" class="text-[#66C0F4]"></strong>, silakan langsung hubungi WhatsApp admin kami untuk konfirmasi ketersediaan unit dan jadwal pengambilan.
        </p>

        <!-- Box Kontak Admin -->
        <div class="bg-[#171A21] p-4 rounded-md border border-[#30455E] space-y-3 text-xs mb-5">
            <div>
                <span class="text-[#8F98A0] block text-[11px]">Nomor WhatsApp Admin SewaGame:</span>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-base font-extrabold text-[#66C0F4] tracking-wide" id="adminPhone">0899-9999-9999</span>
                    <button type="button" onclick="navigator.clipboard.writeText('089999999999'); alert('Nomor WhatsApp admin disalin!')" class="bg-[#2A475E] hover:bg-[#345976] text-white px-2.5 py-1 rounded text-[11px] font-semibold transition">
                        Salin No. WA
                    </button>
                </div>
            </div>

            <div class="pt-2 border-t border-[#30455E]">
                <span class="text-[#8F98A0] block text-[11px]">Lokasi Pengambilan Fisik (Pickup Toko):</span>
                <p class="text-white font-medium mt-0.5">
                    Ruko SewaGame.ID Blok C-04, Jl. Kebahagiaan 2
                </p>
            </div>
        </div>

        <!-- Tombol Direct WhatsApp Bersih -->
        <a 
            id="whatsappLink"
            href="https://wa.me/6283824181865?text=Halo%20Admin%20SewaGame.id,%20saya%20ingin%20tanya%20sewa%20unit%20konsol" 
            target="_blank"
            class="w-full bg-[#25D366] hover:bg-[#20ba59] text-black font-extrabold text-xs py-3 rounded text-center block transition shadow uppercase tracking-wider"
        >
            Chat Langsung via WhatsApp &rarr;
        </a>

        <button onclick="closeContactModal()" class="w-full mt-2 text-center text-xs text-[#8F98A0] hover:text-white py-1">
            Tutup
        </button>

    </div>
</div>

@push('scripts')
<script>
    function openContactModal(title) {
        document.getElementById('modalUnitTitle').innerText = title;
        var encoded = encodeURIComponent("Halo Admin SewaGame.ID, saya ingin sewa/booking unit: " + title);
        document.getElementById('whatsappLink').href = "https://wa.me/6289999999999?text=" + encoded;
        document.getElementById('contactModal').classList.remove('hidden');
    }

    function closeContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
    }

    window.onclick = function(event) {
        var modal = document.getElementById('contactModal');
        if (event.target === modal) {
            closeContactModal();
        }
    }
</script>
@endpush
@endsection