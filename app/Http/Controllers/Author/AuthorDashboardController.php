<?php
namespace App\Http\Controllers\Author;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
 
class AuthorDashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $books = $user->books()->with('category')->latest()->get();
 
        $stats = [
            'total'    => $books->count(),
            'verified' => $books->where('status_verifikasi', 'verified')->count(),
            'pending'  => $books->where('status_verifikasi', 'pending')->count(),
            'rejected' => $books->where('status_verifikasi', 'rejected')->count(),
            'views'    => $books->sum('views'),
        ];
 
        $recentBooks = $books->take(5);
 
        // UBAH BARIS COMPACT DI BAWAH INI:
        // Kita daftarkan juga nama variabel 'my_books' yang isinya mengambil dari $recentBooks atau $books
        return view('author.dashboard', [
            'user'        => $user,
            'stats'       => $stats,
            'recentBooks' => $recentBooks,
            'my_books'    => $books // <-- Kita tambahkan ini agar view tidak error lagi!
        ]);
    }
}
