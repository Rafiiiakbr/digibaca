<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPremiumMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $bookId = $request->route('id');
        $book = Book::findOrFail($bookId);

        if ($book->jenis_akses === 'premium') {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Buku premium. Silakan login terlebih dahulu.');
            }

            // Admin dan Author pemilik buku dilewati dari aturan premium
            if (Auth::user()->role === 'admin' || Auth::user()->id === $book->author_id) {
                return $next($request);
            }

            if (!Auth::user()->status_premium) {
                return redirect()->route('reader.premium.index')->with('premium_required', 'Buku ini berstatus Premium. Silakan upgrade akun Anda untuk membaca.');
            }
        }

        return $next($request);
    }
}