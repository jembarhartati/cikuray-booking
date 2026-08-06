<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE pembayarans MODIFY status VARCHAR(30) NOT NULL DEFAULT 'menunggu'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE pembayarans MODIFY status ENUM('menunggu', 'berhasil', 'gagal', 'kedaluwarsa', 'ditolak') NOT NULL DEFAULT 'menunggu'");
        }
    }
};
