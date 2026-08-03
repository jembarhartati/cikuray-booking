<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class PendakiController extends Controller
{
    public function index()
    {
        $pendakis = User::where('role', 'pendaki')
            ->with('pendaki')
            ->withCount('bookings')
            ->latest()
            ->paginate(15);

        return view('admin.pendaki.index', compact('pendakis'));
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'pendaki', 404);
        $user->load(['pendaki', 'bookings.jadwal', 'bookings.pembayaran']);
        return view('admin.pendaki.show', compact('user'));
    }
}
