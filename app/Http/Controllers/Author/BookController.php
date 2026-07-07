<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Dashboard penulis — statistik & buku terbaru.
     */
    public function dashboard()
    {
        $authorId = Auth::id();

        $data['total_buku_saya']   = Book::where('author_id', $authorId)->count();
        $data['buku_diverifikasi'] = Book::where('author_id', $authorId)->where('status_verifikasi', 'verified')->count();
        $data['buku_menunggu']     = Book::where('author_id', $authorId)->where('status_verifikasi', 'pending')->count();
        $data['buku_ditolak']      = Book::where('author_id', $authorId)->where('status_verifikasi', 'rejected')->count();

        $data['my_books'] = Book::where('author_id', $authorId)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('author.dashboard', $data);
    }

    /**
     * Tampilkan daftar semua buku milik penulis.
     */
    public function index()
    {
        $books = Book::where('author_id', Auth::id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('author.books.index', compact('books'));
    }

    /**
     * Tampilkan form upload buku baru.
     */
    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();
        return view('author.books.create', compact('categories'));
    }

    /**
     * Simpan buku baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'isbn'        => 'nullable|string|max:30',
            'deskripsi'   => 'nullable|string',
            'genre'       => 'nullable|string|max:100',
            'format'      => 'required|in:pdf,epub',
            'jenis_akses' => 'required|in:free,premium',
            'minimal_usia'=> 'required|integer|min:0|max:100',
            'cover'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'file_buku'   => 'required|file|mimes:pdf,epub|max:51200',
        ]);

        // Simpan file cover & file buku ke storage
        $coverPath    = $request->file('cover')->store('covers', 'public');
        $fileBukuPath = $request->file('file_buku')->store('books', 'public');

        Book::create([
            'author_id'        => Auth::id(),
            'kategori_id'      => $validated['kategori_id'],
            'judul'            => $validated['judul'],
            'isbn'             => $validated['isbn'] ?? null,
            'deskripsi'        => $validated['deskripsi'] ?? null,
            'genre'            => $validated['genre'] ?? null,
            'format'           => $validated['format'],
            'jenis_akses'      => $validated['jenis_akses'],
            'minimal_usia'     => $validated['minimal_usia'],
            'cover'            => $coverPath,
            'file_buku'        => $fileBukuPath,
            'status_verifikasi'=> 'pending',
        ]);

        return redirect()->route('author.books.index')
            ->with('success', 'Buku berhasil diajukan dan sedang menunggu verifikasi admin.');
    }

    /**
     * Tampilkan form edit buku.
     */
    public function edit($id)
    {
        $book = Book::where('author_id', Auth::id())->findOrFail($id);
        $categories = Category::orderBy('nama_kategori')->get();

        return view('author.books.edit', compact('book', 'categories'));
    }

    /**
     * Perbarui data buku yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $book = Book::where('author_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'isbn'        => 'nullable|string|max:30',
            'deskripsi'   => 'nullable|string',
            'genre'       => 'nullable|string|max:100',
            'format'      => 'required|in:pdf,epub',
            'jenis_akses' => 'required|in:free,premium',
            'minimal_usia'=> 'required|integer|min:0|max:100',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_buku'   => 'nullable|file|mimes:pdf,epub|max:51200',
        ]);

        // Ganti cover jika ada file baru
        if ($request->hasFile('cover')) {
            Storage::disk('public')->delete($book->cover);
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Ganti file buku jika ada file baru
        if ($request->hasFile('file_buku')) {
            Storage::disk('public')->delete($book->file_buku);
            $validated['file_buku'] = $request->file('file_buku')->store('books', 'public');
        }

        // Reset ke pending jika isi konten berubah
        $validated['status_verifikasi'] = 'pending';

        $book->update($validated);

        return redirect()->route('author.books.index')
            ->with('success', 'Buku berhasil diperbarui dan diajukan ulang untuk verifikasi.');
    }

    /**
     * Hapus buku milik penulis.
     */
    public function destroy($id)
    {
        $book = Book::where('author_id', Auth::id())->findOrFail($id);

        // Hapus file dari storage
        Storage::disk('public')->delete($book->cover);
        Storage::disk('public')->delete($book->file_buku);

        $book->delete();

        return redirect()->route('author.books.index')
            ->with('success', 'Buku berhasil dihapus dari sistem.');
    }
}