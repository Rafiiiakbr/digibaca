<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAgeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $bookId = $request->route('id');
        $book = Book::findOrFail($bookId);

        if ($book->minimal_usia > 0) {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Konten ini memerlukan verifikasi usia. Silakan login.');
            }

            if (Auth::user()->usia < $book->minimal_usia) {
                return redirect()->route('reader.dashboard')->with('error', 'Maaf, konten ini hanya untuk pengguna berusia ' . $book->minimal_usia . ' tahun ke atas.');
            }
        }

        return $next($request);
    }
}