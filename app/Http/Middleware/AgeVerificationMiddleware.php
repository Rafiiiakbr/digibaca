<?php

namespace App\Http\Middleware;

use App\Models\Book;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeVerificationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $book = $request->route('book') instanceof Book
            ? $request->route('book')
            : Book::findOrFail($request->route('book'));

        $user = $request->user();

        if ($book->minimal_usia > 0 && $user) {

            $userAge = $user->getAge();

            if ($userAge < $book->minimal_usia) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => "Konten ini membutuhkan usia minimal {$book->minimal_usia} tahun."
                    ], 403);
                }

                return back()->with(
                    'error',
                    "Maaf, konten ini hanya untuk pengguna berusia {$book->minimal_usia} tahun ke atas."
                );
            }
        }

        return $next($request);
    }
}