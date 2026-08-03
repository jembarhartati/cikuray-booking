<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ETicket;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooking      = Booking::count();
        $pendakiHariIni    = Booking::whereHas('jadwal', fn($q) => $q->whereDate('tanggal', today()))
                                ->whereIn('status_booking', ['menunggu', 'dikonfirmasi'])
                                ->sum('jumlah_pendaki');
        $totalPembayaran   = Pembayaran::where('status', 'berhasil')->sum('jumlah_bayar');
        $menungguValidasi  = ETicket::where('status_validasi', 'menunggu')->count();
        $totalPendaki      = User::where('role', 'pendaki')->count();
        $pendingPayments   = Pembayaran::where('status', 'menunggu')->count();
        $bookingDikonfirmasi = Booking::where('status_booking', 'dikonfirmasi')->count();
        $bookingMenunggu   = Booking::where('status_booking', 'menunggu')->count();

        // Kuota hari ini
        $jadwalHariIni = Jadwal::whereDate('tanggal', today())->first();
        $kuotaTerpakai = $jadwalHariIni ? max(0, $jadwalHariIni->kuota - $jadwalHariIni->sisaKuota()) : 0;
        $kuotaTotal    = $jadwalHariIni ? $jadwalHariIni->kuota : 200;

        $bookingPerTanggal = Booking::selectRaw('DATE(created_at) as tanggal, SUM(jumlah_pendaki) as total')
            ->whereIn('status_booking', ['menunggu', 'dikonfirmasi'])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->take(7)
            ->get()
            ->reverse()
            ->values();

        $recentBookings = Booking::with(['user', 'jadwal', 'pembayaran'])
            ->latest()->take(8)->get();

        // Pendapatan bulan ini vs bulan lalu (untuk persentase)
        $pendapatanBulanIni = Pembayaran::where('status', 'berhasil')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('jumlah_bayar');
        $pendapatanBulanLalu = Pembayaran::where('status', 'berhasil')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('jumlah_bayar');

        return view('admin.dashboard', compact(
            'totalBooking', 'pendakiHariIni', 'totalPembayaran',
            'menungguValidasi', 'totalPendaki', 'bookingPerTanggal', 'recentBookings',
            'pendingPayments', 'bookingDikonfirmasi', 'bookingMenunggu',
            'kuotaTerpakai', 'kuotaTotal', 'pendapatanBulanIni', 'pendapatanBulanLalu'
        ));
    }
}
