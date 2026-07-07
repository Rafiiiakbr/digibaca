<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Menggabungkan field Midtrans dan Transfer Manual agar aman dari Mass Assignment
    protected $fillable = [
        'user_id',
        'order_id',
        'nominal',
        'status',
        'snap_token',
        'payment_type',
        'metode',
        'kode_pembayaran',
        'bukti_transfer',
        'catatan_admin',
        'tanggal_bayar',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function confirm(): void
    {
        $this->update([
            'status' => 'confirmed',
            'tanggal_bayar' => now(),
        ]);

        $this->user->update([
            'status_premium' => true,
        ]);
    }

    public function reject(string $catatan = ''): void
    {
        $this->update([
            'status' => 'rejected',
            'catatan_admin' => $catatan,
        ]);
    }

    public static function generateKodePembayaran(): string
    {
        return 'DIGIBACA-' . strtoupper(uniqid());
    }
}