@extends('layouts.admin')

@section('title', 'Validasi Tiket')
@section('page-title', 'Detail Validasi E-Ticket')
@section('page-subtitle', 'Lakukan pencocokan identitas rombongan pendaki sebelum mengizinkan pendakian.')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto animate-fade-in">
    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.eticket.index') }}" class="text-sm font-semibold text-mountain-500 hover:text-mountain-800 transition-colors flex items-center gap-1">
            ⬅ Kembali ke Daftar E-Ticket
        </a>
    </div>

    <!-- main layout -->
    <div class="card overflow-hidden">
        <!-- Ticket Header Stub -->
        <div class="bg-gradient-to-r from-forest-800 to-forest-950 p-6 md:p-8 text-white relative">
            <!-- Stamp of Hiking Status -->
            <div class="absolute right-6 top-6 md:right-8 md:top-8 border-4 border-dashed px-3 py-1 text-sm font-display font-black uppercase tracking-wider rounded-xl select-none rotate-12">
                @if(!$eticket->check_in_at)
                    <span class="text-amber-300 border-amber-300">BELUM NAIK</span>
                @elseif(!$eticket->check_out_at)
                    <span class="text-blue-300 border-blue-300">MENDAKI</span>
                @else
                    <span class="text-forest-450 border-forest-450">SELESAI ✓</span>
                @endif
            </div>
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl">
                    🏔️
                </div>
                <div>
                    <h2 class="text-xl font-display font-extrabold tracking-wide uppercase">E-Ticket Loket Masuk</h2>
                    <p class="text-xs text-forest-200">Garut Basecamp Cintanagara · Gunung Cikuray</p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <!-- Information Grid -->
            @php
                $tanggalNaik = $eticket->booking->jadwal->tanggal;
                $tanggalTurun = $eticket->booking->tanggal_turun;
                $selisihHari = $tanggalTurun ? $tanggalNaik->diffInDays($tanggalTurun) : 0;
                $isTektok = $selisihHari == 0;
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm border-b border-mountain-100 pb-6">
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Nomor E-Ticket</span>
                    <span class="font-bold text-mountain-900 font-mono">{{ $eticket->kode_tiket }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Kode Booking</span>
                    <span class="font-bold text-mountain-900 font-mono">{{ $eticket->booking->kode_booking }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Tipe Pendakian</span>
                    @if($isTektok)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">🏃 TEKTOK</span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">⛺ CAMP</span>
                    @endif
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Tanggal Naik</span>
                    <span class="font-bold text-mountain-850">{{ $eticket->booking->jadwal->tanggal->locale('id')->isoFormat('D MMMM Y') }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Tanggal Turun</span>
                    <span class="font-bold text-red-600">{{ $tanggalTurun ? $tanggalTurun->locale('id')->isoFormat('D MMMM Y') : 'Belum Ditentukan' }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Total Pendaki</span>
                    <span class="font-bold text-mountain-850">{{ $eticket->booking->jumlah_pendaki }} orang</span>
                </div>
            </div>

            <!-- Details Rombongan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-mountain-100 pb-6 text-sm">
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-1">Ketua Rombongan</span>
                    <p class="font-bold text-mountain-900 text-base">{{ $eticket->booking->nama_ketua }}</p>
                    <p class="text-mountain-500 text-xs mt-0.5">No. WA: {{ $eticket->booking->no_telepon }}</p>
                    <p class="text-mountain-500 text-xs mt-0.5">No. HP Keluarga / Darurat: {{ $eticket->booking->no_darurat ?? '-' }}</p>
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-1">Alamat Rumah</span>
                    <p class="text-mountain-700 text-xs leading-relaxed">{{ $eticket->booking->alamat }}</p>
                </div>
            </div>

            <!-- Kontak Darurat Basecamp -->
            <div class="p-3.5 bg-red-50 border border-red-200 rounded-2xl flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center text-red-600 font-bold text-sm flex-shrink-0">
                        🚨
                    </div>
                    <div>
                        <span class="font-bold text-red-900 block text-xs">Kontak Darurat Basecamp</span>
                        <span class="text-red-700 text-[11px]">Nomor resmi petugas basecamp Cintanagara untuk darurat</span>
                    </div>
                </div>
                <a href="tel:08976869943" class="px-3.5 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-xs inline-flex items-center gap-1.5 shadow-sm transition-all duration-200">
                    📞 0897-6869-943
                </a>
            </div>

            <!-- Member List -->
            <div class="space-y-3">
                <span class="text-mountain-400 block text-xs font-bold uppercase">Daftar Anggota Pendaki (Harap cocokkan dengan KTP/Kartu Identitas)</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($eticket->booking->anggota as $anggota)
                        <div class="p-3 bg-mountain-50 border border-mountain-100 rounded-xl flex items-center gap-3">
                            <span class="text-xs font-bold text-mountain-400">{{ $anggota->urutan }}.</span>
                            <span class="text-sm font-semibold text-mountain-800">{{ $anggota->nama }}</span>
                            @if($anggota->urutan === 1)
                                <span class="badge-info text-[9px] px-1.5 py-0.5 ml-auto">Ketua</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Catatan Admin & Check-In / Check-Out Actions -->
            <div class="pt-6 border-t border-mountain-100 space-y-6">
                <!-- Status Logs -->
                <div class="bg-mountain-50 rounded-2xl p-5 border border-mountain-150 space-y-3">
                    <h4 class="font-display font-bold text-mountain-800 text-sm">Waktu Log Perjalanan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-mountain-100">
                            <span class="text-xl">🧗</span>
                            <div>
                                <span class="text-mountain-400 block font-semibold">Waktu Naik (Check-In)</span>
                                <span class="font-bold text-mountain-700">
                                    {{ $eticket->check_in_at ? $eticket->check_in_at->timezone('Asia/Jakarta')->format('d F Y - H:i') . ' WIB' : 'Belum Check-In' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-mountain-100">
                            <span class="text-xl">🚶</span>
                            <div>
                                <span class="text-mountain-400 block font-semibold">Waktu Turun (Check-Out)</span>
                                <span class="font-bold text-mountain-700">
                                    {{ $eticket->check_out_at ? $eticket->check_out_at->timezone('Asia/Jakarta')->format('d F Y - H:i') . ' WIB' : 'Belum Check-Out' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    @if(!$eticket->check_in_at)
                        <form action="{{ route('admin.eticket.check-in', $eticket) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin melakukan check-in naik untuk rombongan ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full btn-primary py-3 justify-center text-xs shadow-md">
                                🧗 Konfirmasi Check-In (Mulai Naik)
                            </button>
                        </form>
                    @elseif(!$eticket->check_out_at)
                        <form action="{{ route('admin.eticket.check-out', $eticket) }}" method="POST" class="flex-1 space-y-4" onsubmit="return confirm('Apakah Anda yakin ingin melakukan check-out turun untuk rombongan ini?')">
                            @csrf
                            @method('PATCH')
                            
                            <div class="bg-mountain-50 rounded-2xl p-5 border border-mountain-150 space-y-3">
                                <h4 class="font-display font-bold text-mountain-800 text-sm">Status Kelengkapan Rombongan saat Turun</h4>
                                <div class="flex gap-6">
                                    <label class="flex items-center gap-2 cursor-pointer select-none">
                                        <input type="radio" name="status_rombongan" value="lengkap" checked class="w-4 h-4 text-forest-605 focus:ring-forest-500 border-mountain-300">
                                        <span class="text-sm font-semibold text-mountain-850">Rombongan Lengkap (Semua Kembali)</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer select-none">
                                        <input type="radio" name="status_rombongan" value="tidak_lengkap" class="w-4 h-4 text-red-650 focus:ring-red-500 border-mountain-300">
                                        <span class="text-sm font-semibold text-red-650">Tidak Lengkap (Ada Anggota Tertinggal/Hilang)</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="w-full btn-danger py-3 justify-center text-xs shadow-md bg-red-600 hover:bg-red-700 text-white border-transparent">
                                🚶 Konfirmasi Check-Out (Kembali Turun)
                            </button>
                        </form>
                    @else
                        <div class="w-full space-y-4">
                            <div class="w-full text-center py-3.5 bg-forest-50 border border-forest-200 text-forest-750 font-bold rounded-2xl text-xs">
                                ✅ Rombongan Pendaki Telah Menyelesaikan Pendakian & Check-Out
                            </div>
                            <div class="p-4 bg-mountain-50 border border-mountain-150 rounded-2xl text-sm text-center">
                                <span class="text-mountain-500">Status Kelengkapan Rombongan:</span>
                                @if($eticket->status_rombongan === 'lengkap')
                                    <span class="font-bold text-forest-700 ml-1">Lengkap (Semua anggota kembali)</span>
                                @else
                                    <span class="font-bold text-red-650 ml-1">Tidak Lengkap (Ada anggota belum kembali/tertinggal)</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
@endsection
