<?php

namespace App\Http\Controllers\Pendaki;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $bookings = $user->bookings()
            ->with(['jadwal', 'pembayaran', 'eticket'])
            ->latest()
            ->take(5)
            ->get();

        $totalBooking   = $user->bookings()->count();
        $bookingBerhasil = $user->bookings()
            ->whereHas('pembayaran', fn($q) => $q->where('status', 'berhasil'))
            ->count();

        return view('pendaki.dashboard', compact('bookings', 'totalBooking', 'bookingBerhasil'));
    }
}
