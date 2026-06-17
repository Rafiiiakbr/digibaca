<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;

class ReaderDashboardController extends Controller
{
    public function __construct(
        private RecommendationService $recommendationService
    ) {}

    public function index()
    {
        $user = Auth::user();

        $recentHistory = $user->readingHistories()
            ->with('book.author')
            ->orderByDesc('updated_at')
            ->take(6)
            ->get();

        $bookmarks = $user->bookmarks()
            ->with('book')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $collection = $user->collectedBooks()
            ->verified()
            ->latest('collections.created_at')
            ->take(6)
            ->get();

        $recommendations = $this->recommendationService
            ->forUser($user, 8);

        return view('reader.dashboard', compact(
            'user',
            'recentHistory',
            'bookmarks',
            'collection',
            'recommendations'
        ));
    }
}