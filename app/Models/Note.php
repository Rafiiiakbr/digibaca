<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model 
{
    protected $fillable = ['user_id', 'book_id', 'isi_catatan'];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    public function book() 
    { 
        return $this->belongsTo(Book::class); 
    }
}