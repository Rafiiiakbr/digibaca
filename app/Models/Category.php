<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- 1. Kita tambahkan ini
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; // <-- 2. Kita pasang ini di dalam class

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'kategori_id');
    }

    public function verifiedBooks()
    {
        return $this->hasMany(Book::class, 'kategori_id')
            ->where('status_verifikasi', 'verified');
    }
}