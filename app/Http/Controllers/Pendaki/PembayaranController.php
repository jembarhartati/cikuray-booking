<?php

namespace App\Http\Controllers\Pendaki;

use App\Http\Controllers\Controller;
use App\Models\ETicket;
use App\Models\Pembayaran;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function show(Pembayaran $pembayaran, MidtransService $midtrans)
    {
        abort_if($pembayaran->booking->user_id !== auth()->id(), 403);
        $pembayaran->load(['booking.jadwal', 'booking.anggota']);

        if ($pembayaran->status === 'menunggu') {
            $midtrans->checkStatus($pembayaran);
            $pembayaran->refresh();
        }

        $snapToken = null;
        if ($pembayaran->status === 'menunggu') {
            try {
                $snapToken = $pembayaran->snap_token
                    ?? $midtrans->getSnapToken($pembayaran->booking, $pembayaran);
            } catch (\Exception $e) {
                Log::error('Midtrans error: ' . $e->getMessage());
            }
        }

        return view('pendaki.pembayaran.show', compact('pembayaran', 'snapToken'));
    }

    public function callback(Request $request, MidtransService $midtrans)
    {
        $data   = $request->all();
        $result = $midtrans->handleCallback($data);

        $pembayaran = Pembayaran::where('order_id', $result['order_id'])->first();

        if (!$pembayaran) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $pembayaran->update([
            'status'            => $result['status'],
            'metode_pembayaran' => $result['metode_pembayaran'],
            'midtrans_response' => $result['raw'],
            'paid_at'           => $result['status'] === 'berhasil' ? now() : null,
        ]);

        // Buat e-ticket jika pembayaran berhasil
        if ($result['status'] === 'berhasil') {
            $pembayaran->booking->update(['status_booking' => 'dikonfirmasi']);

            ETicket::firstOrCreate(
                ['booking_id' => $pembayaran->booking_id],
                [
                    'kode_tiket'      => ETicket::generateKode(),
                    'status_validasi' => 'valid',
                    'diterbitkan_at'  => now(),
                ]
            );
        }

        return response()->json(['message' => 'OK']);
    }

    public function uploadBukti(Request $request, Pembayaran $pembayaran)
    {
        abort_if($pembayaran->booking->user_id !== auth()->id(), 403);

        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'bukti_pembayaran.required' => 'File bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.mimes'    => 'File harus berformat JPG, PNG, atau PDF.',
            'bukti_pembayaran.max'      => 'Ukuran file maksimal 5MB.',
            'bukti_pembayaran.uploaded' => 'File gagal diunggah karena ukurannya melebihi batas server (maks. 5MB). Silakan pilih file yang lebih kecil.',
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
        $pembayaran->update([
            'bukti_pembayaran' => $path,
            'metode_pembayaran' => 'Transfer Manual',
            'status'            => 'menunggu',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
