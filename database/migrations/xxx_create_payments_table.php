<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('nominal', 10, 2)->default(99000.00);

            $table->enum('status', [
                'pending',
                'confirmed',
                'rejected'
            ])->default('pending');

            $table->string('metode', 50)->nullable();
            $table->string('kode_pembayaran', 50)->nullable()->unique();
            $table->string('bukti_transfer', 255)->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};