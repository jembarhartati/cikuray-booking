@extends('layouts.admin')

@section('title', 'Jadwal Pendakian')
@section('page-title', 'Jadwal & Kuota Pendakian')
@section('page-subtitle', 'Kelola kuota harian dan status aktif jadwal pendakian.')

@section('content')
<div class="card animate-fade-in">
    <div class="px-6 py-5 border-b border-mountain-100 flex items-center justify-between">
        <h3 class="font-display font-bold text-mountain-800 font-lg">Daftar Jadwal</h3>
        <a href="{{ route('admin.jadwal.create') }}" class="btn-primary py-2 text-xs">
            + Tambah Jadwal
        </a>
    </div>

    <div class="overflow-x-auto">
        @if($jadwals->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-mountain-100 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                    📅
                </div>
                <h4 class="font-display font-bold text-mountain-700">Belum Ada Jadwal Pendakian</h4>
                <p class="text-sm text-mountain-400 mt-1 max-w-sm mx-auto">Silakan buat jadwal pendakian pertama Anda untuk membuka pintu booking bagi pendaki.</p>
                <a href="{{ route('admin.jadwal.create') }}" class="btn-primary mt-4">
                    Buat Jadwal Pertama
                </a>
            </div>
        @else
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-mountain-50 border-b border-mountain-100">
                        <th class="table-th">Hari & Tanggal</th>
                        <th class="table-th text-center">Kuota Maksimal</th>
                        <th class="table-th text-center">Kuota Terisi</th>
                        <th class="table-th text-center">Sisa Kuota</th>
                        <th class="table-th">Keterangan</th>
                        <th class="table-th text-center">Status</th>
                        <th class="table-th text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-mountain-100">
                    @foreach($jadwals as $jadwal)
                        <tr class="hover:bg-mountain-50/50 transition-colors">
                            <td class="table-td font-semibold text-mountain-900">
                                {{ $jadwal->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </td>
                            <td class="table-td text-center">{{ $jadwal->kuota_maksimal }}</td>
                            <td class="table-td text-center font-medium">{{ $jadwal->kuota_terisi }}</td>
                            <td class="table-td text-center font-bold {{ $jadwal->sisa_kuota <= 50 ? 'text-red-600' : 'text-forest-700' }}">
                                {{ $jadwal->sisa_kuota }}
                            </td>
                            <td class="table-td text-mountain-500 max-w-xs truncate" title="{{ $jadwal->keterangan }}">
                                {{ $jadwal->keterangan ?? '-' }}
                            </td>
                            <td class="table-td text-center">
                                <form action="{{ route('admin.jadwal.toggle-status', $jadwal) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="cursor-pointer select-none">
                                        @if($jadwal->status === 'aktif')
                                            <span class="badge-success">Aktif</span>
                                        @else
                                            <span class="badge-danger">Nonaktif</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="table-td text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="px-2.5 py-1.5 bg-mountain-100 hover:bg-mountain-200 text-mountain-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-650 rounded-lg text-xs font-semibold transition-all duration-200">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-mountain-100">
                {{ $jadwals->links('partials.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
