<?php
namespace App\Http\Controllers\Reader;
 
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class CollectionController extends Controller
{
    public function index()
    {
        $books = Auth::user()->collectedBooks()
            ->verified()
            ->with(['author', 'category'])
            ->paginate(12);
 
        return view('reader.collection', compact('books'));
    }
 
    public function toggle(Request $request)
    {
        $request->validate(['book_id' => ['required', 'exists:books,id']]);
 
        $user   = Auth::user();
        $bookId = $request->book_id;
 
        $existing = Collection::where('user_id', $user->id)
            ->where('book_id', $bookId)->first();
 
        if ($existing) {
            $existing->delete();
            $added = false;
            $message = 'Buku dihapus dari koleksi.';
        } else {
            Collection::create(['user_id' => $user->id, 'book_id' => $bookId]);
            $added = true;
            $message = 'Buku ditambahkan ke koleksi!';
        }
 
        return response()->json(['success' => true, 'added' => $added, 'message' => $message]);
    }
}