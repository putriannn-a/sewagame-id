<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform_id',
        'title',
        'cover_image',
        'condition',
        'stock',
        'rent_daily_price',
        'deposit_amount',
        'is_active',
    ];

    protected $casts = [
        'stock'            => 'integer',
        'rent_daily_price' => 'decimal:2',
        'deposit_amount'   => 'decimal:2',
        'is_active'        => 'boolean',
    ];

    /**
     * Mendapatkan URL gambar cover game.
     * Jika cover_image kosong atau file tidak ditemukan, tampilkan placeholder.
     */
    public function coverUrl(): string
    {
        if ($this->cover_image && file_exists(public_path('images/games/' . $this->cover_image))) {
            return asset('images/games/' . $this->cover_image);
        }

        return asset('images/games/placeholder.png');
    }

    /**
     * Relasi N-1: Game dimiliki oleh satu Platform
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * Relasi 1-N: Satu Game bisa memiliki banyak riwayat sewa
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}