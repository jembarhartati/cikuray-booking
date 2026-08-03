<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $tanggals = [];
        for ($i = 1; $i <= 30; $i++) {
            $tanggals[] = now()->addDays($i)->format('Y-m-d');
        }

        foreach ($tanggals as $tanggal) {
            Jadwal::firstOrCreate(
                ['tanggal' => $tanggal],
                [
                    'kuota_maksimal' => 200,
                    'status'         => 'aktif',
                    'keterangan'     => null,
                ]
            );
        }
    }
}
