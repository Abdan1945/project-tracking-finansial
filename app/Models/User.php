<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    // --- RELASI UNTUK PEMBERSIHAN DATA ---

    /**
     * Relasi ke Akun Keuangan.
     * Digunakan untuk menghapus akun sebelum user dihapus.
     */
    public function akunKeuangan(): HasMany
    {
        return $this->hasMany(AkunKeuangan::class, 'user_id');
    }

    /**
     * Relasi ke Kategori Keuangan.
     * PENTING: Tadi gagal kemungkinan karena relasi ini belum ada.
     */
    public function kategoriKeuangan(): HasMany
    {
        return $this->hasMany(KategoriKeuangan::class, 'user_id');
    }

    /**
     * Relasi ke Transaksi secara langsung.
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}