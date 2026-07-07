<?php
// database/migrations/2026_01_01_000006_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('nominal', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->string('payment_type')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payments');
    }
};