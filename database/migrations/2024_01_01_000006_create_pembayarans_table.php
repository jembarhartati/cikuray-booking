<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('order_id', 100)->unique();
            $table->text('snap_token')->nullable();
            $table->string('metode_pembayaran', 100)->nullable();
            $table->enum('status', ['menunggu', 'berhasil', 'gagal', 'kedaluwarsa'])->default('menunggu');
            $table->integer('jumlah_bayar');
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->json('midtrans_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
