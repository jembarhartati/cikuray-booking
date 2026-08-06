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

        // Build query for detailed transactions list (hanya booking yang sudah selesai / check out)
        $detailQuery = Booking::with(['user', 'jadwal', 'pembayaran', 'eticket'])
            ->whereBetween('created_at', [$dari, $sampai . ' 23:59:59'])
            ->whereHas('eticket', function($q) {
                $q->whereNotNull('check_out_at');
            });

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

    public function pdf(Request $request)
    {
        $dari   = $request->get('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', now()->toDateString());
        $statusPembayaran = $request->get('status_pembayaran', '');
        $statusMendaki = $request->get('status_mendaki', '');

        $baseQuery = Booking::whereBetween('created_at', [$dari, $sampai . ' 23:59:59']);

        $totalBooking = (clone $baseQuery)->count();
        
        $totalPendaki = (clone $baseQuery)
            ->whereIn('status_booking', ['menunggu', 'dikonfirmasi'])
            ->sum('jumlah_pendaki');
            
        $totalPendapatan = Pembayaran::where('status', 'berhasil')
            ->whereBetween('paid_at', [$dari, $sampai . ' 23:59:59'])
            ->sum('jumlah_bayar');

        $totalCheckOut = (clone $baseQuery)
            ->whereHas('eticket', function($q) {
                $q->whereNotNull('check_out_at');
            })
            ->sum('jumlah_pendaki');

        $detailQuery = Booking::with(['user', 'jadwal', 'pembayaran', 'eticket'])
            ->whereBetween('created_at', [$dari, $sampai . ' 23:59:59'])
            ->whereHas('eticket', function($q) {
                $q->whereNotNull('check_out_at');
            });

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

        $bookings = $detailQuery->latest()->get();

        $pendakiPerTanggal = Booking::selectRaw('DATE(jadwals.tanggal) as tanggal, SUM(bookings.jumlah_pendaki) as total')
            ->join('jadwals', 'bookings.jadwal_id', '=', 'jadwals.id')
            ->whereIn('bookings.status_booking', ['menunggu', 'dikonfirmasi'])
            ->whereBetween('jadwals.tanggal', [$dari, $sampai])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.laporan.pdf', compact(
            'dari', 'sampai', 'statusPembayaran', 'statusMendaki',
            'totalBooking', 'totalPendaki', 'totalPendapatan', 'totalCheckOut',
            'bookings', 'pendakiPerTanggal'
        ));
    }

    public function csv(Request $request)
    {
        $dari   = $request->get('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', now()->toDateString());
        $statusPembayaran = $request->get('status_pembayaran', '');

        $detailQuery = Booking::with(['user', 'jadwal', 'pembayaran', 'eticket'])
            ->whereBetween('created_at', [$dari, $sampai . ' 23:59:59'])
            ->whereHas('eticket', function($q) {
                $q->whereNotNull('check_out_at');
            });

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

        $bookings = $detailQuery->latest()->get();

        $filename = "Laporan_Pendakian_Cikuray_{$dari}_to_{$sampai}.csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Output UTF-8 BOM + sep=; for Microsoft Excel column parsing compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fwrite($file, "sep=;\n");

            // Header Column Names
            fputcsv($file, [
                'No',
                'Kode Booking',
                'Nama Ketua',
                'Alamat Asal',
                'Tanggal Naik',
                'Tanggal Turun',
                'Jenis Pendakian',
                'Jumlah Pendaki',
                'Total Biaya (Rp)',
                'Status Pembayaran',
                'Status Pendakian'
            ], ';');

            // Data Rows
            foreach ($bookings as $index => $b) {
                $tNaik = $b->jadwal ? $b->jadwal->tanggal : null;
                $tTurun = $b->tanggal_turun;
                $selisih = ($tNaik && $tTurun) ? $tNaik->diffInDays($tTurun) : 0;
                $jenis = ($selisih == 0) ? 'Tektok' : 'Camp';
                
                $statusBayar = ($b->pembayaran && $b->pembayaran->status === 'berhasil') ? 'Lunas' : 'Belum Lunas';
                $statusAktivitas = ($b->eticket && $b->eticket->check_out_at) ? 'Sudah Turun (Selesai)' : 'Mendaki';

                fputcsv($file, [
                    $index + 1,
                    $b->kode_booking,
                    $b->nama_ketua,
                    $b->alamat,
                    $tNaik ? $tNaik->format('d/m/Y') : '-',
                    $tTurun ? $tTurun->format('d/m/Y') : '-',
                    $jenis,
                    $b->jumlah_pendaki,
                    $b->total_harga,
                    $statusBayar,
                    $statusAktivitas
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
