<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Mendaftarkan alias middleware agar bisa digunakan di routes
        $middleware->alias([
            'role'          => \App\Http\Middleware\RoleMiddleware::class,
            'check.premium' => \App\Http\Middleware\CheckPremiumMiddleware::class,
            'check.age'     => \App\Http\Middleware\CheckAgeMiddleware::class,
        ]);

        // Mengecualikan route webhook Midtrans dari validasi CSRF
        $middleware->validateCsrfTokens(except: [
            'payment/notification',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();