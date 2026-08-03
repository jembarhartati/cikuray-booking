<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_bases', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['biaya', 'jadwal', 'kuota', 'perlengkapan', 'aturan', 'booking', 'pembayaran', 'umum']);
            $table->text('pertanyaan');
            $table->json('kata_kunci');
            $table->text('jawaban');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_bases');
    }
};
