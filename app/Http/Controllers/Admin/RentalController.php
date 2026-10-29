<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    /**
     * Konfirmasi Pembayaran oleh Admin (Stok Kaset Fisik Berkurang 1)
     */
    public function confirmPayment(int $id): RedirectResponse
    {
        $rental = Rental::with(['game', 'payment'])->findOrFail($id);

        if ($rental->status !== 'pending_payment') {
            return back()->with('warning', 'Transaksi ini sudah dikonfirmasi sebelumnya.');
        }

        if ($rental->game->stock <= 0) {
            return back()->with('error', 'Gagal konfirmasi: Stok fisik kaset ini sudah habis.');
        }

        // DB Transaction: Update rental status + payment + kurangi stok game secara atomik
        DB::transaction(function () use ($rental) {
            // 1. Ubah status sewa menjadi aktif
            $rental->update([
                'status' => 'active',
            ]);

            // 2. Tandai pembayaran lunas
            if ($rental->payment) {
                $rental->payment->update([
                    'status'  => 'paid',
                    'paid_at' => Carbon::now(),
                ]);
            }

            // 3. Kurangi stok kaset fisik
            $rental->game->decrement('stock');
        });

        return back()->with('success', "Pembayaran rental #R-{$rental->id} berhasil dikonfirmasi. Stok game berkurang 1 unit.");
    }

    /**
     * Terima Pengembalian Kaset oleh Admin (Hitung Denda Otomatis & Stok Bertambah 1)
     */
    public function returnGame(int $id): RedirectResponse
    {
        $rental = Rental::with('game')->findOrFail($id);

        if (!in_array($rental->status, ['active', 'paid'])) {
            return back()->with('warning', 'Hanya sewa yang sedang aktif yang bisa diproses pengembalian.');
        }

        $returnedAt = Carbon::now();
        $dueDate    = Carbon::parse($rental->due_date)->endOfDay();
        
        // Hitung Keterlambatan dalam Hari
        $lateDays = 0;
        if ($returnedAt->greaterThan($dueDate)) {
            // Hitung selisih hari keterlambatan
            $lateDays = $returnedAt->diffInDays($dueDate);
            if ($lateDays == 0) $lateDays = 1; // Jika lewat jam di hari yang sama
        }

        // Hitung Denda sesuai Aturan Bisnis UAS (config/rental.php)
        $lateFeePerDay = config('rental.late_fee_per_day', 10000);
        $lateFee       = $lateDays * $lateFeePerDay;

        // Hitung Refund Jaminan: max(0, deposit - late_fee)
        $depositRefund = max(0, $rental->deposit_amount - $lateFee);

        DB::transaction(function () use ($rental, $returnedAt, $lateDays, $lateFee, $depositRefund) {
            // 1. Update data sewa menjadi completed
            $rental->update([
                'returned_at'    => $returnedAt,
                'late_days'      => $lateDays,
                'late_fee'       => $lateFee,
                'deposit_refund' => $depositRefund,
                'status'         => 'completed',
            ]);

            // 2. Tambah kembali stok kaset fisik
            $rental->game->increment('stock');
        });

        $msg = "Kaset telah diterima kembali. Stok bertambah 1.";
        if ($lateDays > 0) {
            $msg .= " Terlambat {$lateDays} hari. Denda Rp " . number_format($lateFee, 0, ',', '.') . " dipotong dari deposit.";
        } else {
            $msg .= " Tepat waktu! Deposit Rp " . number_format($rental->deposit_amount, 0, ',', '.') . " dikembalikan utuh.";
        }

        return back()->with('success', $msg);
    }
}