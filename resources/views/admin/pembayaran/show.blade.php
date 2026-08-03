@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Detail Verifikasi Pembayaran')
@section('page-subtitle', 'Periksa bukti transaksi dan verifikasi untuk menerbitkan e-ticket.')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto animate-fade-in">
    <!-- Back Navigation -->
    <div>
        <a href="{{ route('admin.pembayaran.index') }}" class="text-sm font-semibold text-mountain-500 hover:text-mountain-800 transition-colors flex items-center gap-1">
            ⬅ Kembali ke Daftar Pembayaran
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Details Column (1 col) -->
        <div class="space-y-6">
            <!-- Payment Summary -->
            <div class="card p-6 md:p-8 space-y-6">
                <h3 class="font-display font-bold text-mountain-800 text-sm border-b border-mountain-100 pb-2">Informasi Pembayaran</h3>
                
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-mountain-400 font-medium">Order ID:</span>
                        <span class="font-bold text-mountain-900">{{ $pembayaran->order_id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-mountain-400 font-medium">Nama Pendaki:</span>
                        <span class="font-semibold text-mountain-900">
                            <a href="{{ route('admin.pendaki.show', $pembayaran->booking->user) }}" class="text-forest-700 underline">
                                {{ $pembayaran->booking->user->name }}
                            </a>
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-mountain-400 font-medium">Tanggal Pendakian:</span>
                        <span class="font-semibold text-mountain-850">
                            {{ $pembayaran->booking->jadwal->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-mountain-400 font-medium">Jumlah Rombongan:</span>
                        <span class="font-semibold text-mountain-800">{{ $pembayaran->booking->jumlah_pendaki }} orang</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-mountain-100">
                        <span class="text-mountain-600 font-medium text-base">Total Bayar:</span>
                        <span class="font-extrabold text-forest-700 font-display text-lg">
                            Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-mountain-400 font-medium">Status Saat Ini:</span>
                        @if($pembayaran->status === 'berhasil')
                            <span class="badge-success">Berhasil (Lunas)</span>
                        @elseif($pembayaran->status === 'menunggu')
                            <span class="badge-warning">Menunggu Verifikasi</span>
                        @else
                            <span class="badge-danger">{{ ucfirst($pembayaran->status) }}</span>
                        @endif
                    </div>
                    
                    @if($pembayaran->paid_at)
                        <div class="flex justify-between items-center">
                            <span class="text-mountain-400 font-medium">Waktu Lunas:</span>
                            <span class="font-semibold text-mountain-800">{{ $pembayaran->paid_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                        </div>
                    @endif
                </div>
            </div>            <!-- Admin Actions Form -->
            @if($pembayaran->status === 'menunggu')
                <div class="card p-6 space-y-4">
                    <h3 class="font-display font-bold text-mountain-800 text-sm border-b border-mountain-100 pb-2">Tindakan Persetujuan</h3>
                    <p class="text-xs text-mountain-500">Silakan periksa bukti transfer di sebelah kanan sebelum memverifikasi pembayaran ini.</p>
                    
                    <!-- Verify Action -->
                    <form action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pembayaran ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-primary w-full py-3 justify-center text-xs shadow-md font-bold">
                            Terima Pembayaran ✓
                        </button>
                    </form>

                    <div class="border-t border-mountain-100 my-4"></div>

                    <!-- Reject Action -->
                    <form action="{{ route('admin.pembayaran.tolak', $pembayaran) }}" method="POST" class="space-y-3" onsubmit="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label for="catatan_penolakan" class="block text-xs font-bold text-mountain-600 uppercase mb-1">Catatan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="catatan_penolakan" id="catatan_penolakan" rows="2" class="form-input text-xs" placeholder="Masukkan alasan penolakan pembayaran..." required></textarea>
                        </div>

                        <button type="submit" class="btn-danger w-full py-3 justify-center text-xs shadow-md bg-red-650 hover:bg-red-700 text-white font-bold">
                            Tolak Pembayaran ✕
                        </button>
                    </form>
                </div>
            @elseif($pembayaran->status === 'gagal')
                <div class="card p-6 space-y-4">
                    <h3 class="font-display font-bold text-red-700 text-sm border-b border-red-100 pb-2 flex items-center gap-2">
                        <span>❌</span> Pembayaran Ditolak
                    </h3>
                    <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700">
                        <strong class="block mb-1">Catatan Penolakan:</strong>
                        <p class="leading-relaxed">{{ $pembayaran->catatan_penolakan ?? 'Tidak ada catatan.' }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Proof of Payment Column (1 col) -->
        <div class="card p-6 md:p-8 space-y-4 flex flex-col">
            <h3 class="font-display font-bold text-mountain-800 text-sm border-b border-mountain-100 pb-2 flex-shrink-0">Bukti Pembayaran</h3>
            
            <div class="flex-1 min-h-[300px] bg-mountain-50 border border-mountain-200 rounded-2xl flex items-center justify-center overflow-hidden p-2">
                @if($pembayaran->bukti_pembayaran)
                    @php
                        $ext = strtolower(pathinfo($pembayaran->bukti_pembayaran, PATHINFO_EXTENSION));
                    @endphp
                    
                    @if($ext === 'pdf')
                        <div class="text-center p-6 space-y-4">
                            <span class="text-5xl">📄</span>
                            <h4 class="font-bold text-mountain-800 text-sm">Dokumen Bukti PDF</h4>
                            <p class="text-xs text-mountain-400">File bukti pembayaran diunggah dalam format PDF.</p>
                            <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="btn-secondary py-2 justify-center bg-white border border-mountain-200 text-xs">
                                Buka File PDF ➔
                            </a>
                        </div>
                    @else
                        <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" title="Klik untuk memperbesar gambar" class="block hover:opacity-90 transition-opacity">
                            <img src="{{ Storage::url($pembayaran->bukti_pembayaran) }}" alt="Bukti Transfer" class="max-w-full max-h-[450px] object-contain rounded-xl shadow-sm">
                        </a>
                    @endif
                @else
                    <div class="text-center p-6 text-mountain-400 space-y-2">
                        <span class="text-4xl">❌</span>
                        <p class="text-sm font-semibold">Bukti Pembayaran Belum Diunggah</p>
                        <p class="text-xs max-w-xs mx-auto">Pendaki belum mengunggah file bukti transfer bank manual untuk tagihan ini.</p>
                    </div>
                @endif
            </div>
            
            @if($pembayaran->bukti_pembayaran)
                <div class="text-center flex-shrink-0">
                    <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="text-xs text-forest-600 hover:text-forest-700 font-bold underline">
                        Buka Bukti di Tab Baru ↗
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
