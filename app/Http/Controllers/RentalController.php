<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentalRequest;
use App\Models\Game;
use App\Models\Payment;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RentalController extends Controller
{
    /**
     * Halaman Checkout Sewa
     */
    public function checkout(Request $request, int $gameId): View|RedirectResponse
    {
        $game = Game::with('platform')->where('is_active', true)->findOrFail($gameId);

        if ($game->stock <= 0) {
            return redirect()->route('catalog.show', $game->id)
                ->with('error', 'Maaf, stok kaset game ini sedang kosong.');
        }

        $duration = (int) $request->input('duration', 7);
        if (!in_array($duration, config('rental.allowed_durations', [3, 7, 14]))) {
            $duration = 7;
        }

        $rentTotal   = $game->rent_daily_price * $duration;
        $deposit     = $game->deposit_amount;
        $grandTotal  = $rentTotal + $deposit;
        $startDate   = Carbon::now();
        $dueDate     = Carbon::now()->addDays($duration);

        return view('rentals.checkout', compact('game', 'duration', 'rentTotal', 'deposit', 'grandTotal', 'startDate', 'dueDate'));
    }

    /**
     * Memproses Penyimpanan Data Sewa (Server-Side Calculation & DB Transaction)
     */
    public function store(StoreRentalRequest $request): RedirectResponse
    {
        $game = Game::findOrFail($request->game_id);

        if ($game->stock <= 0) {
            return back()->with('error', 'Gagal menyewa: Stok fisik kaset baru saja habis.');
        }

        // Kalkulasi ulang di server untuk menjamin integritas (Mencegah manipulasi client)
        $duration   = (int) $request->duration_days;
        $rentTotal  = $game->rent_daily_price * $duration;
        $deposit    = $game->deposit_amount;
        $grandTotal = $rentTotal + $deposit;

        $startDate  = Carbon::today();
        $dueDate    = Carbon::today()->addDays($duration);

        // Gunakan DB Transaction agar pembuatan rental & payment bersifat atomik
        DB::transaction(function () use ($request, $game, $duration, $startDate, $dueDate, $rentTotal, $deposit, $grandTotal) {
            // 1. Simpan Transaksi Rental
            $rental = Rental::create([
                'user_id'         => Auth::id(),
                'game_id'         => $game->id,
                'duration_days'   => $duration,
                'start_date'      => $startDate,
                'due_date'        => $dueDate,
                'rent_total'      => $rentTotal,
                'deposit_amount'  => $deposit,
                'late_days'       => 0,
                'late_fee'        => 0,
                'deposit_refund'  => $deposit, // Default refund utuh
                'delivery_method' => $request->delivery_method,
                'status'          => 'pending_payment',
            ]);

            // 2. Simpan Catatan Pembayaran (Simulasi)
            Payment::create([
                'rental_id' => $rental->id,
                'method'    => $request->payment_method,
                'amount'    => $grandTotal,
                'status'    => 'pending',
                'paid_at'   => null,
            ]);
        });

        return redirect()->route('rentals.my')
            ->with('success', 'Pesanan sewa berhasil dibuat! Menunggu konfirmasi pembayaran oleh Admin.');
    }

    /**
     * Halaman Riwayat "Sewa Saya" (Customer)
     */
    public function myRentals(): View
    {
        // Policy / Hak Akses: Customer hanya bisa melihat sewa miliknya sendiri
        $rentals = Rental::with(['game.platform', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('rentals.my', compact('rentals'));
    }


}

    /**
     * Memproses Penyimpanan Sewa Awal (Status: Menunggu Pembayaran)
     */
    public function store(StoreRentalRequest $request): RedirectResponse
    {
        $game = Game::findOrFail($request->game_id);

        if ($game->stock <= 0) {
            return back()->with('error', 'Gagal menyewa: Stok fisik kaset baru saja habis.');
        }

        $duration   = (int) $request->duration_days;
        $rentTotal  = $game->rent_daily_price * $duration;
        $deposit    = $game->deposit_amount;
        $grandTotal = $rentTotal + $deposit;

        $startDate  = Carbon::today();
        $dueDate    = Carbon::today()->addDays($duration);

        $rental = DB::transaction(function () use ($request, $game, $duration, $startDate, $dueDate, $rentTotal, $deposit, $grandTotal) {
            $rental = Rental::create([
                'user_id'         => Auth::id(),
                'game_id'         => $game->id,
                'duration_days'   => $duration,
                'start_date'      => $startDate,
                'due_date'        => $dueDate,
                'rent_total'      => $rentTotal,
                'deposit_amount'  => $deposit,
                'late_days'       => 0,
                'late_fee'        => 0,
                'deposit_refund'  => $deposit,
                'delivery_method' => $request->delivery_method,
                'status'          => 'pending_payment',
            ]);

            Payment::create([
                'rental_id' => $rental->id,
                'method'    => $request->payment_method,
                'amount'    => $grandTotal,
                'status'    => 'pending',
                'paid_at'   => null,
            ]);

            return $rental;
        });

        // Alihkan langsung ke halaman pembayaran / tagihan QRIS/VA
        return redirect()->route('rentals.pay', $rental->id);
    }

    /**
     * Halaman Bayar (Menampilkan Barcode QRIS / Virtual Account Bank / No E-Wallet)
     */
    public function pay(int $id): View
    {
        $rental = Rental::with(['game.platform', 'payment'])->where('user_id', Auth::id())->findOrFail($id);
        return view('rentals.pay', compact('rental'));
    }

    /**
     * Konfirmasi Selesai Bayar oleh Customer
     */
    public function submitPayment(int $id): RedirectResponse
    {
        $rental = Rental::where('user_id', Auth::id())->findOrFail($id);

        // Ubah status pembayaran customer menjadi paid (menunggu persetujuan admin)
        $rental->update(['status' => 'paid']);
        if ($rental->payment) {
            $rental->payment->update([
                'status'  => 'paid',
                'paid_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('rentals.my')
            ->with('success', 'Pembayaran berhasil dikirim! Menunggu konfirmasi verifikasi dari Admin.');
    }