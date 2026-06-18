<?php
namespace App\Services;
 
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Collection;
 
class RecommendationService
{
    /**
     * Get related books by same category or genre
     */
    public function getRelated(Book $book, int $limit = 6): Collection
    {
        return Book::verified()
            ->where('id', '!=', $book->id)
            ->where(function ($q) use ($book) {
                $q->where('kategori_id', $book->kategori_id)
                  ->orWhere('genre', $book->genre);
            })
            ->with(['author', 'category'])
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
 
    /**
     * Personalized recommendations for a user
     */
    public function forUser(User $user, int $limit = 8): Collection
    {
        // Get categories/genres from reading history
        $readBookIds = $user->readingHistories()->pluck('book_id');
 
        if ($readBookIds->isEmpty()) {
            // New user: return latest books
            return Book::verified()
                ->with(['author', 'category'])
                ->latest()
                ->limit($limit)
                ->get();
        }
 
        $readBooks     = Book::whereIn('id', $readBookIds)->get();
        $categoryIds   = $readBooks->pluck('kategori_id')->unique();
        $genres        = $readBooks->pluck('genre')->unique()->filter();
 
        return Book::verified()
            ->whereNotIn('id', $readBookIds)
            ->where(function ($q) use ($categoryIds, $genres) {
                $q->whereIn('kategori_id', $categoryIds)
                  ->orWhereIn('genre', $genres);
            })
            ->with(['author', 'category'])
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}