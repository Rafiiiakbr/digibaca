<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\ProfileController;

// Controller Fitur Baru (Reader)
use App\Http\Controllers\Reader\{
    ReaderDashboardController, BookmarkController,
    NoteController, CollectionController, ReadingHistoryController
};

// Controller Fitur Baru (Author)
use App\Http\Controllers\Author\{AuthorDashboardController, AuthorBookController};

// Controller Fitur Baru (Admin)
use App\Http\Controllers\Admin\{
    AdminDashboardController, AdminBookController,
    AdminUserController, AdminCategoryController, AdminPremiumController
};

// Webhook Notification dari Midtrans (Public)
Route::post('/payment/notification', [PremiumController::class, 'notification'])->name('payment.notification');

// ── Public Routes ──────────────────────────────────────────
Route::get('/', fn() => view('public.landing'))->name('home');
Route::get('/katalog', [BookController::class, 'index'])->name('books.index');
Route::get('/buku/{book}', [BookController::class, 'show'])->name('books.show');
 
// ── Guest Routes (Sebelum Login) ────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ── Auth Routes (Harus Login) ───────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Fitur Lupa Password
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // ── Reader Routes ──────────────────────────────────────────
    Route::middleware('role:reader')->prefix('reader')->name('reader.')->group(function () {
        Route::get('/dashboard', [ReaderDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil',    [ProfileController::class, 'edit'])->name('profile');
        Route::put('/profil',    [ProfileController::class, 'update'])->name('profile.update');
     
        Route::get('/koleksi',   [CollectionController::class, 'index'])->name('collection');
        Route::post('/koleksi',  [CollectionController::class, 'toggle'])->name('collection.toggle');
     
        Route::get('/bookmark',  [BookmarkController::class, 'index'])->name('bookmarks');
        Route::post('/bookmark', [BookmarkController::class, 'store'])->name('bookmarks.store');
        Route::delete('/bookmark/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
     
        Route::get('/catatan',   [NoteController::class, 'index'])->name('notes');
        Route::post('/catatan',  [NoteController::class, 'store'])->name('notes.store');
        Route::put('/catatan/{note}',    [NoteController::class, 'update'])->name('notes.update');
        Route::delete('/catatan/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
     
        Route::get('/riwayat',   [ReadingHistoryController::class, 'index'])->name('history');
        Route::post('/progress', [ReadingHistoryController::class, 'updateProgress'])->name('progress.update');
    });
     
    // ── Book Read Routes (auth + premium + age check) ──────────
    Route::middleware(['premium', 'age_verify'])->group(function () {
        Route::get('/baca/{book}', [BookController::class, 'read'])->name('books.read');
    });
     
    // ── Premium Routes ─────────────────────────────────────────
    Route::prefix('premium')->name('premium.')->group(function () {
        Route::get('/upgrade', [PremiumController::class, 'upgrade'])->name('upgrade');
        Route::post('/bayar',  [PremiumController::class, 'pay'])->name('pay');
    });
     
    // ── Author Routes ──────────────────────────────────────────
    Route::middleware('role:author')->prefix('author')->name('author.')->group(function () {
        Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');
        
        // TAMBAHAN: Route profil untuk akun Author (Penulis)
        Route::get('/profil',    [ProfileController::class, 'edit'])->name('profile');
        Route::put('/profil',    [ProfileController::class, 'update'])->name('profile.update');
        
        Route::resource('/buku', AuthorBookController::class)->names([
            'index'   => 'books.index',
            'create'  => 'books.create',
            'store'   => 'books.store',
            'edit'    => 'books.edit',
            'update'  => 'books.update',
            'destroy' => 'books.destroy',
        ]);
    });
     
    // ── Admin Routes ───────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
     
        Route::get('/buku',            [AdminBookController::class, 'index'])->name('books.index');
        Route::post('/buku/{book}/verify', [AdminBookController::class, 'verify'])->name('books.verify');
        Route::delete('/buku/{book}',  [AdminBookController::class, 'destroy'])->name('books.destroy');
     
        Route::get('/user',            [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/user/{user}/premium', [AdminUserController::class, 'togglePremium'])->name('users.toggle-premium');
        Route::delete('/user/{user}',  [AdminUserController::class, 'destroy'])->name('users.destroy');
     
        Route::get('/kategori',        [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/kategori',       [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::put('/kategori/{category}',    [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/kategori/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
     
        Route::get('/premium',         [AdminPremiumController::class, 'index'])->name('premium.index');
        Route::post('/premium/{payment}/confirm', [AdminPremiumController::class, 'confirm'])->name('premium.confirm');
        Route::post('/premium/{payment}/reject',  [AdminPremiumController::class, 'reject'])->name('premium.reject');
    });
});