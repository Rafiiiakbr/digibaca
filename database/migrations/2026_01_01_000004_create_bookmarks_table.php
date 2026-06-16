<?php
// database/migrations/2026_01_01_000004_create_bookmarks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('halaman'); // String karena epub menggunakan sistem CFI, sedangkan PDF angka.
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bookmarks');
    }
};