<?php

namespace App\Http\Controllers\Pendaki;

use App\Http\Controllers\Controller;
use App\Models\ETicket;

class ETicketController extends Controller
{
    public function show(ETicket $eticket)
    {
        abort_if($eticket->booking->user_id !== auth()->id(), 403);
        abort_if($eticket->status_validasi !== 'valid', 403, 'Tiket belum divalidasi.');

        $eticket->load(['booking.jadwal', 'booking.anggota', 'booking.pembayaran']);

        return view('pendaki.eticket', compact('eticket'));
    }
}
