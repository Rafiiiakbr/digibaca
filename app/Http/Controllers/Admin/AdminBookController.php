<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class AdminBookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['author', 'category'])->latest();
 
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }
 
        $books = $query->paginate(15);
        return view('admin.books.index', compact('books'));
    }
 
    public function verify(Book $book, Request $request)
    {
        $request->validate([
            'action'           => ['required', 'in:verified,rejected'],
            'alasan_penolakan' => ['required_if:action,rejected', 'nullable', 'string'],
        ]);
 
        $book->update([
            'status_verifikasi' => $request->action,
            'alasan_penolakan'  => $request->action === 'rejected' ? $request->alasan_penolakan : null,
        ]);
 
        $msg = $request->action === 'verified' ? 'Buku berhasil diverifikasi.' : 'Buku ditolak.';
        return redirect()->route('admin.books.index')->with('success', $msg);
    }
 
    public function destroy(Book $book)
    {
        Storage::disk('public')->delete(['covers/' . $book->cover, 'books/' . $book->file_buku]);
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}