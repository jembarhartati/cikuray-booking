<?php

namespace App\Http\Controllers\Pendaki;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index()
    {
        Jadwal::generateUpcomingSchedules();

        // Tampilkan semua jadwal (aktif DAN nonaktif) agar jadwal yang ditutup admin tetap terlihat
        $jadwals = Jadwal::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->take(30)
            ->get()
            ->map(function ($jadwal) {
                $jadwal->kuota_terisi = $jadwal->kuotaTerisi();
                $jadwal->sisa_kuota  = $jadwal->sisaKuota();
                return $jadwal;
            });

        return view('pendaki.jadwal', compact('jadwals'));
    }
}
