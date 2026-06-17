<?php
/*
|=============================================================
| FILE: routes/console.php
|=============================================================
*/

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Custom artisan command (opsional) — bersihkan payment pending lebih dari 7 hari
Artisan::command('digibaca:clean-payments', function () {
    $deleted = \App\Models\Payment::where('status', 'pending')
        ->where('created_at', '<', now()->subDays(7))
        ->delete();
    $this->info("Berhasil membersihkan {$deleted} pembayaran pending yang sudah kedaluwarsa.");
})->purpose('Hapus pembayaran pending yang sudah lebih dari 7 hari')
  ->describe('Membersihkan data payment basi untuk menjaga kebersihan database');