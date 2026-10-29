@extends('layouts.admin', ['title' => 'Dashboard Admin'])

@section('content')
<!-- Header Admin -->
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-white">Dashboard Admin</h1>
    <p class="text-xs text-[#8F98A0] mt-1">Pantau sewa, jatuh tempo, dan denda</p>
</div>

<!-- 4 Stat Cards Sesuai Screenshot 3 -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    
    <!-- 1. Sewa Aktif -->
    <div class="bg-[#223347] p-5 rounded">
        <span class="text-xs text-[#8F98A0] block">Sewa aktif</span>
        <span class="text-3xl font-extrabold text-white mt-3 block">{{ $activeRentalsCount }}</span>
    </div>

    <!-- 2. Jatuh Tempo Hari Ini -->
    <div class="bg-[#223347] p-5 rounded">
        <span class="text-xs text-[#8F98A0] block">Jatuh tempo hari ini</span>
        <span class="text-3xl font-extrabold text-white mt-3 block">{{ $dueTodayCount }}</span>
    </div>

    <!-- 3. Terlambat -->
    <div class="bg-[#223347] p-5 rounded">
        <span class="text-xs text-[#8F98A0] block">Terlambat</span>
        <span class="text-3xl font-extrabold text-white mt-3 block">{{ $overdueCount }}</span>
    </div>

    <!-- 4. Pendapatan Bulan Ini -->
    <div class="bg-[#223347] p-5 rounded">
        <span class="text-xs text-[#8F98A0] block">Pendapatan bulan ini</span>
        <span class="text-3xl font-extrabold text-white mt-3 block">
            Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
        </span>
    </div>

</div>

<!-- SEWA BERJALAN Table Sesuai Screenshot 3 -->
<div>
    <h2 class="text-xs font-bold uppercase tracking-widest text-[#728292] mb-3">SEWA BERJALAN</h2>

    <div class="bg-[#223347] rounded overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="text-[#8F98A0] uppercase tracking-wider text-[11px] border-b border-[#30455E] bg-[#171A21]">
                    <tr>
                        <th class="px-5 py-3.5">KODE</th>
                        <th class="px-5 py-3.5">PENYEWA</th>
                        <th class="px-5 py-3.5">GAME</th>
                        <th class="px-5 py-3.5">JATUH TEMPO</th>
                        <th class="px-5 py-3.5">STATUS</th>
                        <th class="px-5 py-3.5 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#30455E] text-white">
                    @forelse($rentals as $rental)
                        @php
                            $today = \Carbon\Carbon::today();
                            $dueDate = \Carbon\Carbon::parse($rental->due_date);
                            $isOverdue = in_array($rental->status, ['active', 'paid']) && $today->greaterThan($dueDate);
                            $isDueToday = in_array($rental->status, ['active', 'paid']) && $today->equalTo($dueDate);
                            $lateDays = $isOverdue ? $today->diffInDays($dueDate) : 0;
                            if ($isOverdue && $lateDays == 0) $lateDays = 1;
                        @endphp
                        
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-5 py-4 font-semibold text-[#C7D5E0]">
                                #R-{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-5 py-4 font-semibold">
                                {{ $rental->user->name }}
                            </td>
                            <td class="px-5 py-4">
                                {{ $rental->game->title }}
                            </td>
                            <td class="px-5 py-4 text-[#C7D5E0]">
                                {{ $dueDate->translatedFormat('d M') }}
                            </td>
                            <td class="px-5 py-4">
                                @if($rental->status === 'pending_payment')
                                    <span class="inline-flex items-center space-x-1.5 text-amber-300 font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                        <span>Menunggu bayar</span>
                                    </span>
                                @elseif($isOverdue)
                                    <span class="inline-flex items-center space-x-1.5 text-rose-500 font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                        <span>Terlambat {{ $lateDays }} hari</span>
                                    </span>
                                @elseif($isDueToday)
                                    <span class="inline-flex items-center space-x-1.5 text-amber-400 font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                        <span>Jatuh tempo</span>
                                    </span>
                                @elseif($rental->status === 'active' || $rental->status === 'paid')
                                    <span class="inline-flex items-center space-x-1.5 text-[#66C0F4] font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-[#66C0F4]"></span>
                                        <span>Aktif</span>
                                    </span>
                                @elseif($rental->status === 'completed')
                                    <span class="inline-flex items-center space-x-1.5 text-emerald-400 font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                        <span>Selesai</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right space-x-1">
                                <!-- Tombol Aksi Sesuai Status -->
                                @if($rental->status === 'pending_payment')
                                    <form action="{{ route('admin.rentals.confirmPayment', $rental->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded transition">
                                            Konfirmasi bayar
                                        </button>
                                    </form>
                                @elseif(in_array($rental->status, ['active', 'paid']))
                                    <form action="{{ route('admin.rentals.return', $rental->id) }}" method="POST" class="inline" onsubmit="return confirm('Proses pengembalian kaset ini?')">
                                        @csrf
                                        <button type="submit" class="bg-[#2A475E] hover:bg-[#345976] text-white text-xs font-semibold px-4 py-2 rounded transition">
                                            Terima kembali
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[11px] text-[#8F98A0] italic">Sudah kembali</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-xs text-[#8F98A0]">
                                Belum ada data transaksi sewa berjalan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rentals->hasPages())
            <div class="p-4 border-t border-[#30455E]">
                {{ $rentals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection