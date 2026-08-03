@extends('layouts.admin')

@section('title', 'Data Pendaki')
@section('page-title', 'Data Pendaki')
@section('page-subtitle', 'Daftar seluruh pengguna yang terdaftar sebagai pendaki.')

@section('content')
<div class="card animate-fade-in">
    <div class="px-6 py-5 border-b border-mountain-100 flex items-center justify-between">
        <h3 class="font-display font-bold text-mountain-800 font-lg">Daftar Pendaki</h3>
        <span class="badge-gray">{{ $pendakis->total() }} Pendaki Terdaftar</span>
    </div>

    <div class="overflow-x-auto">
        @if($pendakis->isEmpty())
            <div class="p-8 text-center text-mountain-400">
                Belum ada data pendaki terdaftar.
            </div>
        @else
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-mountain-50 border-b border-mountain-100">
                        <th class="table-th">Nama Pendaki</th>
                        <th class="table-th">Email</th>
                        <th class="table-th">No. Telepon</th>
                        <th class="table-th">Alamat</th>
                        <th class="table-th text-center">Total Booking</th>
                        <th class="table-th text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mountain-100">
                    @foreach($pendakis as $user)
                        <tr class="hover:bg-mountain-50/50 transition-colors">
                            <td class="table-td font-semibold text-mountain-900">{{ $user->name }}</td>
                            <td class="table-td text-mountain-600">{{ $user->email }}</td>
                            <td class="table-td text-mountain-600">{{ $user->pendaki->no_telepon ?? '-' }}</td>
                            <td class="table-td text-mountain-600 max-w-xs truncate" title="{{ $user->pendaki->alamat ?? '' }}">
                                {{ $user->pendaki->alamat ?? '-' }}
                            </td>
                            <td class="table-td text-center font-bold text-mountain-800">
                                <span class="bg-mountain-100 text-mountain-700 px-2.5 py-1 rounded-full text-xs">
                                    {{ $user->bookings_count }}
                                </span>
                            </td>
                            <td class="table-td text-center">
                                <a href="{{ route('admin.pendaki.show', $user) }}" class="px-3 py-1.5 bg-mountain-100 hover:bg-mountain-200 text-mountain-750 rounded-lg text-xs font-semibold transition-all duration-200">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-mountain-100">
                {{ $pendakis->links('partials.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
