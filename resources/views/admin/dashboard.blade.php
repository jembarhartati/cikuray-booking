@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan operasional basecamp Cintanagara Gunung Cikuray.')

@section('content')
<div class="space-y-6 animate-fade-in">

    {{-- ═══════════ WELCOME BANNER ═══════════ --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-forest-700 via-forest-600 to-emerald-500 p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-white/70 text-sm font-medium">👋 Selamat datang,</p>
                <h2 class="text-2xl md:text-3xl font-display font-extrabold mt-1">{{ auth()->user()->name }}</h2>
                <p class="text-white/60 text-sm mt-1.5">
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }} — Berikut ringkasan aktivitas basecamp hari ini.
                </p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('admin.booking.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/20 rounded-xl text-sm font-semibold transition-all duration-200">
                    📋 Kelola Booking
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-forest-700 rounded-xl text-sm font-bold hover:bg-white/90 transition-all duration-200 shadow-lg">
                    📊 Laporan
                </a>
            </div>
        </div>
    </div>

    {{-- ═══════════ STAT CARDS ═══════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
        {{-- Stat: Total Booking --}}
        <div class="bg-white rounded-2xl border border-mountain-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-300">🎟️</div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Total</span>
            </div>
            <p class="text-2xl md:text-3xl font-display font-extrabold text-mountain-900">{{ number_format($totalBooking) }}</p>
            <p class="text-xs text-mountain-400 mt-1 font-medium">Booking Keseluruhan</p>
            <div class="mt-3 flex items-center gap-2 text-xs">
                <span class="text-forest-600 font-bold">{{ $bookingDikonfirmasi }}</span>
                <span class="text-mountain-300">dikonfirmasi</span>
                <span class="text-mountain-200">•</span>
                <span class="text-amber-600 font-bold">{{ $bookingMenunggu }}</span>
                <span class="text-mountain-300">menunggu</span>
            </div>
        </div>

        {{-- Stat: Pendaki Hari Ini --}}
        <div class="bg-white rounded-2xl border border-mountain-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-forest-50 flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-300">🥾</div>
                <span class="text-xs font-bold text-forest-600 bg-forest-50 px-2.5 py-1 rounded-full">Hari Ini</span>
            </div>
            <p class="text-2xl md:text-3xl font-display font-extrabold text-mountain-900">{{ number_format($pendakiHariIni) }}</p>
            <p class="text-xs text-mountain-400 mt-1 font-medium">Pendaki Aktif</p>
            <div class="mt-3">
                <div class="flex items-center justify-between text-xs mb-1">
                    <span class="text-mountain-400">Kuota terpakai</span>
                    <span class="font-bold text-mountain-600">{{ $kuotaTerpakai }}/{{ $kuotaTotal }}</span>
                </div>
                <div class="w-full bg-mountain-100 h-1.5 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 {{ $kuotaTotal > 0 && ($kuotaTerpakai/$kuotaTotal)*100 > 80 ? 'bg-red-500' : 'bg-forest-500' }}" style="width: {{ $kuotaTotal > 0 ? min(100, ($kuotaTerpakai/$kuotaTotal)*100) : 0 }}%"></div>
                </div>
            </div>
        </div>

        {{-- Stat: Pendapatan --}}
        <div class="bg-white rounded-2xl border border-mountain-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-300">💰</div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Bulan Ini</span>
            </div>
            <p class="text-xl md:text-2xl font-display font-extrabold text-mountain-900">Rp{{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
            <p class="text-xs text-mountain-400 mt-1 font-medium">Pendapatan Bersih</p>
            <div class="mt-3 flex items-center gap-1.5 text-xs">
                @if($pendapatanBulanLalu > 0)
                    @php $pctChange = (($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100; @endphp
                    @if($pctChange >= 0)
                        <span class="text-forest-600 font-bold flex items-center gap-0.5">↑ {{ number_format(abs($pctChange), 1) }}%</span>
                    @else
                        <span class="text-red-500 font-bold flex items-center gap-0.5">↓ {{ number_format(abs($pctChange), 1) }}%</span>
                    @endif
                    <span class="text-mountain-300">vs bulan lalu</span>
                @else
                    <span class="text-mountain-300">Total: Rp{{ number_format($totalPembayaran, 0, ',', '.') }}</span>
                @endif
            </div>
        </div>

        {{-- Stat: Menunggu Aksi --}}
        <div class="bg-white rounded-2xl border border-mountain-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
            @if($menungguValidasi + $pendingPayments > 0)
                <div class="absolute top-3 right-3 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></div>
            @endif
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-300">⚡</div>
                <span class="text-xs font-bold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">Perlu Aksi</span>
            </div>
            <p class="text-2xl md:text-3xl font-display font-extrabold text-mountain-900">{{ $menungguValidasi + $pendingPayments }}</p>
            <p class="text-xs text-mountain-400 mt-1 font-medium">Menunggu Tindakan</p>
            <div class="mt-3 flex items-center gap-2 text-xs">
                <a href="{{ route('admin.eticket.index') }}" class="text-red-500 hover:text-red-700 font-bold underline decoration-dotted">{{ $menungguValidasi }} validasi</a>
                <span class="text-mountain-200">•</span>
                <a href="{{ route('admin.pembayaran.index') }}" class="text-amber-500 hover:text-amber-700 font-bold underline decoration-dotted">{{ $pendingPayments }} bayar</a>
            </div>
        </div>
    </div>

    {{-- ═══════════ MAIN CONTENT ═══════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Recent Bookings Table (2 cols) --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-mountain-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-mountain-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-mountain-100 flex items-center justify-center text-sm">📋</div>
                    <div>
                        <h3 class="font-display font-bold text-mountain-800">Booking Terbaru</h3>
                        <p class="text-xs text-mountain-400">8 transaksi terakhir masuk</p>
                    </div>
                </div>
                <a href="{{ route('admin.booking.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-forest-600 hover:text-forest-700 bg-forest-50 hover:bg-forest-100 px-3.5 py-2 rounded-lg transition-all duration-200">
                    Lihat Semua <span>→</span>
                </a>
            </div>
            <div class="overflow-x-auto">
                @if($recentBookings->isEmpty())
                    <div class="p-12 text-center">
                        <div class="text-4xl mb-3">📭</div>
                        <p class="text-mountain-400 text-sm font-medium">Belum ada data booking masuk.</p>
                    </div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="bg-mountain-50/50">
                                <th class="table-th text-left">Kode</th>
                                <th class="table-th text-left">Ketua Rombongan</th>
                                <th class="table-th text-left">Tanggal</th>
                                <th class="table-th text-center">Pendaki</th>
                                <th class="table-th text-center">Status</th>
                                <th class="table-th text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-mountain-50">
                            @foreach($recentBookings as $booking)
                                <tr class="hover:bg-mountain-50/40 transition-colors duration-150">
                                    <td class="table-td">
                                        <span class="font-mono text-xs font-bold text-mountain-700 bg-mountain-50 px-2 py-1 rounded-md">{{ $booking->kode_booking }}</span>
                                    </td>
                                    <td class="table-td">
                                        <div>
                                            <p class="font-semibold text-mountain-800 text-sm">{{ $booking->nama_ketua }}</p>
                                            <p class="text-[10px] text-mountain-400">{{ $booking->user->email ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="table-td text-sm text-mountain-600">
                                        {{ $booking->jadwal->tanggal->locale('id')->isoFormat('D MMM Y') }}
                                    </td>
                                    <td class="table-td text-center">
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-mountain-600">
                                            <span class="w-5 h-5 bg-forest-50 rounded-md flex items-center justify-center text-forest-700 text-[10px]">👥</span>
                                            {{ $booking->jumlah_pendaki }}
                                        </span>
                                    </td>
                                    <td class="table-td text-center">
                                        @if($booking->status_booking === 'dikonfirmasi')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Dikonfirmasi
                                            </span>
                                        @elseif($booking->status_booking === 'menunggu')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 rounded-full text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Menunggu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-600 rounded-full text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="table-td text-center">
                                        <a href="{{ route('admin.booking.show', $booking) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-mountain-50 hover:bg-mountain-100 text-mountain-600 hover:text-mountain-800 rounded-lg text-xs font-semibold transition-all duration-200">
                                            Detail →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-5">

            {{-- Tren Booking Chart --}}
            <div class="bg-white rounded-2xl border border-mountain-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-forest-50 flex items-center justify-center text-sm">📈</div>
                        <h3 class="font-display font-bold text-mountain-800 text-sm">Tren 7 Hari</h3>
                    </div>
                    <span class="text-[10px] text-mountain-400 font-medium uppercase tracking-wider">Pendaki / Hari</span>
                </div>
                <div class="space-y-3">
                    @if($bookingPerTanggal->isEmpty())
                        <div class="text-center py-6">
                            <div class="text-2xl mb-2">📊</div>
                            <p class="text-xs text-mountain-400">Belum ada data tren.</p>
                        </div>
                    @else
                        @php
                            $maxTotal = max(1, $bookingPerTanggal->max('total') ?? 1);
                        @endphp
                        @foreach($bookingPerTanggal as $tren)
                            <div class="group">
                                <div class="flex items-center justify-between text-xs mb-1.5">
                                    <span class="text-mountain-500 font-medium">{{ \Carbon\Carbon::parse($tren->tanggal)->locale('id')->isoFormat('ddd, D MMM') }}</span>
                                    <span class="font-bold text-mountain-700 group-hover:text-forest-600 transition-colors">{{ $tren->total }} orang</span>
                                </div>
                                <div class="w-full bg-mountain-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r from-forest-500 to-emerald-400 h-full rounded-full transition-all duration-700 group-hover:opacity-80"
                                         style="width: {{ ($tren->total / $maxTotal) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Quick Info Cards --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-gradient-to-br from-mountain-900 to-mountain-800 rounded-2xl p-5 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <p class="text-mountain-400 text-[10px] font-bold uppercase tracking-wider">Pengguna</p>
                    <p class="text-2xl font-display font-extrabold mt-2">{{ number_format($totalPendaki) }}</p>
                    <p class="text-mountain-400 text-[10px] mt-1">pendaki terdaftar</p>
                </div>
                <div class="bg-gradient-to-br from-forest-700 to-forest-600 rounded-2xl p-5 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <p class="text-white/60 text-[10px] font-bold uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-lg font-display font-extrabold mt-2">Rp{{ number_format($totalPembayaran/1000, 0, ',', '.') }}K</p>
                    <p class="text-white/50 text-[10px] mt-1">keseluruhan</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl border border-mountain-100 shadow-sm p-5">
                <h3 class="font-display font-bold text-mountain-800 text-sm mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-sm">⚡</span>
                    Aksi Cepat
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.jadwal.create') }}" class="flex items-center gap-3 px-4 py-3 bg-mountain-50 hover:bg-forest-50 rounded-xl text-sm font-medium text-mountain-700 hover:text-forest-700 transition-all duration-200 group">
                        <span class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:shadow text-sm transition-shadow">📅</span>
                        Tambah Jadwal Baru
                        <span class="ml-auto text-mountain-300 group-hover:text-forest-400 transition-colors">→</span>
                    </a>
                    <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mountain-50 hover:bg-amber-50 rounded-xl text-sm font-medium text-mountain-700 hover:text-amber-700 transition-all duration-200 group">
                        <span class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:shadow text-sm transition-shadow">💳</span>
                        Verifikasi Pembayaran
                        @if($pendingPayments > 0)
                            <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingPayments }}</span>
                        @else
                            <span class="ml-auto text-mountain-300 group-hover:text-amber-400 transition-colors">→</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.eticket.index') }}" class="flex items-center gap-3 px-4 py-3 bg-mountain-50 hover:bg-blue-50 rounded-xl text-sm font-medium text-mountain-700 hover:text-blue-700 transition-all duration-200 group">
                        <span class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:shadow text-sm transition-shadow">🧗</span>
                        Validasi E-Ticket
                        @if($menungguValidasi > 0)
                            <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $menungguValidasi }}</span>
                        @else
                            <span class="ml-auto text-mountain-300 group-hover:text-blue-400 transition-colors">→</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
