<?php

namespace App\Http\Controllers\Author;
 
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// TAMBAHAN: Mengimport Gate untuk otorisasi modern
use Illuminate\Support\Facades\Gate;
 
class AuthorBookController extends Controller
{
    public function index()
    {
        $books = Auth::user()->books()
            ->with('category')
            ->latest()
            ->paginate(10);
 
        return view('author.books.index', compact('books'));
    }
 
    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();
        return view('author.books.create', compact('categories'));
    }
 
    public function store(StoreBookRequest $request)
    {
        $coverPath    = $request->file('cover')->store('covers', 'public');
        $filePath     = $request->file('file_buku')->store('books', 'public');
 
        // Detect format from mime
        $mime   = $request->file('file_buku')->getMimeType();
        $format = str_contains($mime, 'epub') ? 'epub' : 'pdf';
 
        Book::create([
            ...$request->validated(),
            'author_id'         => Auth::id(),
            'cover'             => basename($coverPath),
            'file_buku'         => basename($filePath),
            'format'            => $format,
            'status_verifikasi' => 'pending',
        ]);
 
        return redirect()->route('author.books.index')
            ->with('success', 'Buku berhasil diupload dan sedang menunggu verifikasi admin.');
    }
 
    public function edit(Book $book)
    {
        // PERUBAHAN: Menggunakan Gate::authorize
        Gate::authorize('update', $book);
        
        $categories = Category::orderBy('nama_kategori')->get();
        return view('author.books.edit', compact('book', 'categories'));
    }
 
    public function update(UpdateBookRequest $request, Book $book)
    {
        // PERUBAHAN: Menggunakan Gate::authorize
        Gate::authorize('update', $book);
 
        $data = $request->validated();
 
        if ($request->hasFile('cover')) {
            Storage::disk('public')->delete('covers/' . $book->cover);
            $data['cover'] = basename($request->file('cover')->store('covers', 'public'));
        }
 
        if ($request->hasFile('file_buku')) {
            Storage::disk('public')->delete('books/' . $book->file_buku);
            $filePath = $request->file('file_buku')->store('books', 'public');
            $mime     = $request->file('file_buku')->getMimeType();
            $data['file_buku'] = basename($filePath);
            $data['format']    = str_contains($mime, 'epub') ? 'epub' : 'pdf';
        }
 
        // Reset to pending if metadata changes are significant
        $data['status_verifikasi'] = 'pending';
 
        $book->update($data);
 
        return redirect()->route('author.books.index')
            ->with('success', 'Buku berhasil diperbarui dan akan diverifikasi ulang.');
    }
 
    public function destroy(Book $book)
    {
        // PERUBAHAN: Menggunakan Gate::authorize
        Gate::authorize('delete', $book);
 
        Storage::disk('public')->delete(['covers/' . $book->cover, 'books/' . $book->file_buku]);
        $book->delete();
 
        return redirect()->route('author.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}