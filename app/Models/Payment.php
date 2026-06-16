<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model 
{
    protected $fillable = ['user_id', 'nominal', 'status', 'tanggal_bayar'];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
}