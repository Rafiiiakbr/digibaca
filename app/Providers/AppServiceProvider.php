<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Paksa HTTPS hanya di server produksi agar aset CSS/JS termuat dengan aman
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}