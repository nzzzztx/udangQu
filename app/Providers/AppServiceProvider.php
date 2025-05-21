<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Tempat mendaftarkan service container binding atau third-party services
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set lokal dan timezone default aplikasi
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}