@extends('layouts.pendaki')

@section('title', 'E-Ticket Pendakian')

@section('content')
<section class="hero-section py-8 md:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
            <div>
                <a href="{{ route('pendaki.booking.show', $eticket->booking) }}" class="inline-flex items-center gap-1.5 text-forest-300 hover:text-white text-sm font-medium transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Detail Booking
                </a>
                <h2 class="text-3xl font-display font-extrabold">E-Ticket Digital</h2>
                <p class="text-mountain-300 text-sm mt-1">Tunjukkan e-ticket ini ke petugas loket basecamp Cintanagara.</p>
            </div>
            <button onclick="downloadEticketImage()" id="btn-download-top" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg hover:shadow-emerald-500/25 transition-all duration-200 cursor-pointer self-start sm:self-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Download Gambar (PNG)</span>
            </button>
        </div>
    </div>
</section>

<!-- ═══════════ E-TICKET ═══════════ -->
<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-8">
    <div id="eticket-card" class="bg-white border-2 border-emerald-700 rounded-3xl overflow-hidden shadow-2xl relative" style="font-family: system-ui, -apple-system, sans-serif;">
        
        <!-- Header -->
        <div class="bg-[#0f3822] p-6 md:p-8 text-white relative">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-emerald-800 text-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0 border border-emerald-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 20l7-14 7 14M12 6v14"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-white uppercase tracking-wider leading-tight block mb-1">
                            E-TICKET PENDAKIAN
                        </h2>
                        <p class="text-xs text-emerald-200 font-normal leading-normal block">
                            Gunung Cikuray via Basecamp Cintanagara
                        </p>
                    </div>
                </div>

                <!-- Stamp LUNAS -->
                <div class="bg-emerald-600 text-white font-black text-xs md:text-sm uppercase tracking-widest px-3 py-1.5 rounded-xl border border-emerald-400 shadow-md flex-shrink-0">
                    ✓ LUNAS
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 md:p-8 space-y-6 bg-white">
            <!-- Info Grid -->
            @php
                $tanggalNaik = $eticket->booking->jadwal->tanggal;
                $tanggalTurun = $eticket->booking->tanggal_turun;
                $selisihHari = $tanggalTurun ? $tanggalNaik->diffInDays($tanggalTurun) : 0;
                $isTektok = $selisihHari == 0;
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-3 gap-5 text-sm border-b border-gray-100 pb-6">
                <div>
                    <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Nomor Tiket</span>
                    <span class="font-bold text-gray-900 font-mono text-sm leading-tight block">{{ $eticket->kode_tiket }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Kode Booking</span>
                    <span class="font-bold text-gray-900 font-mono text-sm leading-tight block">{{ $eticket->booking->kode_booking }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Tipe Pendakian</span>
                    @if($isTektok)
                        <span class="inline-block px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 leading-none">TEKTOK (PP)</span>
                    @else
                        <span class="inline-block px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 leading-none">CAMP</span>
                    @endif
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Tanggal Naik</span>
                    <span class="font-bold text-gray-800 leading-tight block">{{ $eticket->booking->jadwal->tanggal->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Tanggal Turun</span>
                    <span class="font-bold text-gray-800 leading-tight block">{{ $tanggalTurun ? $tanggalTurun->format('d/m/Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Jumlah Anggota</span>
                    <span class="font-bold text-gray-800 leading-tight block">{{ $eticket->booking->jumlah_pendaki }} orang</span>
                </div>
            </div>

            <!-- Leader Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 pb-6 text-sm">
                <div>
                    <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Ketua Rombongan</span>
                    <p class="font-bold text-gray-900 leading-snug">{{ $eticket->booking->nama_ketua }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">Telp: {{ $eticket->booking->no_telepon }}</p>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider mb-1">Alamat</span>
                    <p class="text-gray-700 text-xs leading-relaxed">{{ $eticket->booking->alamat }}</p>
                </div>
            </div>

            <!-- Kontak Darurat Basecamp -->
            <div class="p-3.5 bg-red-50 border border-red-200 rounded-xl flex items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600 font-bold text-sm flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <span class="font-bold text-red-900 block text-xs leading-tight">Kontak Darurat Basecamp</span>
                        <span class="text-red-700 text-[11px] block mt-0.5">Hubungi jika terjadi kendala / keadaan darurat di jalur</span>
                    </div>
                </div>
                <div class="px-3 py-1.5 bg-red-600 text-white font-bold rounded-lg text-xs flex-shrink-0 shadow-sm flex items-center gap-1">
                    <span>📞 0897-6869-943</span>
                </div>
            </div>

            <!-- Members -->
            <div class="space-y-2">
                <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider">Daftar Anggota Rombongan</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($eticket->booking->anggota as $anggota)
                        <div class="flex items-center gap-2.5 text-xs py-2 px-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <span class="w-5 h-5 bg-emerald-100 text-emerald-800 font-bold rounded flex items-center justify-center text-[10px] flex-shrink-0 border border-emerald-300">
                                {{ $loop->iteration }}
                            </span>
                            <span class="font-semibold text-gray-800 leading-tight truncate">{{ $anggota->nama }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ticket Number Barcode Header -->
            <div class="pt-6 border-t border-gray-100 flex flex-col items-center justify-center text-center">
                <span class="text-[9px] text-gray-400 uppercase tracking-widest font-bold mb-1">Nomor Tiket Masuk</span>
                <span class="text-base text-gray-900 font-mono font-bold tracking-widest px-4 py-1.5 bg-gray-100 rounded-lg border border-gray-200 block">
                    {{ $eticket->kode_tiket }}
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 border-t border-gray-100 p-4 text-center text-[10px] text-gray-500 font-medium leading-relaxed">
            PENTING: Harap membawa kartu identitas asli (KTP/SIM/Paspor) seluruh anggota saat melakukan verifikasi fisik di Basecamp Cintanagara.
        </div>
    </div>

    <!-- Action Buttons (PNG Download Only) -->
    <div class="mt-6 flex justify-center">
        <button onclick="downloadEticketImage()" id="btn-download-bottom" class="inline-flex items-center justify-center gap-2.5 px-8 py-3.5 bg-forest-600 hover:bg-forest-700 active:bg-forest-800 text-white font-bold text-sm rounded-2xl shadow-xl hover:shadow-forest-600/30 transition-all duration-200 cursor-pointer transform hover:-translate-y-0.5 w-full sm:w-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <span>Simpan Gambar E-Ticket (PNG)</span>
        </button>
    </div>
</section>

<!-- HTML2Canvas Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
async function downloadEticketImage() {
    const card = document.getElementById('eticket-card');
    const btnTop = document.getElementById('btn-download-top');
    const btnBottom = document.getElementById('btn-download-bottom');
    
    const setButtonState = (loading) => {
        if (btnTop) {
            btnTop.disabled = loading;
            const span = btnTop.querySelector('span');
            if (span) span.innerText = loading ? '⏳ Mengunduh...' : 'Download Gambar (PNG)';
        }
        if (btnBottom) {
            btnBottom.disabled = loading;
            const span = btnBottom.querySelector('span');
            if (span) span.innerText = loading ? '⏳ Mengunduh Gambar...' : 'Simpan Gambar E-Ticket (PNG)';
        }
    };

    setButtonState(true);

    try {
        if (typeof html2canvas === 'undefined') {
            alert('Pustaka pengunduhan gambar sedang dimuat. Silakan klik lagi dalam 2 detik.');
            setButtonState(false);
            return;
        }

        const canvas = await html2canvas(card, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false
        });

        const dataUrl = canvas.toDataURL('image/png', 1.0);
        const link = document.createElement('a');
        link.download = 'E-Ticket-Cikuray-{{ $eticket->kode_tiket }}.png';
        link.href = dataUrl;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        setButtonState(false);
    } catch (e) {
        console.error('html2canvas error:', e);
        alert('Gagal mengunduh gambar. Silakan coba kembali.');
        setButtonState(false);
    }
}
</script>
@endsection
