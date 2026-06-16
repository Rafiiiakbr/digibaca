<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Payment;
use Illuminate\Http\Request; // <-- Menambahkan import Request agar proses verifikasi tidak error
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Mengambil statistik global untuk card dashboard
        $data['total_user'] = User::where('role', 'reader')->count();
        $data['total_author'] = User::where('role', 'author')->count();
        $data['total_buku'] = Book::count();
        $data['total_premium_user'] = User::where('status_premium', true)->count();

        // Statistik Buku berdasarkan status verifikasi
        $data['buku_pending'] = Book::where('status_verifikasi', 'pending')->count();
        $data['buku_verified'] = Book::where('status_verifikasi', 'verified')->count();

        // Total pendapatan dari simulasi payment yang sukses
        $data['total_pendapatan'] = Payment::where('status', 'success')->sum('nominal');

        // Mengambil 5 transaksi premium terbaru beserta relasi user-nya
        $data['recent_payments'] = Payment::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', $data);
    }

    // Menampilkan semua buku yang masuk ke sistem
    public function manageBooks()
    {
        $books = Book::with(['author', 'category'])->orderBy('status_verifikasi', 'asc')->get();
        return view('admin.books', compact('books'));
    }

    // Memproses persetujuan atau penolakan buku
    public function verifyBook(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $book = Book::findOrFail($id);
        $book->status_verifikasi = $request->status;
        $book->save();

        return redirect()->back()->with('success', 'Status verifikasi buku "' . $book->judul . '" berhasil diperbarui.');
    }
}