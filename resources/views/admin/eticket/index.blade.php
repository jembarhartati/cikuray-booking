@extends('layouts.admin')

@section('title', 'Validasi Pendaki (Naik & Turun)')
@section('page-title', 'Validasi Pendaki (Naik & Turun)')
@section('page-subtitle', 'Pantau dan konfirmasi status naik (check-in) dan turun (check-out) rombongan pendaki secara real-time.')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Filter Bar -->
    <div class="card p-5">
        <form action="{{ route('admin.eticket.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-4 items-end w-full">
            <div class="w-full md:w-1/3">
                <label for="search" class="form-label text-xs">Cari Nama Ketua</label>
                <input type="text" name="search" id="search" class="form-input text-xs py-2.5 bg-white" 
                       placeholder="Masukkan nama ketua rombongan..." value="{{ request('search') }}">
            </div>
            <div class="w-full md:w-1/3">
                <label for="status" class="form-label text-xs">Filter Status Pendakian</label>
                <select name="status" id="status" class="form-input text-xs py-2.5">
                    <option value="">-- Semua Status --</option>
                    <option value="belum_naik" {{ request('status') === 'belum_naik' ? 'selected' : '' }}>Belum Naik</option>
                    <option value="mendaki" {{ request('status') === 'mendaki' ? 'selected' : '' }}>Sedang Mendaki</option>
                    <option value="sudah_turun" {{ request('status') === 'sudah_turun' ? 'selected' : '' }}>Sudah Turun</option>
                </select>
            </div>
            
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="btn-primary py-2.5 text-xs px-5 justify-center flex-1 md:flex-none">
                    Filter & Cari 🔍
                </button>
                <a href="{{ route('admin.eticket.index') }}" class="btn-secondary py-2.5 text-xs border border-mountain-250 bg-white px-5 justify-center flex-1 md:flex-none">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- E-Tickets Table -->
    <div class="card">
        <div class="px-6 py-5 border-b border-mountain-100 flex items-center justify-between">
            <h3 class="font-display font-bold text-mountain-800 font-lg">Daftar Status Pendaki</h3>
            <span class="badge-gray">{{ $etickets->total() }} Tiket</span>
        </div>

        <div class="overflow-x-auto">
            @if($etickets->isEmpty())
                <div class="p-8 text-center text-mountain-400">
                    Tidak ditemukan data tiket masuk pendaki.
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="bg-mountain-50 border-b border-mountain-100">
                            <th class="table-th w-10"></th>
                            <th class="table-th text-left">Kode E-Ticket</th>
                            <th class="table-th text-left">Kode Booking</th>
                            <th class="table-th text-left">Ketua Rombongan</th>
                            <th class="table-th text-left">Tanggal Naik</th>
                            <th class="table-th text-center">Status Pendakian</th>
                            <th class="table-th text-center">Check-In (Naik)</th>
                            <th class="table-th text-center">Check-Out (Turun)</th>
                            <th class="table-th text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-mountain-100">
                        @foreach($etickets as $eticket)
                            @php
                                $statusMendaki = 'belum_naik';
                                if ($eticket->check_in_at && !$eticket->check_out_at) {
                                    $statusMendaki = 'mendaki';
                                } elseif ($eticket->check_in_at && $eticket->check_out_at) {
                                    $statusMendaki = 'sudah_turun';
                                }
                            @endphp
                            <tr class="hover:bg-mountain-50/50 transition-colors cursor-pointer" onclick="toggleDetails('details-eticket-{{ $eticket->id }}', event)">
                                <td class="table-td text-center">
                                    <span class="text-xs text-mountain-400 font-semibold" id="icon-details-eticket-{{ $eticket->id }}">▶</span>
                                </td>
                                <td class="table-td font-semibold text-mountain-900 font-mono text-xs">{{ $eticket->kode_tiket }}</td>
                                <td class="table-td text-mountain-700 font-mono text-xs">{{ $eticket->booking->kode_booking }}</td>
                                <td class="table-td font-medium">
                                    <span class="block">{{ $eticket->booking->nama_ketua }}</span>
                                    <span class="text-[10px] text-mountain-450 block">Akun: {{ $eticket->booking->user->name }}</span>
                                </td>
                                <td class="table-td text-mountain-600 text-xs font-semibold">{{ $eticket->booking->jadwal->tanggal->format('d/m/Y') }}</td>
                                <td class="table-td text-center">
                                    @if($statusMendaki === 'belum_naik')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-250">Belum Naik</span>
                                    @elseif($statusMendaki === 'mendaki')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-250">Sedang Mendaki</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-forest-50 text-forest-700 border border-forest-250">Sudah Turun</span>
                                    @endif
                                </td>
                                <td class="table-td text-center text-xs font-mono text-mountain-600">
                                    {{ $eticket->check_in_at ? $eticket->check_in_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="table-td text-center text-xs font-mono text-mountain-600">
                                    {{ $eticket->check_out_at ? $eticket->check_out_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="table-td text-center" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-center gap-2">
                                        @if(!$eticket->check_in_at)
                                            <a href="{{ route('admin.eticket.show', $eticket) }}" class="px-3 py-1.5 bg-forest-600 hover:bg-forest-700 text-white rounded-lg text-[10px] font-bold shadow-sm transition-all duration-200 inline-flex items-center gap-1">
                                                🧗 Check-In →
                                            </a>
                                        @elseif(!$eticket->check_out_at)
                                            <a href="{{ route('admin.eticket.show', $eticket) }}" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-[10px] font-bold shadow-sm transition-all duration-200 inline-flex items-center gap-1">
                                                🚶 Check-Out →
                                            </a>
                                        @else
                                            <span class="text-xs text-forest-600 font-bold">Selesai ✓</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!-- Collapsible Row for Member list -->
                            <tr id="details-eticket-{{ $eticket->id }}" class="hidden bg-mountain-50/40" onclick="event.stopPropagation()">
                                <td></td>
                                <td colspan="8" class="p-4 border-b border-mountain-100">
                                    <div class="bg-white rounded-2xl border border-mountain-150 p-5 space-y-4 shadow-inner">
                                        @php
                                            $tNaik = $eticket->booking->jadwal->tanggal;
                                            $tTurun = $eticket->booking->tanggal_turun;
                                            $selisih = $tTurun ? $tNaik->diffInDays($tTurun) : 0;
                                            $tektok = $selisih == 0;
                                        @endphp
                                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-xs">
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">Tipe Pendakian</span>
                                                @if($tektok)
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 border border-blue-200">🏃 TEKTOK</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200">⛺ CAMP</span>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">No. Telepon / WA</span>
                                                <span class="font-bold text-mountain-800 text-sm">{{ $eticket->booking->no_telepon }}</span>
                                            </div>
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">No. HP Keluarga / Darurat</span>
                                                <span class="font-bold text-mountain-800 text-sm">{{ $eticket->booking->no_darurat ?? '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">Alamat</span>
                                                <span class="font-medium text-mountain-800 text-xs">{{ $eticket->booking->alamat }}</span>
                                            </div>
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">Jadwal Turun</span>
                                                <span class="font-bold text-red-600 text-xs">
                                                    {{ $eticket->booking->tanggal_turun ? $eticket->booking->tanggal_turun->locale('id')->isoFormat('D MMMM Y') : 'Belum Ditentukan' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <span class="text-mountain-400 block text-[10px] font-bold uppercase mb-2">Daftar Anggota Rombongan ({{ $eticket->booking->jumlah_pendaki }} Orang)</span>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                                @foreach($eticket->booking->anggota as $anggota)
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
                    {{ $etickets->links('partials.pagination') }}
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
