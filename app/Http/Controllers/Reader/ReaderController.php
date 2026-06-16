<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class ReaderController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        // 1. Ambil 4 Buku Terbaru yang sudah terverifikasi admin
        $data['buku_terbaru'] = Book::where('status_verifikasi', 'verified')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // 2. Ambil Rekomendasi Buku (Berdasarkan genre/kategori acak dari sistem)
        $data['buku_rekomendasi'] = Book::where('status_verifikasi', 'verified')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 3. Bookmark Terakhir dari User
        $data['last_bookmarks'] = Bookmark::where('user_id', $userId)
            ->with('book')
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        // 4. Catatan (Notes) Terakhir User
        $data['last_notes'] = Note::where('user_id', $userId)
            ->with('book')
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return view('reader.dashboard', $data);
    }
}