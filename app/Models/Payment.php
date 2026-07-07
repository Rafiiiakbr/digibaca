<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model 
{
    protected $fillable = ['user_id', 'order_id', 'nominal', 'status', 'snap_token', 'payment_type', 'tanggal_bayar'];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
}