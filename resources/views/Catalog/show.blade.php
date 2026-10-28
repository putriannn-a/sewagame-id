@extends('layouts.app', ['title' => $game->title])

@section('content')
<!-- Breadcrumb -->
<div class="text-xs text-[#8F98A0] mb-2 space-x-1.5">
    <a href="{{ route('catalog.index') }}" class="hover:text-white transition">Toko</a>
    <span>&gt;</span>
    <a href="{{ route('catalog.index', ['platform' => $game->platform->name]) }}" class="hover:text-white transition">{{ $game->platform->name }}</a>
    <span>&gt;</span>
    <span class="text-white">{{ $game->title }}</span>
</div>

<!-- Title -->
<h1 class="text-3xl font-extrabold text-white mb-6">{{ $game->title }}</h1>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- ========== KOLOM KIRI: Cover & Spesifikasi (8 Kolom) ========== -->
    <div class="lg:col-span-8">
        
        <!-- Large Cover Container dengan Gambar Asli -->
        <div class="h-[380px] bg-[#16212E] rounded-md overflow-hidden relative mb-8 border border-black/20 shadow-xl">
            <img 
                src="{{ $game->coverUrl() }}" 
                alt="{{ $game->title }}" 
                class="w-full h-full object-cover object-center"
            >
        </div>

        <!-- Spesifikasi Game Fisik -->
        <div class="space-y-3 text-sm">
            <div class="grid grid-cols-12">
                <span class="col-span-3 text-[#8F98A0]">Platform</span>
                <span class="col-span-9 text-white font-semibold">{{ $game->platform->name }}</span>
            </div>
            
            <div class="grid grid-cols-12">
                <span class="col-span-3 text-[#8F98A0]">Kondisi</span>
                <span class="col-span-9 text-white">
                    @if($game->condition === 'bnib')
                        Baru (BNIB Segel Pabrik)
                    @elseif($game->condition === 'like_new')
                        Sangat Baik, mulus tanpa baret (Like New)
                    @else
                        Baik, dicek sebelum disewakan
                    @endif
                </span>
            </div>

            <div class="grid grid-cols-12">
                <span class="col-span-3 text-[#8F98A0]">Ketersediaan</span>
                <span class="col-span-9 flex items-center space-x-1.5 text-white">
                    @if($game->stock > 0)
                        <span class="w-2 h-2 rounded-full bg-[#66C0F4]"></span>
                        <span class="font-semibold text-white">Tersedia (Sisa {{ $game->stock }} unit fisik)</span>
                    @else
                        <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                        <span class="font-semibold text-slate-400">Sedang dipinjam (Stok habis)</span>
                    @endif
                </span>
            </div>

            <div class="grid grid-cols-12">
                <span class="col-span-3 text-[#8F98A0]">Pengambilan</span>
                <span class="col-span-9 text-white">Ambil di toko atau kurir instan</span>
            </div>
        </div>

    </div>

    <!-- ========== KOLOM KANAN: SEWA GAME INI (4 Kolom) ========== -->
    <div class="lg:col-span-4 bg-[#223347] rounded-md p-6 border border-black/20">
        <h2 class="text-xs font-bold uppercase tracking-widest text-[#C7D5E0] mb-4">SEWA GAME INI</h2>

        @if($game->stock <= 0)
            <!-- Pesan Stok Habis -->
            <div class="p-4 bg-[#171A21] rounded text-xs text-rose-400 font-semibold mb-4 text-center">
                Mohon maaf, stok kaset game ini sedang habis dipinjam.
            </div>
        @else
            <!-- Form Checkout (action akan dihubungkan di Tahap 5) -->
            <form action="{{ route('rentals.checkout', $game->id) }}" method="GET" id="rentForm">
                <!-- Hidden Input Durasi (diupdate oleh JavaScript) -->
                <input type="hidden" name="duration" id="input-duration" value="7">
                
                <!-- Pilihan Durasi 3 / 7 / 14 Hari -->
                <div class="grid grid-cols-3 gap-2 mb-6">
                    <button 
                        type="button" 
                        onclick="selectDuration(3)" 
                        id="btn-dur-3" 
                        class="py-2.5 rounded bg-[#171A21] text-xs font-bold text-white text-center hover:bg-[#202530] transition"
                    >
                        3 hari
                    </button>
                    <button 
                        type="button" 
                        onclick="selectDuration(7)" 
                        id="btn-dur-7" 
                        class="py-2.5 rounded bg-[#66C0F4] text-xs font-extrabold text-[#171A21] text-center transition"
                    >
                        7 hari
                    </button>
                    <button 
                        type="button" 
                        onclick="selectDuration(14)" 
                        id="btn-dur-14" 
                        class="py-2.5 rounded bg-[#171A21] text-xs font-bold text-white text-center hover:bg-[#202530] transition"
                    >
                        14 hari
                    </button>
                </div>

                <!-- Rincian Kalkulasi Biaya Sewa -->
                <div class="space-y-3 text-sm pb-5 border-b border-[#30455E]">
                    <div class="flex justify-between">
                        <span class="text-[#8F98A0]">Harga sewa harian</span>
                        <span class="text-white font-semibold">Rp {{ number_format($game->rent_daily_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-[#8F98A0]">Sewa <span id="text-dur-label">7</span> hari</span>
                        <span class="text-white font-semibold" id="text-rent-total">Rp {{ number_format($game->rent_daily_price * 7, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-[#8F98A0]">Deposit jaminan</span>
                        <span class="text-white font-semibold">Rp {{ number_format($game->deposit_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Total Bayar & Estimasi Tanggal Kembali -->
                <div class="pt-5 mb-2">
                    <div class="flex justify-between items-baseline">
                        <span class="text-base font-bold text-white">Total bayar</span>
                        <span class="text-xl font-extrabold text-white" id="text-grand-total">
                            Rp {{ number_format(($game->rent_daily_price * 7) + $game->deposit_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <p class="text-xs text-[#8F98A0] mt-2 leading-relaxed" id="text-date-info">
                        <!-- Di-update otomatis oleh JavaScript -->
                    </p>
                </div>

                <!-- Tombol Sewa Sekarang (Hijau #3F7D1A) -->
                @auth
                    <button type="submit" class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold text-sm py-3 rounded mt-5 transition shadow">
                        Sewa sekarang
                    </button>
                @else
                    <a href="{{ route('login') }}" class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold text-sm py-3 rounded mt-5 transition shadow text-center block">
                        Masuk untuk Menyewa
                    </a>
                @endauth

                <p class="text-[11px] text-[#8F98A0] mt-4 leading-relaxed">
                    Denda terlambat Rp {{ number_format($lateFeePerDay, 0, ',', '.') }} per hari, dipotong dari deposit.
                </p>
            </form>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Data dari database (dikirim oleh PHP ke JavaScript)
    const dailyPrice = {{ (int) $game->rent_daily_price }};
    const depositAmount = {{ (int) $game->deposit_amount }};

    /**
     * Fungsi selectDuration(days)
     * Mengubah tampilan tombol aktif, menghitung ulang subtotal sewa,
     * grand total (sewa + deposit), dan estimasi tanggal kembali.
     */
    function selectDuration(days) {
        // 1. Update tampilan tombol aktif (biru muda) vs non-aktif (gelap)
        [3, 7, 14].forEach(function(d) {
            var btn = document.getElementById('btn-dur-' + d);
            if (d === days) {
                btn.className = 'py-2.5 rounded bg-[#66C0F4] text-xs font-extrabold text-[#171A21] text-center transition';
            } else {
                btn.className = 'py-2.5 rounded bg-[#171A21] text-xs font-bold text-white text-center hover:bg-[#202530] transition';
            }
        });

        // 2. Simpan durasi terpilih ke hidden input (dikirim ke server saat checkout)
        document.getElementById('input-duration').value = days;

        // 3. Hitung biaya sesuai aturan bisnis:
        //    rent_total = harga_harian × durasi
        //    grand_total = rent_total + deposit_jaminan
        var rentSubtotal = dailyPrice * days;
        var grandTotal = rentSubtotal + depositAmount;

        // 4. Update teks kalkulasi di tampilan
        document.getElementById('text-dur-label').innerText = days;
        document.getElementById('text-rent-total').innerText = 'Rp ' + rentSubtotal.toLocaleString('id-ID');
        document.getElementById('text-grand-total').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');

        // 5. Hitung estimasi tanggal mulai (hari ini) dan tanggal kembali (+ durasi)
        updateDateInfo(days);
    }

    /**
     * Fungsi updateDateInfo(days)
     * Menghitung tanggal mulai sewa (hari ini) dan tanggal jatuh tempo (hari ini + durasi).
     */
    function updateDateInfo(days) {
        var today = new Date();
        var dueDate = new Date();
        dueDate.setDate(today.getDate() + days);

        var options = { day: 'numeric', month: 'long', year: 'numeric' };
        var todayStr = today.toLocaleDateString('id-ID', options);
        var dueStr = dueDate.toLocaleDateString('id-ID', options);

        document.getElementById('text-date-info').innerText = 
            'Jika mulai ' + todayStr + ', kembali pada ' + dueStr + '.';
    }

    // Jalankan kalkulasi awal saat halaman pertama kali terbuka (default: 7 hari)
    document.addEventListener('DOMContentLoaded', function() {
        selectDuration(7);
    });
</script>
@endpush