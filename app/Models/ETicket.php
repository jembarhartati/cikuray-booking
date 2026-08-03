<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ETicket extends Model
{
    protected $table = 'e_tickets';

    protected $fillable = [
        'booking_id', 'kode_tiket', 'status_validasi',
        'catatan_admin', 'diterbitkan_at', 'divalidasi_at',
        'check_in_at', 'check_out_at', 'status_rombongan',
    ];

    protected $casts = [
        'diterbitkan_at' => 'datetime',
        'divalidasi_at'  => 'datetime',
        'check_in_at'    => 'datetime',
        'check_out_at'   => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function isValid(): bool
    {
        return $this->status_validasi === 'valid';
    }

    public static function generateKode(): string
    {
        do {
            $kode = 'TKT-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (self::where('kode_tiket', $kode)->exists());

        return $kode;
    }
}
