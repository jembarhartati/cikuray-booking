<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaPendaki extends Model
{
    protected $fillable = ['booking_id', 'nama', 'urutan'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
