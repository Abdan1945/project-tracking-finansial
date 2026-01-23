<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- TAMBAHKAN RELASI BERDASARKAN DIAGRAM ---

    /**
     * Relasi ke tabel akun_keuangan (One-to-Many).
     * Seorang user bisa memiliki banyak akun (Bank, Tunai, e-Wallet).
     */
    public function akunKeuangan(): HasMany
    {
        return $this->hasMany(AkunKeuangan::class, 'user_id');
    }

    /**
     * Relasi ke tabel transaksi (One-to-Many).
     * Seorang user bisa mencatat banyak transaksi.
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}
