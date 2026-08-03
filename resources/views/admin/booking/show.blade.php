@extends('layouts.admin')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking Tiket')
@section('page-subtitle', 'Lihat detail data rombongan pendaki dan status pemesanan.')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto animate-fade-in">
    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.booking.index') }}" class="text-sm font-semibold text-mountain-500 hover:text-mountain-800 transition-colors flex items-center gap-1">
            ⬅ Kembali ke Daftar Booking
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Booking Details & Members (2 cols) -->
        <div class="card lg:col-span-2 p-6 md:p-8 space-y-8">
            <!-- Header Info -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-mountain-100 pb-5 gap-4">
                <div>
                    <span class="text-xs text-mountain-400 font-bold block uppercase tracking-wider">Kode Booking</span>
                    <h2 class="text-2xl font-display font-extrabold text-mountain-900">{{ $booking->kode_booking }}</h2>
                </div>
                <div>
                    @if($booking->status_booking === 'dikonfirmasi')
                        <span class="badge-success text-sm px-4 py-1.5">Dikonfirmasi</span>
                    @elseif($booking->status_booking === 'menunggu')
                        <span class="badge-warning text-sm px-4 py-1.5">Menunggu</span>
                    @else
                        <span class="badge-danger text-sm px-4 py-1.5">Dibatalkan</span>
                    @endif
                </div>
            </div>

            <!-- Hiker Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div class="space-y-3">
                    <h4 class="font-semibold text-mountain-550 border-b border-mountain-100 pb-1">Detail Rombongan</h4>
                    <p class="text-mountain-800">
                        <span class="text-mountain-400 font-medium block">Tanggal Naik:</span> 
                        <span class="font-semibold">{{ $booking->jadwal->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                    </p>
                    <p class="text-mountain-800">
                        <span class="text-mountain-400 font-medium block">Jumlah Anggota:</span> 
                        <span class="font-semibold">{{ $booking->jumlah_pendaki }} orang</span>
                    </p>
                    <p class="text-mountain-800">
                        <span class="text-mountain-400 font-medium block">Akun Pemesan:</span> 
                        <span class="font-medium text-forest-700 underline">
                            <a href="{{ route('admin.pendaki.show', $booking->user) }}">{{ $booking->user->name }}</a>
                        </span>
                    </p>
                </div>

                <div class="space-y-3">
                    <h4 class="font-semibold text-mountain-550 border-b border-mountain-100 pb-1">Kontak Ketua Rombongan</h4>
                    <p class="text-mountain-800">
                        <span class="text-mountain-400 font-medium block">Nama Ketua:</span> 
                        <span class="font-semibold">{{ $booking->nama_ketua }}</span>
                    </p>
                    <p class="text-mountain-800">
                        <span class="text-mountain-400 font-medium block">No. Telepon / WA:</span> 
                        <span class="font-semibold">{{ $booking->no_telepon }}</span>
                    </p>
                    <p class="text-mountain-800">
                        <span class="text-mountain-400 font-medium block">No. HP Keluarga / Darurat:</span> 
                        <span class="font-semibold">{{ $booking->no_darurat ?? '-' }}</span>
                    </p>
                    <p class="text-mountain-800">
                        <span class="text-mountain-400 font-medium block">Alamat:</span> 
                        <span class="text-xs leading-relaxed text-mountain-600 block mt-0.5">{{ $booking->alamat }}</span>
                    </p>
                </div>
            </div>

            <!-- Members List -->
            <div class="space-y-3">
                <h4 class="font-semibold text-mountain-500 text-sm">Daftar Anggota Rombongan</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($booking->anggota as $anggota)
                        <div class="p-3 bg-mountain-50 border border-mountain-100 rounded-xl flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-mountain-200 text-mountain-600 font-bold text-xs flex items-center justify-center">
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
            
            @if($booking->catatan)
                <div class="bg-amber-50 border border-amber-250 p-4 rounded-xl text-sm text-amber-800">
                    <p class="font-bold">Catatan Pendaki:</p>
                    <p class="mt-1 text-xs leading-relaxed">{{ $booking->catatan }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions & Info (1 col) -->
        <div class="space-y-6">
            <!-- Update Status Card -->
            <div class="card p-6 space-y-4">
                <h3 class="font-display font-bold text-mountain-800 text-sm border-b border-mountain-100 pb-2">Ubah Status Pemesanan</h3>
                
                <form action="{{ route('admin.booking.update-status', $booking) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label for="status_booking" class="form-label text-xs">Status Booking</label>
                        <select name="status_booking" id="status_booking" class="form-input text-xs py-2">
                            <option value="menunggu" {{ $booking->status_booking === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="dikonfirmasi" {{ $booking->status_booking === 'dikonfirmasi' ? 'selected' : '' }}>Konfirmasi (Selesai/Lunas)</option>
                            <option value="dibatalkan" {{ $booking->status_booking === 'dibatalkan' ? 'selected' : '' }}>Batalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary w-full py-2.5 text-xs justify-center shadow-md">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Payment Details Card -->
            <div class="card p-6 space-y-4">
                <h3 class="font-display font-bold text-mountain-800 text-sm border-b border-mountain-100 pb-2">Status Pembayaran</h3>
                
                @if($booking->pembayaran)
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-mountain-400">Total Tagihan:</span>
                            <span class="font-bold text-mountain-800">Rp{{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-mountain-400">Metode Bayar:</span>
                            <span class="font-semibold text-mountain-800">{{ $booking->pembayaran->metode_pembayaran ?? 'Transfer Manual' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-mountain-400">Status Bayar:</span>
                            @if($booking->pembayaran->status === 'berhasil')
                                <span class="badge-success text-[10px]">Lunas</span>
                            @elseif($booking->pembayaran->status === 'menunggu')
                                <span class="badge-warning text-[10px]">Pending</span>
                            @else
                                <span class="badge-danger text-[10px]">{{ ucfirst($booking->pembayaran->status) }}</span>
                            @endif
                        </div>
                        
                        <div class="pt-3 border-t border-mountain-100">
                            <a href="{{ route('admin.pembayaran.show', $booking->pembayaran) }}" class="btn-secondary w-full py-2 text-xs justify-center bg-white border border-mountain-200">
                                Buka Detail Pembayaran ➔
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-xs text-red-500 font-semibold py-2">
                        Belum ada invoice pembayaran untuk pemesanan ini.
                    </div>
                @endif
            </div>

            <!-- E-Ticket Details Card -->
            @if($booking->eticket)
                <div class="card p-6 space-y-4">
                    <h3 class="font-display font-bold text-mountain-800 text-sm border-b border-mountain-100 pb-2">E-Ticket Digital</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-mountain-400">Nomor Tiket:</span>
                            <span class="font-bold text-mountain-800 font-mono text-xs">{{ $booking->eticket->kode_tiket }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-mountain-400">Validasi Fisik:</span>
                            @if($booking->eticket->status_validasi === 'valid')
                                <span class="badge-success text-[10px]">VALID ✓</span>
                            @elseif($booking->eticket->status_validasi === 'menunggu')
                                <span class="badge-warning text-[10px]">Menunggu Loket</span>
                            @else
                                <span class="badge-danger text-[10px]">Ditolak</span>
                            @endif
                        </div>
                        
                        <div class="pt-3 border-t border-mountain-100">
                            <a href="{{ route('admin.eticket.show', $booking->eticket) }}" class="btn-secondary w-full py-2 text-xs justify-center bg-white border border-mountain-200">
                                Buka Tiket Masuk ➔
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
