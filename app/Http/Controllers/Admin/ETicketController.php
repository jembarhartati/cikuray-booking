<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ETicket;
use Illuminate\Http\Request;

class ETicketController extends Controller
{
    public function index(Request $request)
    {
        $query = ETicket::with(['booking.user', 'booking.jadwal'])->latest();

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'belum_naik') {
                $query->whereNull('check_in_at');
            } elseif ($status === 'mendaki') {
                $query->whereNotNull('check_in_at')->whereNull('check_out_at');
            } elseif ($status === 'sudah_turun') {
                $query->whereNotNull('check_in_at')->whereNotNull('check_out_at');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('booking', function ($q) use ($search) {
                $q->where('nama_ketua', 'like', '%' . $search . '%');
            });
        }

        $etickets = $query->paginate(15)->withQueryString();
        return view('admin.eticket.index', compact('etickets'));
    }

    public function show(ETicket $eticket)
    {
        $eticket->load(['booking.user', 'booking.jadwal', 'booking.anggota', 'booking.pembayaran']);
        return view('admin.eticket.show', compact('eticket'));
    }

    public function validasi(Request $request, ETicket $eticket)
    {
        $eticket->update([
            'status_validasi' => 'valid',
            'catatan_admin'   => $request->catatan_admin,
            'divalidasi_at'   => now(),
        ]);
        return back()->with('success', 'Tiket berhasil divalidasi.');
    }

    public function tolak(Request $request, ETicket $eticket)
    {
        $eticket->update([
            'status_validasi' => 'ditolak',
            'catatan_admin'   => $request->catatan_admin,
            'divalidasi_at'   => now(),
        ]);
        return back()->with('success', 'Tiket berhasil ditolak.');
    }

    public function checkIn(ETicket $eticket)
    {
        $eticket->update([
            'check_in_at' => now(),
        ]);
        return back()->with('success', 'Pendaki berhasil Check-In (Naik) pada ' . now()->format('d/m/Y H:i') . ' WIB.');
    }

    public function checkOut(Request $request, ETicket $eticket)
    {
        $eticket->update([
            'check_out_at' => now(),
            'status_rombongan' => $request->input('status_rombongan', 'lengkap'),
        ]);
        return back()->with('success', 'Pendaki berhasil Check-Out (Turun) pada ' . now()->format('d/m/Y H:i') . ' WIB.');
    }
}
