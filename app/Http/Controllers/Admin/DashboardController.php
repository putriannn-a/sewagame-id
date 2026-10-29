<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        // 1. Sewa Aktif (kaset sedang dipinjam oleh customer)
        $activeRentalsCount = Rental::whereIn('status', ['active', 'paid'])->count();

        // 2. Jatuh Tempo Hari Ini
        $dueTodayCount = Rental::whereIn('status', ['active', 'paid'])
            ->whereDate('due_date', $today)
            ->count();

        // 3. Terlambat (lewat due_date dan belum dikembalikan)
        $overdueCount = Rental::whereIn('status', ['active', 'paid'])
            ->whereDate('due_date', '<', $today)
            ->count();

        // 4. Pendapatan Bulan Berjalan (hanya sewa yang sudah dibayar/selesai)
        $monthlyRevenue = Rental::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereIn('status', ['paid', 'active', 'completed'])
            ->sum('rent_total');

        // 5. Tabel "Sewa Berjalan" (Transaksional yang butuh tindakan)
        $rentals = Rental::with(['user', 'game.platform'])
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact(
            'activeRentalsCount',
            'dueTodayCount',
            'overdueCount',
            'monthlyRevenue',
            'rentals'
        ));
    }
}