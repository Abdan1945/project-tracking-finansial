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
     * Akun dimiliki oleh user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Akun punya banyak transaksi
     */
    public function transaksi(): HasMany
    {
        // Sesuaikan 'akun_keuangan_id' agar sama dengan yang ada di tabel transaksi
        return $this->hasMany(Transaksi::class, 'akun_keuangan_id');
    }
}