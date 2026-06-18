<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'kategori_id',
        'judul',
        'isbn',
        'deskripsi',
        'cover',
        'file_buku',
        'format',
        'genre',
        'penerbit',
        'tahun_terbit',
        'jumlah_halaman',
        'bahasa',
        'jenis_akses',
        'minimal_usia',
        'status_verifikasi',
        'alasan_penolakan',
        'views',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'jumlah_halaman' => 'integer',
        'minimal_usia' => 'integer',
        'views' => 'integer',
    ];

    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', 'verified');
    }

    public function scopeFree($query)
    {
        return $query->where('jenis_akses', 'gratis');
    }

    public function scopePremium($query)
    {
        return $query->where('jenis_akses', 'premium');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover) {
            return asset('storage/covers/' . $this->cover);
        }

        return asset('assets/images/no-cover.png');
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/books/' . $this->file_buku);
    }

    public function isAccessible(?User $user = null): bool
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return $this->jenis_akses === 'gratis';
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($this->minimal_usia > 0 && $user->getAge() < $this->minimal_usia) {
            return false;
        }

        if ($this->jenis_akses === 'premium' && !$user->isPremium()) {
            return false;
        }

        return true;
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }

    public function collectors()
    {
        return $this->belongsToMany(User::class, 'collections');
    }
}