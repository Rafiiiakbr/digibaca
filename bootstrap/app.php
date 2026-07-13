<?php

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\PremiumMiddleware;
use App\Http\Middleware\AgeVerificationMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\URL;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan proxy tepercaya agar Laravel tahu koneksi aslinya adalah HTTPS
        $middleware->trustProxies(at: '*');

        // Mendaftarkan alias middleware agar rute web.php bisa mengenalnya
        $middleware->alias([
            'role'       => RoleMiddleware::class,
            'premium'    => PremiumMiddleware::class,
            'age_verify' => AgeVerificationMiddleware::class,
        ]);

        // Mengecualikan rute webhook Midtrans dari proteksi CSRF token agar tidak error 419
        $middleware->validateCsrfTokens(except: [
            'payment/notification',
        ]);

        // Gunakan env() agar tidak bentrok saat config:cache berjalan
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();