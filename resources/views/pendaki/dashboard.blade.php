@extends('layouts.pendaki')

@section('title', 'Dashboard Pendaki')

@section('content')
<!-- ═══════════ HERO WELCOME ═══════════ -->
<section class="hero-section py-8 sm:py-10 md:py-14 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 sm:gap-8">
            <div class="text-white max-w-2xl animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-emerald-300 text-[11px] sm:text-xs font-semibold mb-3 sm:mb-4">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></span>
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Portal Pendaki Resmi — Gunung Cikuray Via Cintanagara</span>
                </div>
                <h1 class="text-2xl sm:text-4xl md:text-5xl font-display font-extrabold leading-tight mb-2 sm:mb-3 tracking-tight">
                    Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-200">{{ auth()->user()->name }}</span>! 👋
                </h1>
                <p class="text-mountain-200 text-xs sm:text-sm md:text-base leading-relaxed max-w-xl">
                    Rencanakan pendakian Anda ke puncak tertinggi ke-2 di Jawa Barat (2.821 MDPL). Pantau status booking, unduh e-ticket, dan persiapkan petualangan Anda di sini.
                </p>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 mt-5 sm:mt-6">
                    <a href="{{ route('pendaki.booking.create') }}" class="btn-primary shadow-xl shadow-forest-700/40 py-3 px-5 sm:px-6 text-xs sm:text-sm font-bold flex items-center justify-center gap-2 group">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        <span>Booking Tiket Sekarang</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                    <a href="{{ route('pendaki.jadwal') }}" class="btn-secondary bg-white/10 hover:bg-white/20 text-white border-white/20 py-3 px-5 text-xs sm:text-sm font-semibold backdrop-blur-sm text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Cek Kuota & Jadwal</span>
                    </a>
                </div>
            </div>

            <!-- Stats Counter Cards (Mobile-friendly Grid) -->
            <div class="grid grid-cols-3 lg:flex lg:flex-col gap-2 sm:gap-3.5 w-full lg:w-auto shrink-0">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 p-2.5 sm:p-4 flex flex-col sm:flex-row items-center gap-2 sm:gap-3.5 hover:bg-white/15 transition-all duration-300 shadow-lg text-center sm:text-left">
                    <div class="w-8 h-8 sm:w-11 sm:h-11 bg-forest-500/25 rounded-xl flex items-center justify-center text-forest-300 shrink-0 border border-forest-400/30">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <div>
                        <p class="text-mountain-300 text-[9px] sm:text-[11px] font-medium uppercase tracking-wider">Total Booking</p>
                        <h3 class="text-sm sm:text-2xl font-display font-bold text-white leading-tight">{{ $totalBooking }}</h3>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 p-2.5 sm:p-4 flex flex-col sm:flex-row items-center gap-2 sm:gap-3.5 hover:bg-white/15 transition-all duration-300 shadow-lg text-center sm:text-left">
                    <div class="w-8 h-8 sm:w-11 sm:h-11 bg-emerald-500/25 rounded-xl flex items-center justify-center text-emerald-300 shrink-0 border border-emerald-400/30">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-mountain-300 text-[9px] sm:text-[11px] font-medium uppercase tracking-wider">Tiket Berhasil</p>
                        <h3 class="text-sm sm:text-2xl font-display font-bold text-white leading-tight">{{ $bookingBerhasil }}</h3>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 p-2.5 sm:p-4 flex flex-col sm:flex-row items-center gap-2 sm:gap-3.5 hover:bg-white/15 transition-all duration-300 shadow-lg text-center sm:text-left">
                    <div class="w-8 h-8 sm:w-11 sm:h-11 bg-amber-500/25 rounded-xl flex items-center justify-center text-amber-300 shrink-0 border border-amber-400/30">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21l7-14 4 7 3-4 4 11"/></svg>
                    </div>
                    <div>
                        <p class="text-mountain-300 text-[9px] sm:text-[11px] font-medium uppercase tracking-wider">Ketinggian</p>
                        <h3 class="text-sm sm:text-2xl font-display font-bold text-white leading-tight">2.821 <span class="text-[9px] sm:text-xs font-normal text-mountain-300">MDPL</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ UPCOMING BOOKING HIGHLIGHT (IF ANY) ═══════════ -->
@php
    $upcomingBooking = $bookings->first(function($b) {
        return $b->jadwal && ($b->jadwal->tanggal->isFuture() || $b->jadwal->tanggal->isToday());
    });
@endphp

@if($upcomingBooking)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4 sm:-mt-6 relative z-20 mb-6">
    <div class="bg-gradient-to-r from-forest-800 via-forest-900 to-mountain-900 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-2xl border border-forest-600/40 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative z-10">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 flex items-center justify-center text-emerald-300 shrink-0 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v3l2 2"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-widest bg-emerald-500/30 text-emerald-200 px-2 py-0.5 rounded-full border border-emerald-400/30">Pendakian Mendatang</span>
                        <span class="text-[11px] text-mountain-300 font-mono">#{{ $upcomingBooking->kode_booking }}</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-display font-extrabold text-white mt-1">
                        {{ $upcomingBooking->jadwal->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </h3>
                    <p class="text-[11px] sm:text-xs text-mountain-300">
                        Rombongan: <strong>{{ $upcomingBooking->jumlah_pendaki }} Orang</strong> (Ketua: {{ $upcomingBooking->nama_ketua }})
                    </p>
                </div>
            </div>

            <div class="w-full sm:w-auto flex justify-end">
                @if($upcomingBooking->eticket && $upcomingBooking->eticket->status_validasi === 'valid')
                    <a href="{{ route('pendaki.eticket.show', $upcomingBooking->eticket) }}" class="btn-primary w-full sm:w-auto py-2.5 px-5 text-xs font-bold shadow-lg shadow-forest-600/30 flex items-center justify-center gap-1.5 whitespace-nowrap">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        <span>Buka E-Ticket</span>
                    </a>
                @elseif($upcomingBooking->pembayaran && $upcomingBooking->pembayaran->status === 'menunggu')
                    <a href="{{ route('pendaki.pembayaran.show', $upcomingBooking->pembayaran) }}" class="btn-primary bg-amber-500 hover:bg-amber-600 w-full sm:w-auto py-2.5 px-5 text-xs font-bold shadow-lg shadow-amber-500/30 flex items-center justify-center gap-1.5 whitespace-nowrap">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <span>Bayar Sekarang</span>
                    </a>
                @else
                    <a href="{{ route('pendaki.booking.show', $upcomingBooking) }}" class="btn-secondary bg-white/10 hover:bg-white/20 text-white border-white/20 w-full sm:w-auto py-2.5 px-5 text-xs font-bold text-center whitespace-nowrap">
                        <span>Detail Booking</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<!-- ═══════════ QUICK ACTIONS (2x2 Grid on Mobile) ═══════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 {{ $upcomingBooking ? '' : '-mt-4 sm:-mt-6 relative z-10' }}">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
        <!-- Booking Tiket -->
        <a href="{{ route('pendaki.booking.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-forest-700 via-forest-800 to-forest-900 rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-white shadow-xl hover:shadow-2xl hover:shadow-forest-700/30 transition-all duration-300 hover:-translate-y-1 border border-forest-600/50 flex flex-col justify-between h-36 sm:h-44">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/15 rounded-xl sm:rounded-2xl flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-300 backdrop-blur-sm">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
                <span class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-white/10 flex items-center justify-center text-white text-xs sm:text-sm group-hover:translate-x-1 group-hover:bg-white/20 transition-all">→</span>
            </div>
            <div>
                <h3 class="font-display font-extrabold text-base sm:text-xl text-white leading-tight">Booking Tiket</h3>
                <p class="text-forest-200 text-[10px] sm:text-xs mt-0.5 sm:mt-1">Pesan kuota pendakian online</p>
            </div>
        </a>

        <!-- Jadwal & Kuota -->
        <a href="{{ route('pendaki.jadwal') }}" class="group relative overflow-hidden bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-mountain-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-mountain-200/80 flex flex-col justify-between h-36 sm:h-44">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-sky-100 text-sky-700 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-mountain-100 flex items-center justify-center text-mountain-600 text-xs sm:text-sm group-hover:translate-x-1 group-hover:bg-forest-600 group-hover:text-white transition-all">→</span>
            </div>
            <div>
                <h3 class="font-display font-extrabold text-base sm:text-xl text-mountain-900 leading-tight">Jadwal & Kuota</h3>
                <p class="text-mountain-500 text-[10px] sm:text-xs mt-0.5 sm:mt-1">Cek sisa kapasitas pendaki</p>
            </div>
        </a>

        <!-- Informasi Gunung -->
        <a href="{{ route('pendaki.informasi') }}" class="group relative overflow-hidden bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-mountain-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-mountain-200/80 flex flex-col justify-between h-36 sm:h-44">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 text-amber-700 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-mountain-100 flex items-center justify-center text-mountain-600 text-xs sm:text-sm group-hover:translate-x-1 group-hover:bg-forest-600 group-hover:text-white transition-all">→</span>
            </div>
            <div>
                <h3 class="font-display font-extrabold text-base sm:text-xl text-mountain-900 leading-tight">Informasi & SOP</h3>
                <p class="text-mountain-500 text-[10px] sm:text-xs mt-0.5 sm:mt-1">Aturan rute & syarat</p>
            </div>
        </a>

        <!-- Status Booking -->
        <a href="{{ route('pendaki.status-booking') }}" class="group relative overflow-hidden bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-mountain-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-mountain-200/80 flex flex-col justify-between h-36 sm:h-44">
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 text-indigo-700 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-mountain-100 flex items-center justify-center text-mountain-600 text-xs sm:text-sm group-hover:translate-x-1 group-hover:bg-forest-600 group-hover:text-white transition-all">→</span>
            </div>
            <div>
                <h3 class="font-display font-extrabold text-base sm:text-xl text-mountain-900 leading-tight">Status Booking</h3>
                <p class="text-mountain-500 text-[10px] sm:text-xs mt-0.5 sm:mt-1">Riwayat, e-ticket & bayar</p>
            </div>
        </a>
    </div>
</section>

<!-- ═══════════ RECENT BOOKINGS & BASECAMP HOTLINE ═══════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 sm:mt-10 mb-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Recent Bookings Table / Mobile Card List -->
        <div class="lg:col-span-2 glass-card">
            <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-mountain-100/60 flex items-center justify-between">
                <div>
                    <h3 class="font-display font-bold text-mountain-800 text-base sm:text-lg">Riwayat Booking Terakhir</h3>
                    <p class="text-[11px] sm:text-xs text-mountain-400 mt-0.5">Pantau status pemesanan tiket Anda</p>
                </div>
                <a href="{{ route('pendaki.status-booking') }}" class="text-[11px] sm:text-xs font-bold text-forest-600 hover:text-forest-700 transition-colors flex items-center gap-1 group bg-forest-50 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-xl border border-forest-100 shrink-0">
                    Lihat Semua <span class="group-hover:translate-x-1 transition-transform duration-200">→</span>
                </a>
            </div>

            @if($bookings->isEmpty())
                <div class="p-8 sm:p-12 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-mountain-100 to-mountain-50 rounded-full flex items-center justify-center mx-auto mb-4 text-forest-600 shadow-inner">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <h4 class="font-display font-bold text-mountain-700 text-base sm:text-lg">Belum Ada Riwayat Booking</h4>
                    <p class="text-xs sm:text-sm text-mountain-400 mt-2 max-w-sm mx-auto">Anda belum pernah memesan tiket pendakian. Rencanakan perjalanan Anda dan pesan kuota sekarang!</p>
                    <a href="{{ route('pendaki.booking.create') }}" class="btn-primary mt-5 inline-flex items-center gap-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        <span>Pesan Tiket Pertama Anda</span>
                    </a>
                </div>
            @else
                <!-- Desktop Table View (Hidden on mobile) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-mountain-50/60 border-b border-mountain-100 text-left text-[11px] font-bold uppercase text-mountain-400 tracking-wider">
                                <th class="py-3 px-6">Kode Booking</th>
                                <th class="py-3 px-6">Tanggal Naik</th>
                                <th class="py-3 px-6 text-center">Jumlah</th>
                                <th class="py-3 px-6">Total Biaya</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-mountain-100 text-xs">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-forest-50/30 transition-colors duration-200">
                                    <td class="py-4 px-6 font-semibold text-mountain-900 font-mono">{{ $booking->kode_booking }}</td>
                                    <td class="py-4 px-6 font-medium text-mountain-700">{{ $booking->jadwal->tanggal->locale('id')->isoFormat('D MMMM Y') }}</td>
                                    <td class="py-4 px-6 text-center font-bold text-mountain-800">{{ $booking->jumlah_pendaki }} org</td>
                                    <td class="py-4 px-6 font-bold text-mountain-900">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if(!$booking->pembayaran)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700">Belum Dibuat</span>
                                        @elseif($booking->pembayaran->status === 'berhasil')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Lunas</span>
                                        @elseif($booking->pembayaran->status === 'menunggu')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Menunggu</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700">{{ ucfirst($booking->pembayaran->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="{{ route('pendaki.booking.show', $booking) }}" class="px-3 py-1.5 bg-mountain-100 hover:bg-mountain-200 text-mountain-700 rounded-xl text-[11px] font-bold transition-all">
                                                Detail
                                            </a>
                                            @if($booking->pembayaran && $booking->pembayaran->status === 'menunggu')
                                                <a href="{{ route('pendaki.pembayaran.show', $booking->pembayaran) }}" class="px-3 py-1.5 bg-forest-600 hover:bg-forest-700 text-white rounded-xl text-[11px] font-bold shadow-sm transition-all">
                                                    Bayar
                                                </a>
                                            @endif
                                            @if($booking->eticket && $booking->eticket->status_validasi === 'valid')
                                                <a href="{{ route('pendaki.eticket.show', $booking->eticket) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-[11px] font-bold shadow-sm transition-all">
                                                    E-Ticket
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List View (Shown on mobile devices) -->
                <div class="block md:hidden divide-y divide-mountain-100 p-3 sm:p-4 space-y-3">
                    @foreach($bookings as $booking)
                        <div class="p-3.5 bg-white/70 rounded-2xl border border-mountain-150 space-y-2.5 shadow-sm">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-mono font-bold text-xs text-mountain-900">{{ $booking->kode_booking }}</span>
                                @if(!$booking->pembayaran)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-red-700">Belum Dibuat</span>
                                @elseif($booking->pembayaran->status === 'berhasil')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800">Lunas</span>
                                @elseif($booking->pembayaran->status === 'menunggu')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-100 text-amber-800">Menunggu</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-red-700">{{ ucfirst($booking->pembayaran->status) }}</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-[11px] text-mountain-600">
                                <div>
                                    <span class="text-mountain-400 block text-[9px] font-semibold uppercase">Tanggal Naik</span>
                                    <span class="font-semibold text-mountain-800">{{ $booking->jadwal->tanggal->locale('id')->isoFormat('D MMM Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-mountain-400 block text-[9px] font-semibold uppercase">Total Tagihan</span>
                                    <span class="font-bold text-forest-750">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-mountain-100 flex items-center justify-end gap-2">
                                <a href="{{ route('pendaki.booking.show', $booking) }}" class="flex-1 py-1.5 bg-mountain-100 hover:bg-mountain-200 text-mountain-700 rounded-xl text-[11px] font-bold text-center transition-all">
                                    Detail
                                </a>
                                @if($booking->pembayaran && $booking->pembayaran->status === 'menunggu')
                                    <a href="{{ route('pendaki.pembayaran.show', $booking->pembayaran) }}" class="flex-1 py-1.5 bg-forest-600 hover:bg-forest-700 text-white rounded-xl text-[11px] font-bold text-center shadow-sm transition-all">
                                        Bayar
                                    </a>
                                @endif
                                @if($booking->eticket && $booking->eticket->status_validasi === 'valid')
                                    <a href="{{ route('pendaki.eticket.show', $booking->eticket) }}" class="flex-1 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-[11px] font-bold text-center shadow-sm transition-all">
                                        E-Ticket
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Sidebar Info & SOP -->
        <div class="space-y-6">
            <!-- SOP & Persiapan Pendakian -->
            <div class="glass-card p-5 sm:p-6 space-y-4">
                <h4 class="font-display font-bold text-mountain-800 text-sm flex items-center gap-2 border-b border-mountain-100 pb-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    <span>Persiapan Wajib Pendaki</span>
                </h4>
                <ul class="space-y-3 text-xs text-mountain-600">
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                        <span>Membawa <strong>KTP / Kartu Identitas Asli</strong> seluruh anggota rombongan.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                        <span>Membawa perlengkapan pendakian lengkap (Tenda, SB, Logistik, Medis).</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                        <span>Dilarang membawa senjata tajam, miras, & obat terlarang.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                        <span>Wajib membawa kembali seluruh sampah (Zero Waste Hiking).</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
