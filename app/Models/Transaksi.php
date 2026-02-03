<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jenis',        // pemasukan | pengeluaran
        'kategori_id',
        'akun_id',
        'jumlah',
        'keterangan',
    ];

    /**
     * Cast field otomatis
     */
    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    /**
     * Transaksi milik User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Transaksi memiliki satu Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    /**
     * Transaksi menggunakan satu Akun Keuangan
     */
    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunKeuangan::class, 'akun_id');
    }
}
