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
        Schema::create('kategori_keuangan', function (Blueprint $table) {
            $table->id();
            // 1. Tambahkan kolom user_id agar sinkron dengan Controller
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // 2. Sesuaikan nama kolom dengan fillable di Model
            $table->string('nama_kategori'); 
            $table->enum('jenis', ['pemasukan', 'pengeluaran']); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_keuangan');
    }
};