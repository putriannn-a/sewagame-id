<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'duration_days',
        'start_date',
        'due_date',
        'returned_at',
        'rent_total',
        'deposit_amount',
        'late_days',
        'late_fee',
        'deposit_refund',
        'delivery_method',
        'status',
    ];

    protected $casts = [
        'start_date'     => 'date',
        'due_date'       => 'date',
        'returned_at'    => 'datetime',
        'rent_total'     => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'late_fee'       => 'decimal:2',
        'deposit_refund' => 'decimal:2',
    ];

    // Relasi N-1: Rental dimiliki oleh User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi N-1: Rental meminjam satu Game
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    // Relasi 1-1: Rental memiliki catatan Payment utama
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // Relasi 1-N: Fleksibilitas jika ada riwayat payment jamak
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}