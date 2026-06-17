<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\{User, Book, Payment, Category};
 
class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::count(),
            'total_readers'  => User::where('role', 'reader')->count(),
            'total_authors'  => User::where('role', 'author')->count(),
            'total_books'    => Book::count(),
            'pending_books'  => Book::where('status_verifikasi', 'pending')->count(),
            'verified_books' => Book::where('status_verifikasi', 'verified')->count(),
            'total_premium'  => User::where('status_premium', true)->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_revenue'  => Payment::where('status', 'confirmed')->sum('nominal'),
        ];
 
        $recentUsers    = User::latest()->take(5)->get();
        $pendingBooks   = Book::with(['author', 'category'])
            ->where('status_verifikasi', 'pending')->latest()->take(5)->get();
        $recentPayments = Payment::with('user')
            ->where('status', 'pending')->latest()->take(5)->get();
        $categories     = Category::withCount('verifiedBooks')->get();
 
        return view('admin.dashboard', compact(
            'stats', 'recentUsers', 'pendingBooks', 'recentPayments', 'categories'
        ));
    }
}