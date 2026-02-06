<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Dashboard\{
    DashboardController, 
    UserController, 
    TransaksiController, 
    KategoriKeuanganController, 
    AkunKeuanganController
};

// Landing Page
Route::get('/', function () { return view('welcome'); });

// Laravel Auth Routes (Login, Register, dsb)
Auth::routes();

// Redirect setelah login
Route::get('/home', function () {
    return redirect()->route('dashboard.index');
});

// ======================
// DASHBOARD GROUP
// ======================
Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware('auth')
    ->group(function () {

    // Akses SEMUA USER (Admin & Member)
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('akun-keuangan', AkunKeuanganController::class);

    // Akses KHUSUS ADMIN
    // Kita gunakan middleware 'can:admin-only'
    Route::middleware('can:admin-only')->group(function () {
        Route::resource('kategori-keuangan', KategoriKeuanganController::class);
        Route::resource('users', UserController::class);
    });

    // Logout yang lebih aman
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});