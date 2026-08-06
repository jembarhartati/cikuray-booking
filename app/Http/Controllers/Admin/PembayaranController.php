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

        // Tampilkan: Transfer Manual yang sudah upload bukti + SEMUA transaksi pembayaran otomatis (VA/QRIS/E-Wallet)
        $query->where(function($q) {
            // Transfer Manual yang sudah upload bukti
            $q->where(function($sub) {
                $sub->where('metode_pembayaran', 'Transfer Manual')
                    ->whereNotNull('bukti_pembayaran');
            })
            // ATAU semua pembayaran otomatis (bukan Transfer Manual)
            ->orWhere(function($sub) {
                $sub->where('metode_pembayaran', '!=', 'Transfer Manual');
            });
        });

        if ($request->filled('status')) {
            if ($request->status === 'menunggu') {
                // Verifikasi pending mencakup status 'menunggu' dan 'ditolak' (pending perbaikan)
                $query->whereIn('status', ['menunggu', 'ditolak']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter berdasarkan metode pembayaran
        if ($request->filled('metode')) {
            if ($request->metode === 'manual') {
                $query->where('metode_pembayaran', 'Transfer Manual');
            } elseif ($request->metode === 'otomatis') {
                $query->where('metode_pembayaran', '!=', 'Transfer Manual');
            }
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
        $pembayaran->update([
            'status' => 'berhasil',
            'paid_at' => now(),
        ]);
        
        $pembayaran->booking->update(['status_booking' => 'dikonfirmasi']);

        ETicket::firstOrCreate(
            ['booking_id' => $pembayaran->booking_id],
            [
                'kode_tiket'     => ETicket::generateKode(),
                'status_validasi' => 'valid',
                'diterbitkan_at'  => now(),
            ]
        );

        return back()->with('success', 'Pembayaran berhasil diverifikasi/diterima dan E-Ticket diterbitkan.');
    }

    public function tolak(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string|max:1000',
        ], [
            'catatan_penolakan.required' => 'Catatan penolakan wajib diisi untuk memberi tahu pendaki.',
        ]);

        // Req 3: Set status menjadi 'ditolak' (bukan 'gagal'), booking tetap 'menunggu' agar status tetap pending/bisa diubah kembali oleh admin
        $pembayaran->update([
            'status' => 'ditolak',
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        $pembayaran->booking->update(['status_booking' => 'menunggu']);

        return back()->with('success', 'Pembayaran ditolak dengan catatan. Status pembayaran tetap PENDING (Ditolak) dan Admin tetap dapat mengubah statusnya menjadi diterima kapan saja.');
    }
}
