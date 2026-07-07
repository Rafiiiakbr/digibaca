<?php

namespace App\Http\Middleware;

use App\Models\Book;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PremiumMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $bookId = $request->route('book') instanceof Book
            ? $request->route('book')->id
            : $request->route('book');

        $book = Book::findOrFail($bookId);
        $user = $request->user();

        if ($book->jenis_akses === 'premium' && (!$user || !$user->isPremium())) {

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Konten premium. Silakan upgrade akun Anda.'
                ], 403);
            }

            return redirect()
                ->route('premium.upgrade')
                ->with('info', 'Buku ini hanya untuk member premium. Upgrade sekarang!');
        }

        return $next($request);
    }
}