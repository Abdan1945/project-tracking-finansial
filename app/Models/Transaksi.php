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
        'jenis', 
        'kategori_id', 
        'akun_id', 
        'jumlah', 
        'keterangan',
    ];

    /**
     * Casting atribut agar otomatis dikonversi ke tipe data yang benar.
     * 'tanggal' dikonversi ke Carbon agar bisa menggunakan ->translatedFormat() di Blade.
     */
    protected $casts = [
        'tanggal'    => 'date',
        'jumlah'     => 'double', 
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke KategoriKeuangan
     * Masalah "Tanpa Kategori" biasanya terjadi karena data 'kategori_id' di DB kosong (null)
     * atau foreign key tidak terhubung dengan benar.
     */
    public function kategori_keuangan(): BelongsTo
    {
        // Pastikan nama tabel referensinya memiliki kolom 'id'
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id', 'id');
    }

    /**
     * Relasi ke AkunKeuangan
     */
    public function akun_keuangan(): BelongsTo
    {
        return $this->belongsTo(AkunKeuangan::class, 'akun_id', 'id');
    }

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}