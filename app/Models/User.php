<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Helper untuk mengecek role admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relasi 1-N: Satu User memiliki banyak transaksi sewa
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}