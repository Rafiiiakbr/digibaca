<?php
namespace App\Http\Controllers\Reader;
 
use App\Http\Controllers\Controller;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class ReadingHistoryController extends Controller
{
    public function index()
    {
        $history = Auth::user()->readingHistories()
            ->with('book.author')
            ->orderByDesc('updated_at')
            ->paginate(12);
 
        return view('reader.history', compact('history'));
    }
 
    public function updateProgress(Request $request)
    {
        $request->validate([
            'book_id'         => ['required', 'exists:books,id'],
            'halaman_terakhir' => ['required', 'integer', 'min:1'],
            'cfi_terakhir'    => ['nullable', 'string'],
        ]);
 
        ReadingHistory::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $request->book_id],
            [
                'halaman_terakhir' => $request->halaman_terakhir,
                'cfi_terakhir'     => $request->cfi_terakhir,
                'updated_at'       => now(),
            ]
        );
 
        return response()->json(['success' => true]);
    }
}