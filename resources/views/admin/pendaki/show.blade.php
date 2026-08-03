@extends('layouts.admin')

@section('title', 'Detail Pendaki')
@section('page-title', 'Detail Profil Pendaki')
@section('page-subtitle', 'Informasi profil dan riwayat booking pendaki.')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.pendaki.index') }}" class="text-sm font-semibold text-mountain-500 hover:text-mountain-800 transition-colors flex items-center gap-1">
            ⬅ Kembali ke Daftar Pendaki
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Details Card (1 col) -->
        <div class="card p-6 h-fit space-y-6">
            <div class="text-center border-b border-mountain-100 pb-5">
                <div class="w-20 h-20 bg-amber-600 rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-3 shadow-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 class="font-display font-bold text-mountain-900 text-lg leading-tight">{{ $user->name }}</h3>
                <p class="text-xs text-mountain-400 mt-1">Akun Pendaki Terdaftar</p>
            </div>

            <div class="space-y-4 text-sm">
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Alamat Email</span>
                    <span class="font-semibold text-mountain-800">{{ $user->email }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Nomor Telepon</span>
                    <span class="font-semibold text-mountain-800">{{ $user->pendaki->no_telepon ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Alamat Rumah</span>
                    <span class="text-mountain-700 block text-xs leading-relaxed">{{ $user->pendaki->alamat ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block text-xs font-bold uppercase mb-0.5">Tanggal Registrasi</span>
                    <span class="font-semibold text-mountain-800">{{ $user->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>

        <!-- Bookings History Card (2 cols) -->
        <div class="card lg:col-span-2">
            <div class="px-6 py-5 border-b border-mountain-100">
                <h3 class="font-display font-bold text-mountain-800 font-lg">Riwayat Pemesanan Tiket</h3>
            </div>
            
            <div class="overflow-x-auto">
                @if($user->bookings->isEmpty())
                    <div class="p-8 text-center text-mountain-400">
                        Pendaki ini belum pernah melakukan booking tiket.
                    </div>
                @else
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-mountain-50 border-b border-mountain-100">
                                <th class="table-th">Kode Booking</th>
                                <th class="table-th">Tanggal Naik</th>
                                <th class="table-th">Anggota</th>
                                <th class="table-th">Biaya</th>
                                <th class="table-th">Status</th>
                                <th class="table-th">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-mountain-100">
                            @foreach($user->bookings as $booking)
                                <tr class="hover:bg-mountain-50/50 transition-colors">
                                    <td class="table-td font-semibold text-mountain-900">{{ $booking->kode_booking }}</td>
                                    <td class="table-td font-medium">
                                        {{ $booking->jadwal->tanggal->format('d/m/Y') }}
                                    </td>
                                    <td class="table-td">{{ $booking->jumlah_pendaki }} orang</td>
                                    <td class="table-td font-semibold text-mountain-900">
                                        Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="table-td">
                                        @if($booking->status_booking === 'dikonfirmasi')
                                            <span class="badge-success">Confirmed</span>
                                        @elseif($booking->status_booking === 'menunggu')
                                            <span class="badge-warning">Pending</span>
                                        @else
                                            <span class="badge-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="table-td">
                                        <a href="{{ route('admin.booking.show', $booking) }}" class="px-2.5 py-1 bg-mountain-100 hover:bg-mountain-200 text-mountain-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
