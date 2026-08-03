@extends('layouts.pendaki')

@section('title', 'Dashboard Pendaki')

@section('content')
<!-- ═══════════ HERO WELCOME ═══════════ -->
<section class="hero-section py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-white max-w-xl animate-fade-in-up">
                <p class="text-forest-300 text-sm font-medium mb-2 flex items-center gap-2">
                    <span class="w-2 h-2 bg-forest-400 rounded-full animate-pulse-slow"></span>
                    Selamat Datang Kembali
                </p>
                <h2 class="text-3xl md:text-4xl font-display font-extrabold leading-tight mb-3">
                    Halo, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-mountain-300 text-sm leading-relaxed">
                    Rencanakan petualangan Anda ke puncak Gunung Cikuray (2.821 mdpl) via Basecamp Cintanagara. Cek jadwal, booking tiket, dan kelola semua perjalanan Anda di sini.
                </p>
                <a href="{{ route('pendaki.booking.create') }}" class="btn-primary mt-6 shadow-xl shadow-forest-700/40">
                    🎫 Booking Tiket Sekarang
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="flex flex-col sm:flex-row md:flex-col gap-4 w-full md:w-auto">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 p-5 flex items-center gap-4 min-w-[200px]">
                    <div class="w-12 h-12 bg-forest-500/20 rounded-xl flex items-center justify-center text-2xl">🎟️</div>
                    <div>
                        <p class="text-mountain-300 text-xs font-medium">Total Booking</p>
                        <h3 class="text-2xl font-display font-bold text-white">{{ $totalBooking }}</h3>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 p-5 flex items-center gap-4 min-w-[200px]">
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center text-2xl">✅</div>
                    <div>
                        <p class="text-mountain-300 text-xs font-medium">Booking Berhasil</p>
                        <h3 class="text-2xl font-display font-bold text-white">{{ $bookingBerhasil }}</h3>
                    </div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 p-5 flex items-center gap-4 min-w-[200px]">
                    <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center text-2xl">🏔️</div>
                    <div>
                        <p class="text-mountain-300 text-xs font-medium">Ketinggian Jalur</p>
                        <h3 class="text-2xl font-display font-bold text-white">2.821 <span class="text-sm font-normal text-mountain-400">mdpl</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ QUICK ACTIONS ═══════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Booking Tiket -->
        <a href="{{ route('pendaki.booking.create') }}" class="action-card bg-gradient-to-br from-forest-600 to-forest-800 border-none text-white shadow-xl shadow-forest-700/20" style="animation-delay: 0.1s">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                🎫
            </div>
            <div>
                <h4 class="font-display font-bold text-lg text-mountain-800 leading-tight">Booking Tiket</h4>
                <p class="text-mountain-400 text-xs mt-1">Pesan kuota pendakian sekarang</p>
            </div>
            <span class="absolute top-4 right-4 text-mountain-200 text-2xl group-hover:translate-x-1 group-hover:text-forest-500 transition-all duration-300">→</span>
        </a>

        <!-- Jadwal & Kuota -->
        <a href="{{ route('pendaki.jadwal') }}" class="action-card" style="animation-delay: 0.2s">
            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                📅
            </div>
            <div>
                <h4 class="font-display font-bold text-lg text-mountain-800 leading-tight">Jadwal & Kuota</h4>
                <p class="text-mountain-400 text-xs mt-1">Cek ketersediaan kuota pendaki</p>
            </div>
            <span class="absolute top-4 right-4 text-mountain-200 text-2xl group-hover:translate-x-1 group-hover:text-forest-500 transition-all duration-300">→</span>
        </a>

        <!-- Informasi Gunung -->
        <a href="{{ route('pendaki.informasi') }}" class="action-card" style="animation-delay: 0.3s">
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                ℹ️
            </div>
            <div>
                <h4 class="font-display font-bold text-lg text-mountain-800 leading-tight">Informasi Gunung</h4>
                <p class="text-mountain-400 text-xs mt-1">Aturan, rute, & perlengkapan wajib</p>
            </div>
            <span class="absolute top-4 right-4 text-mountain-200 text-2xl group-hover:translate-x-1 group-hover:text-forest-500 transition-all duration-300">→</span>
        </a>

        <!-- Status Booking -->
        <a href="{{ route('pendaki.status-booking') }}" class="action-card" style="animation-delay: 0.4s">
            <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                📋
            </div>
            <div>
                <h4 class="font-display font-bold text-lg text-mountain-800 leading-tight">Status Booking</h4>
                <p class="text-mountain-400 text-xs mt-1">Riwayat, e-ticket & pembayaran</p>
            </div>
            <span class="absolute top-4 right-4 text-mountain-200 text-2xl group-hover:translate-x-1 group-hover:text-forest-500 transition-all duration-300">→</span>
        </a>
    </div>
</section>

<!-- ═══════════ RECENT BOOKINGS ═══════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <div class="glass-card">
        <div class="px-6 py-5 border-b border-mountain-100/50 flex items-center justify-between">
            <div>
                <h3 class="font-display font-bold text-mountain-800 text-lg">Riwayat Booking Terakhir</h3>
                <p class="text-xs text-mountain-400 mt-0.5">Pantau status pemesanan tiket Anda</p>
            </div>
            <a href="{{ route('pendaki.status-booking') }}" class="text-sm font-semibold text-forest-600 hover:text-forest-700 transition-colors flex items-center gap-1 group">
                Lihat Semua <span class="group-hover:translate-x-1 transition-transform duration-200">→</span>
            </a>
        </div>
        <div class="overflow-x-auto">
            @if($bookings->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-mountain-100 to-mountain-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                        🎟️
                    </div>
                    <h4 class="font-display font-bold text-mountain-700 text-lg">Belum Ada Riwayat Booking</h4>
                    <p class="text-sm text-mountain-400 mt-2 max-w-sm mx-auto">Anda belum pernah memesan tiket pendakian. Rencanakan perjalanan Anda dan pesan kuota sekarang!</p>
                    <a href="{{ route('pendaki.booking.create') }}" class="btn-primary mt-5">
                        🎫 Pesan Tiket Pertama Anda
                    </a>
                </div>
            @else
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-mountain-50/50 border-b border-mountain-100">
                            <th class="table-th">Kode Booking</th>
                            <th class="table-th">Tanggal Pendakian</th>
                            <th class="table-th">Jumlah Anggota</th>
                            <th class="table-th">Total Harga</th>
                            <th class="table-th">Status Bayar</th>
                            <th class="table-th">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-mountain-100">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-forest-50/30 transition-colors duration-200">
                                <td class="table-td font-semibold text-mountain-900">{{ $booking->kode_booking }}</td>
                                <td class="table-td font-medium">{{ $booking->jadwal->tanggal->locale('id')->isoFormat('D MMMM Y') }}</td>
                                <td class="table-td">{{ $booking->jumlah_pendaki }} orang</td>
                                <td class="table-td font-semibold text-mountain-900">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                <td class="table-td">
                                    @if(!$booking->pembayaran)
                                        <span class="badge-danger">Belum Dibuat</span>
                                    @elseif($booking->pembayaran->status === 'berhasil')
                                        <span class="badge-success">Berhasil</span>
                                    @elseif($booking->pembayaran->status === 'menunggu')
                                        <span class="badge-warning">Menunggu</span>
                                    @else
                                        <span class="badge-danger">{{ ucfirst($booking->pembayaran->status) }}</span>
                                    @endif
                                </td>
                                <td class="table-td">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('pendaki.booking.show', $booking) }}" class="px-3 py-1.5 bg-mountain-100 text-mountain-700 hover:bg-mountain-200 rounded-lg text-xs font-semibold transition-all duration-200">
                                            Detail
                                        </a>
                                        @if($booking->pembayaran && $booking->pembayaran->status === 'menunggu')
                                            <a href="{{ route('pendaki.pembayaran.show', $booking->pembayaran) }}" class="px-3 py-1.5 bg-forest-600 text-white hover:bg-forest-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                                Bayar
                                            </a>
                                        @endif
                                        @if($booking->eticket && $booking->eticket->status_validasi === 'valid')
                                            <a href="{{ route('pendaki.eticket.show', $booking->eticket) }}" class="px-3 py-1.5 bg-blue-600 text-white hover:bg-blue-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                                E-Ticket
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</section>
@endsection
