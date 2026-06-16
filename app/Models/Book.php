<?php

namespace App\Models;

// 1. Kita masukkan import HasFactory di sini
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model 
{
    // 2. Kita aktifkan HasFactory di dalam class
    use HasFactory;

    // Tetap pertahankan struktur kolom asli database kamu agar tidak error saat seeding
    protected $fillable = [
        'author_id', 'kategori_id', 'judul', 'isbn', 'deskripsi', 
        'cover', 'file_buku', 'format', 'genre', 'jenis_akses', 
        'minimal_usia', 'status_verifikasi'
    ];

    // Hubungan relasi asli dari database kamu
    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }
}