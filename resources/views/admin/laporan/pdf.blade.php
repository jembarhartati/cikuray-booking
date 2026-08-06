<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Pendakian</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            background-color: #f1f5f9;
            color: #0f172a;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            margin: 0;
            padding: 0;
        }

        .pdf-page-container {
            max-width: 1100px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            border: 1px solid #e2e8f0;
        }

        @media print {
            body {
                background: #ffffff !important;
            }
            .no-print {
                display: none !important;
            }
            .pdf-page-container {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }
        }
    </style>
</head>
<body>
    <!-- Top Action Bar (Hidden when printing) -->
    <div class="no-print sticky top-0 z-50 bg-slate-900/90 backdrop-blur-md text-white py-3 px-6 flex items-center justify-between shadow-lg">
        <div class="flex items-center gap-3">
            <span class="text-xl">📄</span>
            <div>
                <h1 class="text-sm font-bold leading-tight">Laporan Rekapitulasi Pendakian</h1>
                <p class="text-[11px] text-slate-400">Periode: {{ \Carbon\Carbon::parse($dari)->locale('id')->isoFormat('D MMMM Y') }} - {{ \Carbon\Carbon::parse($sampai)->locale('id')->isoFormat('D MMMM Y') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl active:scale-95 transition-all flex items-center gap-2 shadow-md">
                🖨️ Cetak / Simpan PDF
            </button>
            <button onclick="window.close()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold rounded-xl active:scale-95 transition-all">
                ✕ Tutup
            </button>
        </div>
    </div>

    <!-- PDF Document Preview Sheet -->
    <div class="pdf-page-container space-y-6">
        <!-- Header Dokumen Resmi -->
        <div class="border-b-2 border-slate-900 pb-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-forest-800 text-white rounded-2xl flex items-center justify-center text-3xl font-bold shadow-md">
                    🏔️
                </div>
                <div>
                    <h2 class="text-2xl font-display font-extrabold text-slate-900 uppercase tracking-tight">BASECAMP PENDAKIAN GUNUNG CIKURAY</h2>
                    <p class="text-xs font-medium text-slate-600">Jalur Resmi Cintanagara - Kecamatan Cigedug, Kabupaten Garut, Jawa Barat</p>
                    <p class="text-[11px] text-slate-500 mt-0.5">Kontak Resmi / Emergency: <strong>0897-6869-943</strong></p>
                </div>
            </div>

            <div class="text-right">
                <span class="inline-block px-3 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold uppercase rounded-lg border border-slate-200">DOKUMEN RESMI REKAPITULASI</span>
                <p class="text-[11px] text-slate-500 mt-1">Dicetak pada: <strong>{{ now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y - HH:mm') }} WIB</strong></p>
            </div>
        </div>

        <!-- Sub Title -->
        <div class="text-center bg-slate-50 p-3 rounded-xl border border-slate-200">
            <h3 class="text-base font-bold text-slate-900 uppercase tracking-wide">LAPORAN REKAPITULASI PENDAKIAN SELESAI (CHECK-OUT)</h3>
            <p class="text-xs text-slate-600 mt-0.5">
                Periode Laporan: <strong>{{ \Carbon\Carbon::parse($dari)->locale('id')->isoFormat('D MMMM Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($sampai)->locale('id')->isoFormat('D MMMM Y') }}</strong>
            </p>
        </div>

        <!-- Summary Stat Cards -->
        <div class="grid grid-cols-4 gap-3">
            <div class="p-3.5 bg-white rounded-xl border border-slate-200 shadow-sm text-xs">
                <span class="text-[10px] text-slate-500 font-bold uppercase block">Total Booking</span>
                <span class="text-lg font-bold text-slate-900 mt-1 block">{{ $totalBooking }} <span class="text-[11px] text-slate-400 font-normal">transaksi</span></span>
            </div>
            <div class="p-3.5 bg-white rounded-xl border border-slate-200 shadow-sm text-xs">
                <span class="text-[10px] text-slate-500 font-bold uppercase block">Total Pendaki</span>
                <span class="text-lg font-bold text-slate-900 mt-1 block">{{ $totalPendaki }} <span class="text-[11px] text-slate-400 font-normal">orang</span></span>
            </div>
            <div class="p-3.5 bg-white rounded-xl border border-slate-200 shadow-sm text-xs">
                <span class="text-[10px] text-slate-500 font-bold uppercase block">Total Pendapatan</span>
                <span class="text-lg font-bold text-forest-750 mt-1 block">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
            <div class="p-3.5 bg-white rounded-xl border border-slate-200 shadow-sm text-xs">
                <span class="text-[10px] text-slate-500 font-bold uppercase block">Pendaki Selesai (Check-Out)</span>
                <span class="text-lg font-bold text-emerald-700 mt-1 block">{{ $totalCheckOut }} <span class="text-[11px] text-slate-400 font-normal">orang</span></span>
            </div>
        </div>

        <!-- Table Listing -->
        <div class="space-y-2">
            <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Rincian Transaksi Booking Selesai (Check-Out)</h4>
            <div class="border border-slate-200 rounded-xl overflow-hidden">
                @if($bookings->isEmpty())
                    <div class="p-8 text-center text-xs text-slate-500">
                        Tidak ada transaksi pendakian selesai (check-out) pada periode ini.
                    </div>
                @else
                    <table class="w-full text-xs text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-bold uppercase text-[10px]">
                                <th class="p-2.5 border-r border-slate-200">No</th>
                                <th class="p-2.5 border-r border-slate-200">Kode Booking</th>
                                <th class="p-2.5 border-r border-slate-200">Nama Ketua</th>
                                <th class="p-2.5 border-r border-slate-200">Alamat Asal</th>
                                <th class="p-2.5 border-r border-slate-200">Tgl Naik</th>
                                <th class="p-2.5 border-r border-slate-200">Tgl Turun</th>
                                <th class="p-2.5 border-r border-slate-200 text-center">Jenis</th>
                                <th class="p-2.5 border-r border-slate-200 text-center">Jumlah</th>
                                <th class="p-2.5 border-r border-slate-200 text-right">Total Biaya</th>
                                <th class="p-2.5 text-center">Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($bookings as $index => $booking)
                                @php
                                    $tNaik = $booking->jadwal->tanggal;
                                    $tTurun = $booking->tanggal_turun;
                                    $selisih = $tTurun ? $tNaik->diffInDays($tTurun) : 0;
                                @endphp
                                <tr class="hover:bg-slate-50/60">
                                    <td class="p-2.5 text-center text-slate-500 border-r border-slate-200">{{ $index + 1 }}</td>
                                    <td class="p-2.5 font-mono font-bold text-slate-900 border-r border-slate-200">{{ $booking->kode_booking }}</td>
                                    <td class="p-2.5 font-bold text-slate-800 border-r border-slate-200">{{ $booking->nama_ketua }}</td>
                                    <td class="p-2.5 text-slate-600 border-r border-slate-200">{{ $booking->alamat }}</td>
                                    <td class="p-2.5 text-slate-700 border-r border-slate-200 whitespace-nowrap">{{ $booking->jadwal->tanggal->format('d/m/Y') }}</td>
                                    <td class="p-2.5 text-slate-700 border-r border-slate-200 whitespace-nowrap">{{ $booking->tanggal_turun ? $booking->tanggal_turun->format('d/m/Y') : '-' }}</td>
                                    <td class="p-2.5 text-center font-bold border-r border-slate-200">
                                        @if($selisih == 0)
                                            <span class="text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200 text-[10px]">Tektok</span>
                                        @else
                                            <span class="text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 text-[10px]">Camp</span>
                                        @endif
                                    </td>
                                    <td class="p-2.5 text-center font-bold text-slate-800 border-r border-slate-200">{{ $booking->jumlah_pendaki }} org</td>
                                    <td class="p-2.5 text-right font-bold text-slate-900 border-r border-slate-200">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                    <td class="p-2.5 text-center font-bold">
                                        @if($booking->pembayaran && $booking->pembayaran->status === 'berhasil')
                                            <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 text-[10px]">Lunas</span>
                                        @else
                                            <span class="text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 text-[10px]">Belum Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Signature Section -->
        <div class="pt-8 flex justify-between items-end text-xs">
            <div class="text-slate-500 text-[11px]">
                <p>* Laporan ini dihasilkan secara otomatis oleh Sistem Booking Cikuray via Cintanagara.</p>
            </div>
            <div class="text-center w-56 space-y-12">
                <div>
                    <p class="text-slate-600">Garut, {{ now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }}</p>
                    <p class="font-bold text-slate-900 mt-0.5">Petugas Basecamp Cintanagara</p>
                </div>
                <div>
                    <p class="font-bold text-slate-900 underline">( ABDUL ROHMAN )</p>
                    <p class="text-[10px] text-slate-500">Pengelola & Penanggung Jawab</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto trigger print dialog on page load
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 800);
        });
    </script>
</body>
</html>
