<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Author\BookController;
use App\Http\Controllers\Reader\ReaderController;
use App\Http\Controllers\Reader\InteractionController;

// Webhook Notification dari Midtrans (Public)
Route::post('/payment/notification', [ReaderController::class, 'notification'])->name('payment.notification');

// ==========================================
// GUEST ROUTES (Sebelum Login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Landing page umum
    Route::get('/', function () {
        return view('public.landing');
    })->name('landing');
});

// ==========================================
// AUTH ROUTES (Harus Login)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //------------------------------------------
    // ROLE: ADMIN
    //------------------------------------------
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manajemen & Verifikasi Buku oleh Admin
        Route::get('/books', [AdminController::class, 'manageBooks'])->name('books.index');
        Route::patch('/books/{id}/verify', [AdminController::class, 'verifyBook'])->name('books.verify');
    });

    //------------------------------------------
    // ROLE: AUTHOR
    //------------------------------------------
    Route::middleware('role:author')->prefix('author')->name('author.')->group(function () {
        // Dashboard Penulis
        Route::get('/dashboard', [BookController::class, 'dashboard'])->name('dashboard');

        // CRUD Buku Penulis
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    //------------------------------------------
    // ROLE: READER
    //------------------------------------------
    Route::middleware('role:reader')->prefix('reader')->name('reader.')->group(function () {
        // Dashboard Pembaca
        Route::get('/dashboard', [ReaderController::class, 'dashboard'])->name('dashboard');

        // Membaca Buku (dilindungi middleware check.premium)
        Route::get('/read/{id}', [ReaderController::class, 'read'])
            ->middleware('check.premium')
            ->name('read');

        // Halaman Premium (Upgrade Akun)
        Route::get('/premium', [ReaderController::class, 'premiumPage'])->name('premium.index');
        Route::post('/premium/checkout', [ReaderController::class, 'checkout'])->name('premium.checkout');

        // API Bookmark (dipanggil via AJAX dari halaman baca)
        Route::get('/bookmark/{book_id}', [InteractionController::class, 'getBookmark'])->name('bookmark.get');
        Route::post('/bookmark', [InteractionController::class, 'saveBookmark'])->name('bookmark.save');

        // API Catatan Pribadi (dipanggil via AJAX dari halaman baca)
        Route::get('/notes/{book_id}', [InteractionController::class, 'getNotes'])->name('notes.get');
        Route::post('/notes', [InteractionController::class, 'saveNote'])->name('notes.save');
        Route::delete('/notes/{id}', [InteractionController::class, 'deleteNote'])->name('notes.delete');
    });
});