<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'method',
        'amount',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // Relasi N-1: Pembayaran terkait ke satu transaksi rental
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }
}