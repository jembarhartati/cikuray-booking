<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari   = $request->get('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', now()->toDateString());
        $statusPembayaran = $request->get('status_pembayaran', '');
        $statusMendaki = $request->get('status_mendaki', '');

        // Base query within date range for counters
        $baseQuery = Booking::whereBetween('created_at', [$dari, $sampai . ' 23:59:59']);

        $totalBooking = (clone $baseQuery)->count();
        
        $totalPendaki = (clone $baseQuery)
            ->whereIn('status_booking', ['menunggu', 'dikonfirmasi'])
            ->sum('jumlah_pendaki');
            
        $totalPendapatan = Pembayaran::where('status', 'berhasil')
            ->whereBetween('paid_at', [$dari, $sampai . ' 23:59:59'])
            ->sum('jumlah_bayar');

        $totalCheckIn = (clone $baseQuery)
            ->whereHas('eticket', function($q) {
                $q->whereNotNull('check_in_at');
            })
            ->sum('jumlah_pendaki');

        $totalCheckOut = (clone $baseQuery)
            ->whereHas('eticket', function($q) {
                $q->whereNotNull('check_out_at');
            })
            ->sum('jumlah_pendaki');

        // Build query for detailed transactions list (with filters applied)
        $detailQuery = Booking::with(['user', 'jadwal', 'pembayaran', 'eticket'])
            ->whereBetween('created_at', [$dari, $sampai . ' 23:59:59']);

        if ($statusPembayaran !== '') {
            if ($statusPembayaran === 'lunas') {
                $detailQuery->whereHas('pembayaran', function($q) {
                    $q->where('status', 'berhasil');
                });
            } elseif ($statusPembayaran === 'belum_lunas') {
                $detailQuery->where(function($q) {
                    $q->whereDoesntHave('pembayaran')
                      ->orWhereHas('pembayaran', function($sq) {
                          $sq->where('status', '!=', 'berhasil');
                      });
                });
            }
        }

        if ($statusMendaki !== '') {
            if ($statusMendaki === 'belum_naik') {
                $detailQuery->where(function($q) {
                    $q->whereDoesntHave('eticket')
                      ->orWhereHas('eticket', function($sq) {
                          $sq->whereNull('check_in_at');
                      });
                });
            } elseif ($statusMendaki === 'mendaki') {
                $detailQuery->whereHas('eticket', function($q) {
                    $q->whereNotNull('check_in_at')->whereNull('check_out_at');
                });
            } elseif ($statusMendaki === 'sudah_turun') {
                $detailQuery->whereHas('eticket', function($q) {
                    $q->whereNotNull('check_in_at')->whereNotNull('check_out_at');
                });
            }
        }

        $bookings = $detailQuery->latest()->paginate(20)->withQueryString();

        $pendakiPerTanggal = Booking::selectRaw('DATE(jadwals.tanggal) as tanggal, SUM(bookings.jumlah_pendaki) as total')
            ->join('jadwals', 'bookings.jadwal_id', '=', 'jadwals.id')
            ->whereIn('bookings.status_booking', ['menunggu', 'dikonfirmasi'])
            ->whereBetween('jadwals.tanggal', [$dari, $sampai])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.laporan.index', compact(
            'dari', 'sampai', 'statusPembayaran', 'statusMendaki',
            'totalBooking', 'totalPendaki', 'totalPendapatan', 'totalCheckIn', 'totalCheckOut',
            'bookings', 'pendakiPerTanggal'
        ));
    }
}
