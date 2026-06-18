<?php
namespace App\Services;
 
use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
 
class BookService
{
    public function storeFile(UploadedFile $file, string $disk = 'public'): array
    {
        $mime   = $file->getMimeType();
        $folder = str_contains($mime, 'image') ? 'covers' : 'books';
        $format = str_contains($mime, 'epub') ? 'epub' : 'pdf';
 
        $path = $file->store($folder, $disk);
 
        return [
            'filename' => basename($path),
            'format'   => $format,
        ];
    }
 
    public function deleteFiles(Book $book): void
    {
        if ($book->cover) Storage::disk('public')->delete('covers/' . $book->cover);
        if ($book->file_buku) Storage::disk('public')->delete('books/' . $book->file_buku);
    }
}