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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Transaksi (PENTING untuk pengecekan sebelum hapus)
    public function transaksi(): HasMany
    {
        // Menggunakan 'akun_id' sesuai dengan foreign key di database kamu
        return $this->hasMany(Transaksi::class, 'akun_id');
    }
}