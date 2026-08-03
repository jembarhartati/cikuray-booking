<?php

namespace App\Http\Controllers\Pendaki;

use App\Http\Controllers\Controller;

class StatusBookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with(['jadwal', 'pembayaran', 'eticket'])
            ->latest()
            ->paginate(10);

        return view('pendaki.status-booking', compact('bookings'));
    }
}
