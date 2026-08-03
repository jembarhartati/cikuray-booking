<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking', 30)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('restrict');
            $table->string('nama_ketua', 255);
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->integer('jumlah_pendaki');
            $table->integer('harga_per_orang')->default(30000);
            $table->integer('total_harga');
            $table->enum('status_booking', ['menunggu', 'dikonfirmasi', 'dibatalkan'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
