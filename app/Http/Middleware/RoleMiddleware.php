<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak punya akses, arahkan sesuai role masing-masing atau ke halaman default
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            'author' => redirect()->route('author.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            default => redirect()->route('reader.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
        };
    }
}