<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_booking', 'user_id', 'jadwal_id', 'tanggal_turun', 'nama_ketua',
        'alamat', 'no_telepon', 'no_darurat', 'jumlah_pendaki',
        'harga_per_orang', 'total_harga', 'status_booking', 'catatan',
    ];

    protected $casts = [
        'tanggal_turun' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function anggota()
    {
        return $this->hasMany(AnggotaPendaki::class)->orderBy('urutan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function eticket()
    {
        return $this->hasOne(ETicket::class);
    }

    public static function generateKode(): string
    {
        do {
            $kode = 'CIK-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));
        } while (self::where('kode_booking', $kode)->exists());

        return $kode;
    }
}
