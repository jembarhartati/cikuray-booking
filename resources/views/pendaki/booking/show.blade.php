@extends('layouts.pendaki')

@section('title', 'Detail Booking')

@section('content')
<!-- ═══════════ HERO ═══════════ -->
<section class="hero-section py-8 md:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up">
        <a href="{{ route('pendaki.status-booking') }}" class="inline-flex items-center gap-1.5 text-forest-300 hover:text-white text-sm font-medium transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Booking
        </a>
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="text-white">
                <p class="text-forest-300 text-sm font-medium mb-1">Detail Booking</p>
                <h2 class="text-3xl font-display font-extrabold">{{ $booking->kode_booking }}</h2>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @if($booking->pembayaran && $booking->pembayaran->status === 'berhasil')
                    <span class="px-4 py-2 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-xl text-sm font-semibold backdrop-blur-sm">💳 Lunas</span>
                @else
                    @if($booking->status_booking === 'dikonfirmasi')
                        <span class="px-4 py-2 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-xl text-sm font-semibold backdrop-blur-sm">✅ Dikonfirmasi</span>
                    @elseif($booking->status_booking === 'menunggu')
                        <span class="px-4 py-2 bg-amber-500/20 text-amber-300 border border-amber-500/30 rounded-xl text-sm font-semibold backdrop-blur-sm">⏳ Menunggu Konfirmasi</span>
                    @else
                        <span class="px-4 py-2 bg-red-500/20 text-red-300 border border-red-500/30 rounded-xl text-sm font-semibold backdrop-blur-sm">❌ Dibatalkan</span>
                    @endif

                    @if(!$booking->pembayaran)
                        <span class="px-4 py-2 bg-red-500/20 text-red-300 border border-red-500/30 rounded-xl text-sm font-semibold backdrop-blur-sm">Belum Bayar</span>
                    @elseif($booking->pembayaran->status === 'menunggu')
                        <span class="px-4 py-2 bg-amber-500/20 text-amber-300 border border-amber-500/30 rounded-xl text-sm font-semibold backdrop-blur-sm">⏳ Menunggu Pembayaran</span>
                    @else
                        <span class="px-4 py-2 bg-red-500/20 text-red-300 border border-red-500/30 rounded-xl text-sm font-semibold backdrop-blur-sm">Gagal</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ DETAIL ═══════════ -->
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-8">
    <div class="glass-card p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 text-sm">
            <div>
                <h4 class="font-display font-semibold text-mountain-500 mb-3 flex items-center gap-2">
                    <span class="w-7 h-7 bg-forest-100 rounded-lg flex items-center justify-center text-xs">🏔️</span>
                    Informasi Pendakian
                </h4>
                <div class="space-y-3 bg-mountain-50 rounded-xl p-4">
                    <div>
                        <span class="text-mountain-400 text-xs font-medium block">Tanggal Pendakian</span>
                        <span class="font-semibold text-mountain-800">{{ $booking->jadwal->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                    <div>
                        <span class="text-mountain-400 text-xs font-medium block">Jumlah Rombongan</span>
                        <span class="font-semibold text-mountain-800">{{ $booking->jumlah_pendaki }} orang</span>
                    </div>
                    <div>
                        <span class="text-mountain-400 text-xs font-medium block">Harga Tiket</span>
                        <span class="text-mountain-800">Rp{{ number_format($booking->harga_per_orang, 0, ',', '.') }} / orang</span>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="font-display font-semibold text-mountain-500 mb-3 flex items-center gap-2">
                    <span class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center text-xs">👤</span>
                    Kontak Ketua Rombongan
                </h4>
                <div class="space-y-3 bg-mountain-50 rounded-xl p-4">
                    <div>
                        <span class="text-mountain-400 text-xs font-medium block">Ketua</span>
                        <span class="font-semibold text-mountain-800">{{ $booking->nama_ketua }}</span>
                    </div>
                    <div>
                        <span class="text-mountain-400 text-xs font-medium block">Telepon/WA</span>
                        <span class="text-mountain-800">{{ $booking->no_telepon }}</span>
                    </div>
                    <div>
                        <span class="text-mountain-400 text-xs font-medium block">No. Darurat (Keluarga)</span>
                        <span class="text-mountain-800">{{ $booking->no_darurat ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-mountain-400 text-xs font-medium block">Alamat</span>
                        <span class="text-mountain-800 text-xs">{{ $booking->alamat }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Members -->
        <div class="mb-8">
            <h4 class="font-display font-semibold text-mountain-500 text-sm mb-3 flex items-center gap-2">
                <span class="w-7 h-7 bg-amber-100 rounded-lg flex items-center justify-center text-xs">👥</span>
                Anggota Rombongan
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($booking->anggota as $anggota)
                    <div class="p-3 bg-mountain-50 border border-mountain-100 rounded-xl flex items-center gap-3 hover:bg-forest-50 hover:border-forest-200 transition-colors duration-200">
                        <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-forest-100 to-emerald-50 text-forest-700 font-bold text-xs flex items-center justify-center border border-forest-200">
                            {{ $anggota->urutan }}
                        </span>
                        <span class="text-sm font-semibold text-mountain-800">{{ $anggota->nama }}</span>
                        @if($anggota->urutan === 1)
                            <span class="badge-info text-[10px] px-2 py-0.5">Ketua</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="bg-gradient-to-r from-mountain-50 to-forest-50/30 border border-mountain-100 rounded-2xl p-5 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-xs text-mountain-400 block font-bold uppercase tracking-wider">Total Pembayaran</span>
                <span class="text-2xl font-bold font-display text-mountain-800">
                    Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                @if($booking->pembayaran && ($booking->pembayaran->status === 'menunggu' || $booking->pembayaran->status === 'gagal'))
                    <a href="{{ route('pendaki.pembayaran.show', $booking->pembayaran) }}" class="btn-primary w-full md:w-auto px-6 justify-center">
                        {{ $booking->pembayaran->status === 'gagal' ? 'Ulangi Pembayaran 💳' : 'Bayar Sekarang 💳' }}
                    </a>
                @endif
                @if($booking->eticket && $booking->eticket->status_validasi === 'valid')
                    <a href="{{ route('pendaki.eticket.show', $booking->eticket) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg w-full md:w-auto justify-center">
                        Lihat E-Ticket 🎟️
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
