@extends('layouts.admin')

@section('title', 'Kelola Pembayaran')
@section('page-title', 'Kelola Pembayaran')
@section('page-subtitle', 'Verifikasi bukti pembayaran manual dan status transaksi digital.')

@section('content')
<div class="space-y-6 animate-fade-in">
    @php
        $pendingPaymentsCount = \App\Models\Pembayaran::where('status', 'menunggu')->count();
    @endphp
    @if($pendingPaymentsCount > 0)
        <div class="px-5 py-4 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-250 rounded-2xl text-amber-800 text-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 animate-fade-in shadow-sm">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0 text-base">⚠️</span>
                <div>
                    <p class="font-bold text-amber-900">Pembayaran Menunggu Verifikasi</p>
                    <p class="text-xs text-amber-700 font-medium">Terdapat {{ $pendingPaymentsCount }} pembayaran pending yang memerlukan konfirmasi dari admin.</p>
                </div>
            </div>
            @if(request('status') !== 'menunggu')
                <a href="{{ route('admin.pembayaran.index', ['status' => 'menunggu']) }}" class="btn-primary py-2 text-xs bg-amber-600 hover:bg-amber-700 border-0 shadow-sm text-white flex-shrink-0 self-stretch sm:self-auto justify-center">
                    Tampilkan Semua ➔
                </a>
            @endif
        </div>
    @endif
    <!-- Filter Bar -->
    <div class="card p-5">
        <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-4 items-end max-w-lg">
            <div class="flex-1">
                <label for="status" class="form-label text-xs">Filter Status Pembayaran</label>
                <select name="status" id="status" class="form-input text-xs py-2.5">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="berhasil" {{ request('status') === 'berhasil' ? 'selected' : '' }}>Berhasil (Lunas)</option>
                    <option value="gagal" {{ request('status') === 'gagal' ? 'selected' : '' }}>Gagal / Ditolak</option>
                    <option value="kedaluwarsa" {{ request('status') === 'kedaluwarsa' ? 'selected' : '' }}>Kedaluwarsa</option>
                </select>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="btn-primary py-2.5 text-xs">
                    Filter 🔍
                </button>
                <a href="{{ route('admin.pembayaran.index') }}" class="btn-secondary py-2.5 text-xs border border-mountain-250 bg-white">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="card">
        <div class="px-6 py-5 border-b border-mountain-100 flex items-center justify-between">
            <h3 class="font-display font-bold text-mountain-800 font-lg">Daftar Transaksi</h3>
            <span class="badge-gray">{{ $pembayarans->total() }} Transaksi</span>
        </div>

        <div class="overflow-x-auto">
            @if($pembayarans->isEmpty())
                <div class="p-8 text-center text-mountain-400">
                    Tidak ditemukan data pembayaran yang cocok.
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="bg-mountain-50 border-b border-mountain-100">
                            <th class="table-th w-10"></th>
                            <th class="table-th text-left">Order ID / Booking</th>
                            <th class="table-th text-left">Nama Pendaki</th>
                            <th class="table-th text-left">Tanggal Naik</th>
                            <th class="table-th text-left">Jumlah Bayar</th>
                            <th class="table-th text-left">Metode Pembayaran</th>
                            <th class="table-th text-center">Bukti Transfer</th>
                            <th class="table-th text-center">Status</th>
                            <th class="table-th text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-mountain-100">
                        @foreach($pembayarans as $pembayaran)
                            <tr class="hover:bg-mountain-50/50 transition-colors cursor-pointer" onclick="toggleDetails('details-pembayaran-{{ $pembayaran->id }}', event)">
                                <td class="table-td text-center">
                                    <span class="text-xs text-mountain-400 font-semibold" id="icon-details-pembayaran-{{ $pembayaran->id }}">▶</span>
                                </td>
                                <td class="table-td font-semibold text-mountain-900 font-mono text-xs">{{ $pembayaran->order_id }}</td>
                                <td class="table-td font-medium text-sm">{{ $pembayaran->booking->nama_ketua }}</td>
                                <td class="table-td text-mountain-600 text-xs">{{ $pembayaran->booking->jadwal->tanggal->format('d/m/Y') }}</td>
                                <td class="table-td font-semibold text-mountain-900 text-xs">
                                    Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                </td>
                                <td class="table-td font-medium text-mountain-700 text-xs">
                                    {{ $pembayaran->metode_pembayaran ?? 'Transfer Manual' }}
                                </td>
                                <td class="table-td text-center" onclick="event.stopPropagation()">
                                    @if($pembayaran->bukti_pembayaran)
                                        <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="badge-info text-[10px]">
                                            Ada Bukti 📄
                                        </a>
                                    @else
                                        <span class="text-mountain-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="table-td text-center">
                                    @if($pembayaran->status === 'berhasil')
                                        <span class="badge-success">Lunas</span>
                                    @elseif($pembayaran->status === 'menunggu')
                                        <span class="badge-warning">Pending</span>
                                    @else
                                        <span class="badge-danger">{{ ucfirst($pembayaran->status) }}</span>
                                    @endif
                                </td>
                                <td class="table-td text-center" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.pembayaran.show', $pembayaran) }}" class="px-3 py-1.5 bg-mountain-100 hover:bg-mountain-200 text-mountain-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- Collapsible Detail Row -->
                            <tr id="details-pembayaran-{{ $pembayaran->id }}" class="hidden bg-mountain-50/40" onclick="event.stopPropagation()">
                                <td></td>
                                <td colspan="8" class="p-4 border-b border-mountain-100">
                                    <div class="bg-white rounded-2xl border border-mountain-150 p-5 space-y-4 shadow-inner">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">No. Telepon / WA</span>
                                                <span class="font-bold text-mountain-800 text-sm">{{ $pembayaran->booking->no_telepon }}</span>
                                            </div>
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">Alamat Lengkap</span>
                                                <span class="font-medium text-mountain-800 text-xs">{{ $pembayaran->booking->alamat }}</span>
                                            </div>
                                            <div>
                                                <span class="text-mountain-400 block font-bold uppercase mb-0.5">Tanggal Turun</span>
                                                <span class="font-bold text-red-655 text-xs">
                                                    {{ $pembayaran->booking->tanggal_turun ? $pembayaran->booking->tanggal_turun->locale('id')->isoFormat('D MMMM Y') : 'Belum Ditentukan' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <span class="text-mountain-400 block text-[10px] font-bold uppercase mb-2">Daftar Anggota Rombongan ({{ $pembayaran->booking->jumlah_pendaki }} Orang)</span>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                                @foreach($pembayaran->booking->anggota as $anggota)
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
                    {{ $pembayarans->links('partials.pagination') }}
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
