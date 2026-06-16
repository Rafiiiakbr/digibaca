<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function dashboard()
    {
        $authorId = Auth::id();

        // Statistik buku milik penulis yang sedang login
        $data['total_buku_saya'] = Book::where('author_id', $authorId)->count();
        $data['buku_diverifikasi'] = Book::where('author_id', $authorId)->where('status_verifikasi', 'verified')->count();
        $data['buku_menunggu'] = Book::where('author_id', $authorId)->where('status_verifikasi', 'pending')->count();
        $data['buku_ditolak'] = Book::where('author_id', $authorId)->where('status_verifikasi', 'rejected')->count();

        // List buku terbaru milik penulis
        $data['my_books'] = Book::where('author_id', $authorId)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('author.dashboard', $data);
    }
}