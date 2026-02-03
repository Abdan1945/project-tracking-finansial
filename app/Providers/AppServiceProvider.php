<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Import dua class ini di bagian atas
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

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

        // 2. Antisipasi error saat migrasi database (opsional tapi sangat disarankan)
        Schema::defaultStringLength(191);
    }
}