<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'jadwal', 'pembayaran'])->latest();

        if ($request->filled('status')) {
            $query->where('status_booking', $request->status);
        }
        if ($request->filled('tanggal')) {
            $query->whereHas('jadwal', fn($q) => $q->whereDate('tanggal', $request->tanggal));
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_booking', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_ketua', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.booking.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'jadwal', 'anggota', 'pembayaran', 'eticket']);
        return view('admin.booking.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status_booking' => 'required|in:menunggu,dikonfirmasi,dibatalkan']);
        $booking->update(['status_booking' => $request->status_booking]);
        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}
