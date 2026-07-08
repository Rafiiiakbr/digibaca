<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Relasi user aman untuk SQLite
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->double('nominal', 10, 2)->default(99000.00);
            $table->string('status', 20)->default('pending'); // string biasa agar ramah SQLite
            $table->timestamp('tanggal_bayar')->nullable();

            // Kolom Sistem Otomatis (Midtrans)
            $table->string('order_id')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('payment_type')->nullable();

            // Kolom Sistem Manual Transfer
            $table->string('metode', 50)->nullable();
            $table->string('kode_pembayaran', 50)->nullable();
            $table->string('bukti_transfer', 255)->nullable();
            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payments');
    }
};