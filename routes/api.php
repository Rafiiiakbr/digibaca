<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reader\{BookmarkController, NoteController, ReadingHistoryController};
 
Route::middleware('auth:sanctum')->prefix('v1')->name('api.')->group(function () {
    Route::post('/bookmark',               [BookmarkController::class, 'store'])->name('bookmark.store');
    Route::delete('/bookmark/{bookmark}',  [BookmarkController::class, 'destroy'])->name('bookmark.destroy');
 
    Route::post('/note',                   [NoteController::class, 'store'])->name('note.store');
    Route::put('/note/{note}',             [NoteController::class, 'update'])->name('note.update');
    Route::delete('/note/{note}',          [NoteController::class, 'destroy'])->name('note.destroy');
 
    Route::post('/progress',               [ReadingHistoryController::class, 'updateProgress'])->name('progress');
});