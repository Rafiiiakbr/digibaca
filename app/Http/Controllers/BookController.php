<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function __construct(
        private RecommendationService $recommendationService
    ) {}

    public function index(Request $request)
    {
        $query = Book::verified()
            ->with(['author', 'category'])
            ->latest();

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('genre', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }

        if ($request->filled('akses')) {
            $query->where('jenis_akses', $request->akses);
        }

        if ($request->filled('genre')) {
            $query->where('genre', 'like', "%{$request->genre}%");
        }

        $books = $query->paginate(12)->withQueryString();

        $categories = Category::withCount('verifiedBooks')->get();

        return view('public.catalog', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        abort_if($book->status_verifikasi !== 'verified', 404);

        $book->load(['author', 'category']);

        $book->incrementViews();

        $related = $this->recommendationService->getRelated($book, 4);

        $user = Auth::user();

        $inCollection = $user
            ? $user->collections()->where('book_id', $book->id)->exists()
            : false;

        return view(
            'public.book-detail',
            compact('book', 'related', 'inCollection')
        );
    }

    public function read(Book $book)
    {
        abort_if($book->status_verifikasi !== 'verified', 404);

        $user = Auth::user();
        $history = null;

        if ($user) {
            $history = $user->readingHistories()
                ->where('book_id', $book->id)
                ->first();
        }

        $view = $book->format === 'pdf'
            ? 'reader.pdf-reader'
            : 'reader.epub-reader';

        return view($view, compact('book', 'history'));
    }
}