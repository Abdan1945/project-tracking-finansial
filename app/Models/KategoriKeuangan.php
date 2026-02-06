<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KategoriKeuangan extends Model
{
    use HasFactory;

    // Nama tabel sesuai di database
    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'user_id',       // ID User (null jika kategori global/bawaan)
        'nama_kategori', // Contoh: Gaji, Makanan, Transportasi
        'jenis',         // Harus: 'pemasukan' atau 'pengeluaran'
        // 'icon',       // Tambahkan jika Anda menggunakan icon (opsional)
        // 'warna',      // Tambahkan jika Anda menggunakan warna (opsional)
    ];

    /**
     * Relasi ke User
     * Kategori ini dimiliki oleh siapa
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Transaksi
     * Satu kategori bisa dipakai di banyak transaksi
     */
    public function transaksi(): HasMany
    {
        // Parameter kedua 'kategori_id' adalah nama kolom di tabel transaksi
        return $this->hasMany(Transaksi::class, 'kategori_id');
    }
}