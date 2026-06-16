<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    // --- FITUR BOOKMARK ---
    public function getBookmark($book_id)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())
                            ->where('book_id', $book_id)
                            ->first();

        return response()->json([
            'success' => true,
            'halaman' => $bookmark ? $bookmark->halaman : 1
        ]);
    }

    public function saveBookmark(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'halaman' => 'required|integer|min:1'
        ]);

        // Update jika sudah ada, buat baru jika belum ada posisi tersimpan
        $bookmark = Bookmark::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $request->book_id],
            ['halaman' => $request->halaman]
        );

        return response()->json([
            'success' => true,
            'message' => 'Posisi membaca berhasil disinkronisasi.',
            'data' => $bookmark
        ]);
    }

    // --- FITUR CATATAN PRIBADI ---
    public function getNotes($book_id)
    {
        $notes = Note::where('user_id', Auth::id())
                     ->where('book_id', $book_id)
                     ->orderBy('created_at', 'desc')
                     ->get();

        return response()->json([
            'success' => true,
            'data' => $notes
        ]);
    }

    public function saveNote(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'isi_catatan' => 'required|string|max:1000'
        ]);

        $note = Note::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'isi_catatan' => $request->isi_catatan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil ditambahkan.',
            'data' => $note
        ]);
    }

    public function deleteNote($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil dihapus.'
        ]);
    }
}