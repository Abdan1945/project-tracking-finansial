<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal',
        'jenis', // 'pemasukan' atau 'pengeluaran'
        'kategori_id',
        'akun_id',
        'jumlah',
        'keterangan',
        'user_id',
    ];

    /**
     * Cast tanggal agar otomatis menjadi objek Carbon.
     */
    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Relasi ke Kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    /**
     * Relasi ke Akun Keuangan.
     */
    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunKeuangan::class, 'akun_id');
    }

    /**
     * Relasi ke User pemilik transaksi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
