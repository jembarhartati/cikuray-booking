@extends('layouts.pendaki')

@section('title', 'Status Booking Pendakian')

@section('content')
<!-- ═══════════ HERO ═══════════ -->
<section class="hero-section py-10 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 animate-fade-in-up">
            <div class="text-white">
                <p class="text-forest-300 text-sm font-medium mb-2">📋 Status Booking</p>
                <h2 class="text-3xl md:text-4xl font-display font-extrabold leading-tight">Riwayat Booking Tiket</h2>
                <p class="text-mountain-300 text-sm mt-2">Daftar dan status semua pemesanan tiket pendakian Anda.</p>
            </div>
            <a href="{{ route('pendaki.booking.create') }}" class="btn-primary shadow-xl shadow-forest-700/40 flex-shrink-0">
                + Booking Baru
            </a>
        </div>
    </div>
</section>

<!-- ═══════════ BOOKINGS LIST ═══════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-8">
    @if($bookings->isEmpty())
        <div class="glass-card p-12 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-mountain-100 to-mountain-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                📋
            </div>
            <h4 class="font-display font-bold text-mountain-700 text-lg">Belum Ada Transaksi</h4>
            <p class="text-sm text-mountain-400 mt-2 max-w-sm mx-auto">Anda belum memiliki riwayat pemesanan tiket pendakian.</p>
            <a href="{{ route('pendaki.booking.create') }}" class="btn-primary mt-5">🎫 Booking Sekarang</a>
        </div>
    @else
        <!-- Mobile: Card Layout / Desktop: Table -->
        <div class="space-y-4 md:hidden">
            @foreach($bookings as $booking)
                <div class="glass-card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-display font-bold text-mountain-900">{{ $booking->kode_booking }}</span>
                        <div class="flex gap-1.5">
                            @if($booking->status_booking === 'dikonfirmasi')
                                <span class="badge-success text-[10px]">Dikonfirmasi</span>
                            @elseif($booking->status_booking === 'menunggu')
                                <span class="badge-warning text-[10px]">Menunggu</span>
                            @else
                                <span class="badge-danger text-[10px]">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-2 text-xs text-mountain-500 mb-4">
                        <div class="flex justify-between">
                            <span>Tanggal</span>
                            <span class="font-semibold text-mountain-700">{{ $booking->jadwal->tanggal->locale('id')->isoFormat('D MMM Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Jumlah</span>
                            <span class="font-semibold text-mountain-700">{{ $booking->jumlah_pendaki }} orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total</span>
                            <span class="font-bold text-mountain-800">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Bayar</span>
                            @if(!$booking->pembayaran)
                                <span class="badge-danger text-[10px]">Belum Bayar</span>
                            @elseif($booking->pembayaran->status === 'berhasil')
                                <span class="badge-success text-[10px]">Lunas</span>
                            @elseif($booking->pembayaran->status === 'menunggu')
                                <span class="badge-warning text-[10px]">Menunggu</span>
                            @else
                                <span class="badge-danger text-[10px]">Gagal</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 pt-3 border-t border-mountain-100">
                        <a href="{{ route('pendaki.booking.show', $booking) }}" class="flex-1 text-center px-3 py-2 bg-mountain-100 text-mountain-700 hover:bg-mountain-200 rounded-xl text-xs font-semibold transition-all">Detail</a>
                        @if($booking->pembayaran && ($booking->pembayaran->status === 'menunggu' || $booking->pembayaran->status === 'gagal'))
                            <a href="{{ route('pendaki.pembayaran.show', $booking->pembayaran) }}" class="flex-1 text-center px-3 py-2 bg-forest-600 text-white hover:bg-forest-700 rounded-xl text-xs font-semibold transition-all">Bayar</a>
                        @endif
                        @if($booking->eticket && $booking->eticket->status_validasi === 'valid')
                            <a href="{{ route('pendaki.eticket.show', $booking->eticket) }}" class="flex-1 text-center px-3 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded-xl text-xs font-semibold transition-all">E-Ticket</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Desktop Table -->
        <div class="glass-card hidden md:block">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-mountain-50/50 border-b border-mountain-100">
                            <th class="table-th">Kode Booking</th>
                            <th class="table-th">Tanggal Pendakian</th>
                            <th class="table-th">Jumlah Pendaki</th>
                            <th class="table-th">Total Biaya</th>
                            <th class="table-th">Status Booking</th>
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
                                    @if($booking->status_booking === 'dikonfirmasi')
                                        <span class="badge-success">Dikonfirmasi</span>
                                    @elseif($booking->status_booking === 'menunggu')
                                        <span class="badge-warning">Menunggu</span>
                                    @else
                                        <span class="badge-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="table-td">
                                    @if(!$booking->pembayaran)
                                        <span class="badge-danger">Belum Bayar</span>
                                    @elseif($booking->pembayaran->status === 'berhasil')
                                        <span class="badge-success">Lunas</span>
                                    @elseif($booking->pembayaran->status === 'menunggu')
                                        <span class="badge-warning">Menunggu</span>
                                    @else
                                        <span class="badge-danger">Gagal</span>
                                    @endif
                                </td>
                                <td class="table-td">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('pendaki.booking.show', $booking) }}" class="px-3 py-1.5 bg-mountain-100 text-mountain-700 hover:bg-mountain-200 rounded-lg text-xs font-semibold transition-all duration-200">Detail</a>
                                        @if($booking->pembayaran && ($booking->pembayaran->status === 'menunggu' || $booking->pembayaran->status === 'gagal'))
                                            <a href="{{ route('pendaki.pembayaran.show', $booking->pembayaran) }}" class="px-3 py-1.5 bg-forest-600 text-white hover:bg-forest-700 rounded-lg text-xs font-semibold transition-all duration-200">Bayar</a>
                                        @endif
                                        @if($booking->eticket && $booking->eticket->status_validasi === 'valid')
                                            <a href="{{ route('pendaki.eticket.show', $booking->eticket) }}" class="px-3 py-1.5 bg-blue-600 text-white hover:bg-blue-700 rounded-lg text-xs font-semibold transition-all duration-200">E-Ticket</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-mountain-100">
                {{ $bookings->links('partials.pagination') }}
            </div>
        </div>

        <!-- Mobile Pagination -->
        <div class="md:hidden mt-4">
            {{ $bookings->links('partials.pagination') }}
        </div>
    @endif
</section>
@endsection
