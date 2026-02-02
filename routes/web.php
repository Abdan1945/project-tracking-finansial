<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Route Otentikasi
Auth::routes();

// Redirect setelah login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Grup Route Dashboard (Memerlukan Login)
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    
    // Route Utama Dashboard
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');
    
    // Resource untuk User Management
    Route::resource('users', App\Http\Controllers\Dashboard\UserController::class);

    // TAMBAHKAN INI: Resource untuk Kategori Keuangan
    // Pastikan kamu sudah punya KategoriController di App\Http\Controllers\
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);

    // (Opsional) Jika nanti butuh menu Rekening/Dompet
    // Route::resource('rekening', App\Http\Controllers\RekeningController::class);
});