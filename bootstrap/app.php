<?php
/*
|=============================================================
| FILE LENGKAP (BUKAN CUPLIKAN): bootstrap/app.php
| Ini WAJIB ditimpa utuh — sebelumnya hanya ditulis sebagai
| komentar di dalam 10_POLICIES_CONFIG.php. Salin file ini
| utuh ke bootstrap/app.php proyek Laravel 12 Anda.
|=============================================================
*/

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\PremiumMiddleware;
use App\Http\Middleware\AgeVerificationMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'       => RoleMiddleware::class,
            'premium'    => PremiumMiddleware::class,
            'age_verify' => AgeVerificationMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom error pages akan otomatis dipakai oleh Laravel
        // selama file resources/views/errors/{403,404,500}.blade.php ada.
        // Tidak perlu konfigurasi tambahan untuk itu.
    })->create();