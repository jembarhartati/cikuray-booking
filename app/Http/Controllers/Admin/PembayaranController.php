<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ETicket;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['booking.user', 'booking.jadwal'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembayarans = $query->paginate(15)->withQueryString();
        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['booking.user', 'booking.jadwal', 'booking.anggota']);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function verifikasi(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status' => 'berhasil', 'paid_at' => now()]);
        $pembayaran->booking->update(['status_booking' => 'dikonfirmasi']);

        ETicket::firstOrCreate(
            ['booking_id' => $pembayaran->booking_id],
            [
                'kode_tiket'     => ETicket::generateKode(),
                'status_validasi' => 'valid',
                'diterbitkan_at'  => now(),
            ]
        );

        return back()->with('success', 'Pembayaran berhasil diverifikasi dan e-ticket diterbitkan.');
    }

    public function tolak(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:1000',
        ]);

        $pembayaran->update([
            'status' => 'gagal',
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }
}
