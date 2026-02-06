<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Import class yang diperlukan
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate; 
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Memastikan Pagination menggunakan styling Tailwind CSS
        Paginator::useTailwind();

        // 2. Antisipasi error saat migrasi database
        Schema::defaultStringLength(191);

        // 3. Definisikan Gate untuk membatasi akses (Solusi Error 403)
        // Gate ini akan mengecek apakah kolom 'role' pada user adalah 'admin'
        Gate::define('admin-only', function (User $user) {
            return $user->role === 'admin';
        });
    }
}