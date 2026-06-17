<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Auth::user()
            ->bookmarks()
            ->with('book')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('reader.bookmarks', compact('bookmarks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'halaman' => ['required', 'integer', 'min:1'],
            'judul_halaman' => ['nullable', 'string', 'max:255'],
            'cfi_position' => ['nullable', 'string'],
        ]);

        $bookmark = Bookmark::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
                'halaman' => $request->halaman,
            ],
            [
                'judul_halaman' => $request->judul_halaman,
                'cfi_position' => $request->cfi_position,
                'created_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Bookmark berhasil disimpan.',
            'bookmark' => $bookmark,
        ]);
    }

    public function destroy(Bookmark $bookmark)
    {
        $this->authorize('delete', $bookmark);

        $bookmark->delete();

        return request()->expectsJson()
            ? response()->json([
                'success' => true,
                'message' => 'Bookmark dihapus.',
            ])
            : back()->with(
                'success',
                'Bookmark berhasil dihapus.'
            );
    }
}