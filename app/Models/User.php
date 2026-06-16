<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = ['nama', 'email', 'password', 'role', 'tanggal_lahir', 'status_premium'];
    protected $hidden = ['password', 'remember_token'];

    // Menghitung umur user secara dinamis
    public function getUmurAttribute() {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function books() {
        return $this->hasMany(Book::class, 'author_id');
    }

    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}