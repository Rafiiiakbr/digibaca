<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('book_id')
                ->constrained()
                ->onDelete('cascade');

            $table->unsignedInteger('halaman')->default(1);
            $table->string('judul_halaman', 255)->nullable();
            $table->string('cfi_position', 500)->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->unique(['user_id', 'book_id', 'halaman']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};