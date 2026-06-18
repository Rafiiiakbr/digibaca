<?php
namespace App\Http\Controllers\Reader;
 
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class NoteController extends Controller
{
    public function index()
    {
        $notes = Auth::user()->notes()
            ->with('book')
            ->orderByDesc('updated_at')
            ->paginate(15);
 
        return view('reader.notes', compact('notes'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'book_id'     => ['required', 'exists:books,id'],
            'halaman'     => ['nullable', 'integer', 'min:1'],
            'isi_catatan' => ['required', 'string', 'max:2000'],
        ]);
 
        $note = Note::create([
            'user_id'     => Auth::id(),
            'book_id'     => $request->book_id,
            'halaman'     => $request->halaman,
            'isi_catatan' => $request->isi_catatan,
        ]);
 
        return response()->json(['success' => true, 'note' => $note->load('book')]);
    }
 
    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);
        $request->validate(['isi_catatan' => ['required', 'string', 'max:2000']]);
        $note->update(['isi_catatan' => $request->isi_catatan]);
 
        return response()->json(['success' => true, 'note' => $note]);
    }
 
    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        $note->delete();
 
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Catatan dihapus.');
    }
}