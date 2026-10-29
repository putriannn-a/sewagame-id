@extends('layouts.app', ['title' => 'Sewa Saya'])

@section('content')
<div class="max-w-6xl mx-auto my-6 px-4">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Sewa Saya</h1>
            <p class="text-xs text-[#8F98A0] mt-1">Pantau status peminjaman game fisik dan rincian transaksi Anda</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="bg-[#2A475E] hover:bg-[#345976] text-white px-4 py-2 rounded text-xs font-semibold transition">
            + Sewa Game Lain
        </a>
    </div>

    @if($rentals->isEmpty())
        <div class="bg-[#223347] p-10 rounded-md text-center">
            <p class="text-sm text-[#8F98A0]">Anda belum memiliki riwayat sewa game.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block mt-4 bg-[#3F7D1A] text-white text-xs font-bold px-4 py-2 rounded">
                Mulai Sewa Sekarang
            </a>
        </div>
    @else
        <div class="bg-[#223347] rounded-md overflow-hidden border border-black/20">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="text-[#8F98A0] uppercase tracking-wider text-[11px] border-b border-[#30455E] bg-[#171A21]">
                        <tr>
                            <th class="px-5 py-3.5">KODE</th>
                            <th class="px-5 py-3.5">GAME</th>
                            <th class="px-5 py-3.5">DURASI</th>
                            <th class="px-5 py-3.5">JATUH TEMPO</th>
                            <th class="px-5 py-3.5">TOTAL BIAYA</th>
                            <th class="px-5 py-3.5">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#30455E] text-white font-medium">
                        @foreach($rentals as $rental)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-5 py-4 font-mono text-[#C7D5E0]">
                                    #R-{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded bg-[#10141A] overflow-hidden flex-shrink-0">
                                            <img src="{{ $rental->game->coverUrl() }}" alt="{{ $rental->game->title }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="font-bold text-white">{{ $rental->game->title }}</div>
                                            <div class="text-[11px] text-[#66C0F4]">{{ $rental->game->platform->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-[#C7D5E0]">{{ $rental->duration_days }} Hari</td>
                                <td class="px-5 py-4 text-[#C7D5E0]">
                                    {{ \Carbon\Carbon::parse($rental->due_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-bold text-[#66C0F4]">Rp {{ number_format($rental->rent_total + $rental->deposit_amount, 0, ',', '.') }}</div>
                                    <div class="text-[10px] text-[#8F98A0]">(Deposit: Rp {{ number_format($rental->deposit_amount, 0, ',', '.') }})</div>
                                </td>
                                <td class="px-5 py-4">
                                    @if($rental->status === 'pending_payment')
                                        <a href="{{ route('rentals.pay', $rental->id) }}" class="inline-flex items-center space-x-1.5 text-amber-400 font-semibold hover:underline">
                                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                            <span>Menunggu Pembayaran (Bayar Sekarang &rarr;)</span>
                                        </a>
                                    @elseif($rental->status === 'paid')
                                        <span class="inline-flex items-center space-x-1.5 text-[#66C0F4] font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-[#66C0F4]"></span>
                                            <span>Menunggu Konfirmasi Admin</span>
                                        </span>
                                    @elseif($rental->status === 'active')
                                        <span class="inline-flex items-center space-x-1.5 text-emerald-400 font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                            <span>Aktif Dipinjam</span>
                                        </span>
                                    @elseif($rental->status === 'completed' || $rental->status === 'returned')
                                        <span class="inline-flex items-center space-x-1.5 text-[#8F98A0] font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-[#8F98A0]"></span>
                                            <span>Selesai (Refund Rp {{ number_format($rental->deposit_refund, 0, ',', '.') }})</span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $rentals->links() }}
        </div>
    @endif
</div>
@endsection