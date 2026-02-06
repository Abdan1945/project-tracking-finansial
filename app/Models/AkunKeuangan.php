<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AkunKeuangan extends Model
{
    use HasFactory;

    protected $table = 'akun_keuangan';

    protected $fillable = [
        'user_id',
        'nama_akun',
        'jenis',        // tunai | bank | e-wallet
        'saldo_awal',
    ];

    /**
     * Casting data agar Laravel otomatis mengenali tipe datanya.
     */
    protected $casts = [
        'saldo_awal' => 'decimal:2', // Memastikan saldo dibaca sebagai angka desimal, bukan string
    ];

    /**
     * Relasi balik ke User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Transaksi.
     * Sangat berguna untuk: $akun->transaksi->sum('jumlah')
     */
    public function transaksi(): HasMany
    {
        // Menggunakan 'akun_id' sesuai dengan foreign key di ERD Anda
        return $this->hasMany(Transaksi::class, 'akun_id');
    }
}