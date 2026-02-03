<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KategoriKeuangan extends Model
{
    use HasFactory;

    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'user_id',
        'nama_kategori',
        'jenis', 
    ];

    public function user(): BelongsTo
    {
        // Laravel secara otomatis mencari class User di namespace yang sama
        return $this->belongsTo(User::class);
    }

    public function transaksi(): HasMany
    {
        // Pastikan file Transaksi.php sudah ada di folder Models
        return $this->hasMany(Transaksi::class, 'kategori_keuangan_id');
    }
}