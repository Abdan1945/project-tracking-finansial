<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
    $table->id();
    $table->date('tanggal');
    $table->enum('jenis', ['pemasukan', 'pengeluaran']);
    $table->foreignId('kategori_id')->constrained('kategori_keuangan');
    $table->foreignId('akun_id')->constrained('akun_keuangan');
    $table->foreignId('user_id')->constrained('users');
    $table->decimal('jumlah', 15, 2);
    $table->text('keterangan')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
