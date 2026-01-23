<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahkan ini jika Auth tidak terbaca

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Route Otentikasi (Login, Register, Logout, dll)
Auth::routes();

// Redirect setelah login biasanya ke sini
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Grup Route Dashboard (Memerlukan Login)
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');
    Route::resource('users', App\Http\Controllers\Dashboard\UserController::class);

});
