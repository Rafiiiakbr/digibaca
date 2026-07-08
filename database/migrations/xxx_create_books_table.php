<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('author_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('kategori_id')
                ->constrained('categories')
                ->onDelete('restrict');

            $table->string('judul', 255);
            $table->string('isbn', 20)->unique()->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('cover')->nullable();
            $table->string('file_buku', 255);
            $table->enum('format', ['pdf', 'epub']);
            $table->string('genre', 100)->nullable();
            $table->string('penerbit', 150)->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->string('bahasa', 50)->default('Indonesia');

            $table->enum('jenis_akses', ['gratis', 'premium'])
                ->default('gratis');

            $table->unsignedTinyInteger('minimal_usia')->default(0);

            $table->enum('status_verifikasi', [
                'pending',
                'verified',
                'rejected'
            ])->default('pending');

            $table->text('alasan_penolakan')->nullable();
            $table->unsignedBigInteger('views')->default(0);

            $table->timestamps();

            $table->index(['status_verifikasi', 'jenis_akses']);
            $table->index(['kategori_id', 'genre']);
            
            // Dinonaktifkan karena SQLite tidak mendukung index fullText bawaan Laravel
            // $table->fullText(['judul', 'deskripsi', 'genre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};