<?php
// database/migrations/2026_01_01_000003_create_books_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('categories')->onDelete('cascade');
            $table->string('judul');
            $table->string('isbn')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('cover')->nullable(); // Path gambar cover
            $table->string('file_buku'); // Path file pdf/epub
            $table->enum('format', ['pdf', 'epub']);
            $table->string('genre')->nullable();
            $table->enum('jenis_akses', ['free', 'premium'])->default('free');
            $table->integer('minimal_usia')->default(0);
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('books');
    }
};