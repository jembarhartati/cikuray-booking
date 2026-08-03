<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'booking_id', 'order_id', 'snap_token', 'metode_pembayaran',
        'status', 'jumlah_bayar', 'bukti_pembayaran', 'midtrans_response', 'paid_at', 'catatan_penolakan',
    ];

    protected $casts = [
        'midtrans_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'berhasil';
    }
}
