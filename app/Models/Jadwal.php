<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'kuota_maksimal', 'status', 'keterangan'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Hitung total pendaki yang sudah booking (dikonfirmasi atau menunggu)
     */
    public function kuotaTerisi(): int
    {
        return $this->bookings()
            ->whereIn('status_booking', ['menunggu', 'dikonfirmasi'])
            ->sum('jumlah_pendaki');
    }

    /**
     * Hitung sisa kuota
     */
    public function sisaKuota(): int
    {
        return max(0, $this->kuota_maksimal - $this->kuotaTerisi());
    }

    /**
     * Cek apakah masih tersedia
     */
    public function tersedia(): bool
    {
        return $this->status === 'aktif' && $this->sisaKuota() > 0;
    }

    /**
     * Otomatis generate jadwal aktif untuk 30 hari ke depan jika belum ada di database
     */
    public static function generateUpcomingSchedules()
    {
        $today = now()->startOfDay();
        for ($i = 0; $i < 30; $i++) {
            $date = (clone $today)->addDays($i)->toDateString();
            self::firstOrCreate(
                ['tanggal' => $date],
                [
                    'kuota_maksimal' => 200,
                    'status' => 'aktif',
                    'keterangan' => null
                ]
            );
        }
    }
}
