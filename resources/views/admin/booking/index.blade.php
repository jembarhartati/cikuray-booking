@extends('layouts.admin')

@section('title', 'Kelola Booking')
@section('page-title', 'Kelola Booking Tiket')
@section('page-subtitle', 'Pantau dan perbarui seluruh transaksi booking pendakian.')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Filter Search Bar -->
    <div class="card p-5">
        <form action="{{ route('admin.booking.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Search Text -->
            <div>
                <label for="search" class="form-label text-xs">Cari Kode / Nama</label>
                <input type="text" name="search" id="search" class="form-input text-xs py-2.5" 
                       placeholder="Cari kode booking / nama ketua..." value="{{ request('search') }}">
            </div>

            <!-- Date Filter -->
            <div>
                <label for="tanggal" class="form-label text-xs">Tanggal Pendakian</label>
                <input type="date" name="tanggal" id="tanggal" class="form-input text-xs py-2.5" 
                       value="{{ request('tanggal') }}">
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="form-label text-xs">Status Booking</label>
                <select name="status" id="status" class="form-input text-xs py-2.5">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="dikonfirmasi" {{ request('status') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="btn-primary py-2.5 text-xs flex-1 justify-center">
                    Cari 🔍
                </button>
                <a href="{{ route('admin.booking.index') }}" class="btn-secondary py-2.5 text-xs flex-1 justify-center border border-mountain-250 bg-white">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Booking Table -->
    <div class="card">
        <div class="px-6 py-5 border-b border-mountain-100 flex items-center justify-between">
            <h3 class="font-display font-bold text-mountain-800 font-lg">Daftar Pemesanan</h3>
            <span class="badge-gray">{{ $bookings->total() }} Transaksi</span>
        </div>

        <div class="overflow-x-auto">
            @if($bookings->isEmpty())
                <div class="p-8 text-center text-mountain-400">
                    Tidak ditemukan data booking yang cocok.
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="bg-mountain-50 border-b border-mountain-100">
                            <th class="table-th w-10"></th>
                            <th class="table-th text-left">Kode Booking</th>
                            <th class="table-th text-left">Ketua Rombongan</th>
                            <th class="table-th text-left">Tanggal Pendakian</th>
                            <th class="table-th text-center">Jumlah</th>
                            <th class="table-th text-left">Total Biaya</th>
                            <th class="table-th text-center">Status Booking</th>
                            <th class="table-th text-center">Pembayaran</th>
                            <th class="table-th text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-mountain-100">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-mountain-50/50 transition-colors cursor-pointer" onclick="toggleDetails('details-booking-{{ $booking->id }}', event)">
                                <td class="table-td text-center">
                                    <span class="text-xs text-mountain-400 font-semibold" id="icon-details-booking-{{ $booking->id }}">▶</span>
                                </td>
                                <td class="table-td font-semibold text-mountain-900 font-mono text-xs">{{ $booking->kode_booking }}</td>
                                <td class="table-td">
                                    <span class="font-medium block text-mountain-800 text-sm">{{ $booking->nama_ketua }}</span>
                                    <span class="text-[10px] text-mountain-400 block">Akun: {{ $booking->user->name }}</span>
                                </td>
                                <td class="table-td font-medium text-xs">
                                    {{ $booking->jadwal->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="table-td text-center text-xs font-semibold">{{ $booking->jumlah_pendaki }} orang</td>
                                <td class="table-td font-semibold text-mountain-900 text-xs">
                                    Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="table-td text-center">
                                    @if($booking->status_booking === 'dikonfirmasi')
                                        <span class="badge-success">Dikonfirmasi</span>
                                    @elseif($booking->status_booking === 'menunggu')
                                        <span class="badge-warning">Menunggu</span>
                                    @else
                                        <span class="badge-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="table-td text-center">
                                    @if(!$booking->pembayaran)
                                        <span class="badge-danger">Belum Dibuat</span>
                                    @elseif($booking->pembayaran->status === 'berhasil')
                                        <span class="badge-success">Lunas</span>
                                    @elseif($booking->pembayaran->status === 'menunggu')
                                        <span class="badge-warning">Pending</span>
                                    @else
                                        <span class="badge-danger">Gagal</span>
                                    @endif
                                </td>
                                <td class="table-td text-center" onclick="event.stopPropagation()">
                                    <a href="{{ route('admin.booking.show', $booking) }}" class="px-3 py-1.5 bg-mountain-100 hover:bg-mountain-200 text-mountain-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            <!-- Collapsible Row for Member list -->
                            <tr id="details-booking-{{ $booking->id }}" class="hidden bg-mountain-50/40" onclick="event.stopPropagation()">
                                <td></td>
                                <td colspan="8" class="p-4 border-b border-mountain-100">
                                    <div class="bg-white rounded-2xl border border-mountain-150 p-5 space-y-4 shadow-inner">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">No. Telepon / WA</span>
                                                <span class="font-bold text-mountain-800 text-sm">{{ $booking->no_telepon }}</span>
                                            </div>
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">Alamat Lengkap</span>
                                                <span class="font-medium text-mountain-800 text-xs">{{ $booking->alamat }}</span>
                                            </div>
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">Tanggal Turun</span>
                                                <span class="font-bold text-red-600 text-xs">
                                                    {{ $booking->tanggal_turun ? $booking->tanggal_turun->locale('id')->isoFormat('D MMMM Y') : 'Belum Ditentukan' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <span class="text-mountain-400 block text-[10px] font-bold uppercase mb-2">Daftar Anggota Rombongan ({{ $booking->jumlah_pendaki }} Orang)</span>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                                @foreach($booking->anggota as $anggota)
                                                    <div class="flex items-center gap-2.5 py-1.5 px-3 bg-mountain-50 border border-mountain-100 rounded-xl text-xs">
                                                        <span class="w-5.5 h-5.5 bg-forest-100 rounded-lg flex items-center justify-center font-bold text-forest-750 text-[10px] border border-forest-200">{{ $anggota->urutan }}</span>
                                                        <span class="font-semibold text-mountain-700">{{ $anggota->nama }}</span>
                                                        @if($anggota->urutan === 1)
                                                            <span class="badge-info text-[8px] px-1.5 py-0.5 ml-auto">Ketua</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-mountain-100">
                    {{ $bookings->links('partials.pagination') }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleDetails(id, event) {
        // Prevent toggling if clicked on input or link or inside action buttons
        if (event.target.tagName.toLowerCase() === 'a' || event.target.tagName.toLowerCase() === 'button' || event.target.closest('form')) {
            return;
        }
        
        const el = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
            icon.textContent = '▼';
        } else {
            el.classList.add('hidden');
            icon.textContent = '▶';
        }
    }
</script>
@endpush
@endsection
