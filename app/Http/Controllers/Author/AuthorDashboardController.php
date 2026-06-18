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
 
        return view('author.dashboard', compact('user', 'stats', 'recentBooks'));
    }
}
