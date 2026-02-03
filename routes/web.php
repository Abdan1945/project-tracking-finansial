<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\TransaksiController;
use App\Http\Controllers\Dashboard\KategoriKeuanganController;
use App\Http\Controllers\Dashboard\AkunKeuanganController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Auth
Auth::routes();

// Redirect setelah login (opsional, boleh hapus)
Route::get('/home', function () {
    return redirect()->route('dashboard.index');
});

// ======================
// DASHBOARD (AUTH)
// ======================
Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware('auth')
    ->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('index');

    // Transaksi (INTI)
    Route::resource('transaksi', TransaksiController::class);

    // Kategori Keuangan
    Route::resource('kategori-keuangan', KategoriKeuanganController::class);

    // Akun Keuangan (Rekening / Dompet)
    Route::resource('akun-keuangan', AkunKeuanganController::class);

    // Manajemen User
    Route::resource('users', UserController::class);

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});
