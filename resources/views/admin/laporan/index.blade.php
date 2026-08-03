@extends('layouts.admin')

@section('title', 'Laporan Rekapitulasi')
@section('page-title', '📈 Laporan & Rekapitulasi')
@section('page-subtitle', 'Analisis data statistik, pendapatan, dan rekap detail aktivitas pendakian.')

@section('content')
<div class="space-y-6 animate-fade-in print:p-0">
    <!-- Date Range & Status Filters Card (Hidden when printing) -->
    <div class="card p-5 print:hidden">
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Start Date -->
                <div>
                    <label for="dari" class="form-label text-xs">Tanggal Awal</label>
                    <input type="date" name="dari" id="dari" class="form-input text-xs py-2.5" 
                           value="{{ $dari }}" required>
                </div>

                <!-- End Date -->
                <div>
                    <label for="sampai" class="form-label text-xs">Tanggal Akhir</label>
                    <input type="date" name="sampai" id="sampai" class="form-input text-xs py-2.5" 
                           value="{{ $sampai }}" required>
                </div>

                <!-- Filter Status Pembayaran -->
                <div>
                    <label for="status_pembayaran" class="form-label text-xs">Status Pembayaran</label>
                    <select name="status_pembayaran" id="status_pembayaran" class="form-input text-xs py-2.5">
                        <option value="">Semua Pembayaran</option>
                        <option value="lunas" {{ $statusPembayaran === 'lunas' ? 'selected' : '' }}>Lunas / Berhasil</option>
                        <option value="belum_lunas" {{ $statusPembayaran === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas / Gagal</option>
                    </select>
                </div>

                <!-- Filter Status Aktivitas Mendaki -->
                <div>
                    <label for="status_mendaki" class="form-label text-xs">Status Pendakian</label>
                    <select name="status_mendaki" id="status_mendaki" class="form-input text-xs py-2.5">
                        <option value="">Semua Aktivitas</option>
                        <option value="belum_naik" {{ $statusMendaki === 'belum_naik' ? 'selected' : '' }}>Belum Naik (Menunggu)</option>
                        <option value="mendaki" {{ $statusMendaki === 'mendaki' ? 'selected' : '' }}>Sedang Mendaki</option>
                        <option value="sudah_turun" {{ $statusMendaki === 'sudah_turun' ? 'selected' : '' }}>Sudah Turun</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap md:flex-nowrap gap-3 pt-2 justify-end border-t border-mountain-100">
                @if($statusPembayaran || $statusMendaki)
                    <a href="{{ route('admin.laporan.index') }}" class="btn-secondary py-2 px-4 text-xs justify-center whitespace-nowrap">
                        Reset Filter
                    </a>
                @endif
                <button type="submit" class="btn-primary py-2 px-5 text-xs justify-center whitespace-nowrap">
                    🔍 Terapkan Filter
                </button>
                <button type="button" onclick="exportTableToCSV('Laporan_Cikuray_{{ $dari }}_to_{{ $sampai }}.csv')" class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl active:scale-95 transition-all duration-200 text-xs justify-center whitespace-nowrap">
                    📥 Unduh Excel (CSV)
                </button>
                <button type="button" onclick="window.print()" class="btn-secondary py-2 px-5 text-xs justify-center bg-white border border-mountain-250 whitespace-nowrap">
                    🖨️ Cetak / PDF
                </button>
            </div>
        </form>
    </div>

    <!-- Filter Info Header (Shown only when printing) -->
    <div class="hidden print:block border-b border-mountain-300 pb-4 mb-4 text-center">
        <h2 class="text-2xl font-display font-extrabold text-mountain-900 uppercase tracking-tight">Laporan Rekapitulasi Pendakian Gunung Cikuray</h2>
        <p class="text-sm text-mountain-500 mt-1.5 font-medium">Basecamp Cintanagara — Garut, Jawa Barat</p>
        <p class="text-xs text-mountain-600 mt-2 bg-mountain-50 inline-block px-3 py-1 rounded-full border border-mountain-200">
            Periode: {{ \Carbon\Carbon::parse($dari)->locale('id')->isoFormat('D MMMM Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->locale('id')->isoFormat('D MMMM Y') }}
        </p>
    </div>

    <!-- Summary Statistics Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-2xl shadow-sm border border-mountain-100 p-4 flex flex-col justify-between">
            <span class="text-[10px] text-mountain-400 font-bold uppercase tracking-wider">Total Booking</span>
            <div class="flex items-baseline justify-between mt-2">
                <h3 class="text-xl font-display font-bold text-mountain-800">{{ $totalBooking }}</h3>
                <span class="text-sm">🎟️</span>
            </div>
            <p class="text-[9px] text-mountain-400 mt-1">transaksi masuk</p>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-2xl shadow-sm border border-mountain-100 p-4 flex flex-col justify-between">
            <span class="text-[10px] text-mountain-400 font-bold uppercase tracking-wider">Total Pendaki</span>
            <div class="flex items-baseline justify-between mt-2">
                <h3 class="text-xl font-display font-bold text-mountain-800">{{ $totalPendaki }}</h3>
                <span class="text-sm">👥</span>
            </div>
            <p class="text-[9px] text-mountain-400 mt-1">orang terdaftar</p>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white rounded-2xl shadow-sm border border-mountain-100 p-4 flex flex-col justify-between">
            <span class="text-[10px] text-mountain-400 font-bold uppercase tracking-wider">Total Pendapatan</span>
            <div class="flex items-baseline justify-between mt-2">
                <h3 class="text-lg font-display font-bold text-forest-750">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <span class="text-sm">💰</span>
            </div>
            <p class="text-[9px] text-forest-550 font-medium mt-1">pembayaran lunas</p>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white rounded-2xl shadow-sm border border-mountain-100 p-4 flex flex-col justify-between">
            <span class="text-[10px] text-mountain-400 font-bold uppercase tracking-wider">Telah Check-In</span>
            <div class="flex items-baseline justify-between mt-2">
                <h3 class="text-xl font-display font-bold text-blue-700">{{ $totalCheckIn }}</h3>
                <span class="text-sm">🥾</span>
            </div>
            <p class="text-[9px] text-blue-500 font-medium mt-1">naik ke gunung</p>
        </div>

        <!-- Stat Card 5 -->
        <div class="bg-white rounded-2xl shadow-sm border border-mountain-100 p-4 flex flex-col justify-between">
            <span class="text-[10px] text-mountain-400 font-bold uppercase tracking-wider">Telah Check-Out</span>
            <div class="flex items-baseline justify-between mt-2">
                <h3 class="text-xl font-display font-bold text-forest-650">{{ $totalCheckOut }}</h3>
                <span class="text-sm">⛰️</span>
            </div>
            <p class="text-[9px] text-forest-550 font-medium mt-1">selesai & aman</p>
        </div>
    </div>

    <!-- Detail Reports -->
    <div class="space-y-6">
        <!-- Table Listing bookings (Full Width) -->
        <div class="card">
            <div class="px-6 py-5 border-b border-mountain-100 flex items-center justify-between">
                <h3 class="font-display font-bold text-mountain-800">Rincian Transaksi Booking</h3>
                <span class="text-[10px] text-mountain-400 font-semibold print:hidden">Menampilkan {{ $bookings->count() }} data transaksi</span>
            </div>
            <div class="overflow-x-auto">
                @if($bookings->isEmpty())
                    <div class="p-12 text-center">
                        <span class="text-3xl">📭</span>
                        <p class="text-sm text-mountain-400 mt-2">Tidak ada transaksi dalam periode filter ini.</p>
                    </div>
                @else
                    <table class="w-full whitespace-nowrap" id="report-table">
                        <thead>
                            <tr class="bg-mountain-50 border-b border-mountain-100">
                                <th class="table-th">Kode Booking</th>
                                <th class="table-th">Ketua</th>
                                <th class="table-th">Tanggal Naik</th>
                                <th class="table-th text-center">Jumlah</th>
                                <th class="table-th">Total Biaya</th>
                                <th class="table-th text-center">Status Pembayaran</th>
                                <th class="table-th text-center">Status Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-mountain-100">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-mountain-50/50 transition-colors">
                                    <td class="table-td font-semibold text-mountain-900 font-mono text-xs">{{ $booking->kode_booking }}</td>
                                    <td class="table-td font-medium text-mountain-850">{{ $booking->nama_ketua }}</td>
                                    <td class="table-td text-mountain-600">{{ $booking->jadwal->tanggal->format('d/m/Y') }}</td>
                                    <td class="table-td text-center font-semibold">{{ $booking->jumlah_pendaki }} org</td>
                                    <td class="table-td font-bold text-mountain-850">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                    <td class="table-td text-center">
                                        @if($booking->pembayaran && $booking->pembayaran->status === 'berhasil')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-forest-100 text-forest-700">Lunas</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td class="table-td text-center">
                                        @if(!$booking->eticket)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-mountain-100 text-mountain-500">Belum Naik</span>
                                        @elseif($booking->eticket->check_in_at && !$booking->eticket->check_out_at)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                Mendaki
                                            </span>
                                        @elseif($booking->eticket->check_in_at && $booking->eticket->check_out_at)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-forest-50 text-forest-700 border border-forest-100">
                                                Sudah Turun
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-mountain-100 text-mountain-500">Belum Naik</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination (Hidden when printing) -->
                    <div class="px-6 py-4 border-t border-mountain-100 print:hidden">
                        {{ $bookings->links('partials.pagination') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Hiker Distribution per date (Full Width Card) -->
        <div class="card">
            <div class="px-6 py-5 border-b border-mountain-100 flex items-center justify-between">
                <h3 class="font-display font-bold text-mountain-800">Distribusi Kuota Pendaki</h3>
                <span class="text-[10px] text-mountain-400 font-bold uppercase">Kapasitas 200/Hari</span>
            </div>
            
            <div class="p-6">
                @if($pendakiPerTanggal->isEmpty())
                    <div class="text-center py-6">
                        <span class="text-2xl">📅</span>
                        <p class="text-xs text-mountain-400 mt-1">Tidak ada jadwal pendakian aktif.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($pendakiPerTanggal as $dist)
                            @php
                                $percent = ($dist->total / 200) * 100;
                                $barColor = 'from-forest-500 to-emerald-400';
                                if ($percent >= 90) {
                                    $barColor = 'from-red-500 to-rose-400';
                                } elseif ($percent >= 70) {
                                    $barColor = 'from-amber-500 to-yellow-400';
                                }
                            @endphp
                            <div class="group p-3.5 bg-mountain-50 border border-mountain-100 rounded-xl hover:bg-forest-50/50 hover:border-forest-200 transition-all duration-200">
                                <div class="flex items-center justify-between text-xs mb-1.5">
                                    <span class="font-semibold text-mountain-700">
                                        {{ \Carbon\Carbon::parse($dist->tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}
                                    </span>
                                    <div class="flex items-center gap-1">
                                        <span class="font-bold text-mountain-800">{{ $dist->total }}</span>
                                        <span class="text-mountain-400 font-medium">/ 200</span>
                                    </div>
                                </div>
                                <div class="w-full bg-mountain-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r {{ $barColor }} h-full rounded-full transition-all duration-700 group-hover:opacity-85"
                                         style="width: {{ min(100, $percent) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body {
        background: white !important;
        color: black !important;
    }
    aside, header, #chatbot-window, form, button, nav, .print\:hidden {
        display: none !important;
    }
    main {
        padding: 0 !important;
        margin: 0 !important;
    }
    .card {
        box-shadow: none !important;
        border: 1px solid #cbd5e1 !important;
    }
}
</style>
@endsection

@push('scripts')
<script>
    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("#report-table tr");
        
        // Loop through all table rows
        for (var i = 0; i < rows.length; i++) {
            var row = [];
            var cols = rows[i].querySelectorAll("td, th");
            
            for (var j = 0; j < cols.length; j++) {
                // Remove tabs, newlines, and trim whitespaces from data
                var text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                // Escape double quotes
                text = text.replace(/"/g, '""');
                row.push('"' + text + '"');
            }
            
            csv.push(row.join(","));        
        }

        // Generate download of the CSV blob
        var csvFile = new Blob([csv.join("\n")], {type: "text/csv;charset=utf-8;"});
        var downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endpush
