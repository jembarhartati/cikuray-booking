@extends('layouts.pendaki')

@section('title', 'E-Ticket Pendakian')

@section('content')
<section class="hero-section py-8 md:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up">
        <div class="text-white">
            <a href="{{ route('pendaki.booking.show', $eticket->booking) }}" class="inline-flex items-center gap-1.5 text-forest-300 hover:text-white text-sm font-medium transition-colors mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Detail Booking
            </a>
            <h2 class="text-3xl font-display font-extrabold">E-Ticket Digital</h2>
            <p class="text-mountain-300 text-sm mt-1">Tunjukkan e-ticket ini ke petugas loket basecamp Cintanagara.</p>
        </div>
    </div>
</section>

<!-- ═══════════ E-TICKET ═══════════ -->
<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-8 print:max-w-full print:p-0">
    <div class="bg-white border-2 border-forest-600 rounded-3xl overflow-hidden shadow-2xl relative">
        <!-- Stamp -->
        <div class="absolute right-4 top-4 md:right-8 md:top-8 border-4 border-dashed border-forest-600 text-forest-600 font-display font-black text-xl md:text-2xl uppercase tracking-widest px-3 py-1 rounded-xl rotate-12 select-none opacity-80">
            LUNAS ✓
        </div>

        <!-- Header -->
        <div class="bg-gradient-to-r from-forest-800 via-forest-900 to-mountain-900 p-6 md:p-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -right-8 -top-8 w-32 h-32 border-2 border-white/20 rounded-full"></div>
                <div class="absolute -right-4 -bottom-4 w-24 h-24 border-2 border-white/10 rounded-full"></div>
            </div>
            <div class="flex items-center gap-4 relative">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl backdrop-blur-sm">
                    🏔️
                </div>
                <div>
                    <h2 class="text-xl md:text-2xl font-display font-extrabold tracking-wide uppercase">E-Ticket Pendakian</h2>
                    <p class="text-xs text-forest-200 mt-0.5">Gunung Cikuray via Basecamp Cintanagara</p>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 md:p-8 space-y-6">
            <!-- Info Grid -->
            @php
                $tanggalNaik = $eticket->booking->jadwal->tanggal;
                $tanggalTurun = $eticket->booking->tanggal_turun;
                $selisihHari = $tanggalTurun ? $tanggalNaik->diffInDays($tanggalTurun) : 0;
                $isTektok = $selisihHari == 0;
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-3 gap-5 text-sm border-b border-mountain-100 pb-6">
                <div>
                    <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Nomor Tiket</span>
                    <span class="font-bold text-mountain-800 font-mono text-sm">{{ $eticket->kode_tiket }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Kode Booking</span>
                    <span class="font-bold text-mountain-800 font-mono text-sm">{{ $eticket->booking->kode_booking }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Tipe Pendakian</span>
                    @if($isTektok)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">🏃 TEKTOK</span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">⛺ CAMP</span>
                    @endif
                </div>
                <div>
                    <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Tanggal Naik</span>
                    <span class="font-bold text-mountain-800">{{ $eticket->booking->jadwal->tanggal->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Tanggal Turun</span>
                    <span class="font-bold text-mountain-800">{{ $tanggalTurun ? $tanggalTurun->format('d/m/Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Jumlah Anggota</span>
                    <span class="font-bold text-mountain-800">{{ $eticket->booking->jumlah_pendaki }} orang</span>
                </div>
            </div>

            <!-- Leader Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-mountain-100 pb-6 text-sm">
                <div>
                    <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Ketua Rombongan</span>
                    <p class="font-semibold text-mountain-800">{{ $eticket->booking->nama_ketua }}</p>
                    <p class="text-mountain-500 text-xs mt-0.5">Telp: {{ $eticket->booking->no_telepon }}</p>
                </div>
                <div>
                    <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Alamat</span>
                    <p class="text-mountain-700 text-xs">{{ $eticket->booking->alamat }}</p>
                </div>
            </div>

            <!-- Members -->
            <div class="space-y-2">
                <span class="text-mountain-400 block text-[10px] font-bold uppercase tracking-wider">Daftar Anggota Rombongan</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($eticket->booking->anggota as $anggota)
                        <div class="flex items-center gap-2 text-xs py-2 px-3 bg-mountain-50 border border-mountain-100 rounded-lg">
                            <span class="w-6 h-6 bg-gradient-to-br from-forest-100 to-emerald-50 rounded-md flex items-center justify-center font-bold text-forest-700 text-[10px] border border-forest-200">{{ $anggota->urutan }}</span>
                            <span class="font-semibold text-mountain-700">{{ $anggota->nama }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ticket Number instead of barcode -->
            <div class="pt-6 border-t border-mountain-100 flex flex-col items-center justify-center gap-1">
                <span class="text-[9px] text-mountain-400 uppercase tracking-widest font-bold">Nomor Tiket Masuk</span>
                <span class="text-sm text-mountain-800 font-mono font-bold tracking-wider">{{ $eticket->kode_tiket }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gradient-to-r from-mountain-50 to-forest-50/30 border-t border-mountain-100 p-4 text-center text-[10px] text-mountain-500">
            PENTING: Harap membawa kartu identitas asli (KTP/SIM/Paspor) seluruh anggota saat melakukan verifikasi fisik di Basecamp Cintanagara.
        </div>
    </div>
</section>

<style>
@media print {
    body {
        background: white !important;
        color: black !important;
    }
    nav, footer, #chatbot-window, .print\:hidden {
        display: none !important;
    }
    main {
        padding: 0 !important;
        margin: 0 !important;
    }
    section.hero-section {
        display: none !important;
    }
    .card, .glass-card {
        box-shadow: none !important;
        border: 2px solid #16a34a !important;
    }
}
</style>
@endsection
