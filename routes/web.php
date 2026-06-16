<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Author\BookController;
use App\Http\Controllers\Reader\ReaderController;

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
    // ROLE: ADMIN (Semua Fitur Admin Disatukan di Sini)
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
        Route::get('/dashboard', [BookController::class, 'dashboard'])->name('dashboard');
        // Fitur CRUD Buku milik Author akan ditaruh di sini...
    });

    //------------------------------------------
    // ROLE: READER
    //------------------------------------------
    Route::middleware('role:reader')->prefix('reader')->name('reader.')->group(function () {
        Route::get('/dashboard', [ReaderController::class, 'dashboard'])->name('dashboard');
        // Fitur membaca, bookmark, notes, dan payment premium ditaruh di sini...
    });
});