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
        'jenis',         // pemasukan | pengeluaran
        'kategori_id',
        'akun_id',
        'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori_keuangan(): BelongsTo
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    public function akun_keuangan(): BelongsTo
    {
        return $this->belongsTo(AkunKeuangan::class, 'akun_id');
    }
}