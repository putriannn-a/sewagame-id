<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke users dan games
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onDelete('restrict');
            
            $table->unsignedTinyInteger('duration_days'); // 3, 7, atau 14 hari
            $table->date('start_date');
            $table->date('due_date');
            $table->dateTime('returned_at')->nullable();
            
            // Komponen Keuangan
            $table->decimal('rent_total', 12, 2);       // (daily_price * duration)
            $table->decimal('deposit_amount', 12, 2);   // titipan jaminan
            $table->unsignedInteger('late_days')->default(0);
            $table->decimal('late_fee', 12, 2)->default(0.00);
            $table->decimal('deposit_refund', 12, 2)->default(0.00);
            
            // Pengiriman & Status Operasional
            $table->enum('delivery_method', ['pickup', 'courier'])->default('pickup');
            $table->enum('status', [
                'pending_payment', // Menunggu konfirmasi pembayaran
                'paid',            // Sudah dibayar, siap diambil/dikirim
                'active',          // Sedang dipinjam customer
                'returned',        // Sudah dikembalikan, menunggu cek denda/selesai
                'completed'        // Selesai sepenuhnya, jaminan sudah di-refund
            ])->default('pending_payment');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};