@extends('layouts.pendaki')

@section('title', 'Pembayaran Tiket')

@section('content')
@php
    $activeTab = ($pembayaran->bukti_pembayaran || $pembayaran->status === 'gagal' || $pembayaran->status === 'ditolak') ? 'manual' : 'midtrans';
@endphp
<!-- ═══════════ HERO ═══════════ -->
<section class="hero-section py-8 md:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up">
        <a href="{{ route('pendaki.booking.show', $pembayaran->booking) }}" class="inline-flex items-center gap-1.5 text-forest-300 hover:text-white text-sm font-medium transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Detail Booking
        </a>
        <div class="text-white text-center max-w-2xl mx-auto">
            <p class="text-forest-300 text-sm font-medium mb-2">💳 Pembayaran</p>
            <h2 class="text-3xl md:text-4xl font-display font-extrabold leading-tight">Pembayaran Tiket</h2>
            <p class="text-mountain-300 text-sm mt-2">Selesaikan pembayaran Anda untuk menerbitkan e-ticket.</p>
        </div>
        <!-- Stepper -->
        <div class="flex items-center justify-center gap-0 mt-8 max-w-md mx-auto">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white/60 font-bold text-xs border border-white/20">✓</div>
                <span class="text-white/50 text-xs font-medium hidden sm:inline">Isi Data</span>
            </div>
            <div class="flex-1 h-px bg-white/30 mx-3"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-forest-700 font-bold text-xs shadow-lg">2</div>
                <span class="text-white text-xs font-medium hidden sm:inline">Bayar</span>
            </div>
            <div class="flex-1 h-px bg-white/30 mx-3"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white/60 font-bold text-xs border border-white/20">3</div>
                <span class="text-white/50 text-xs font-medium hidden sm:inline">E-Ticket</span>
            </div>
        </div>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Payment Methods (Shown first on mobile) -->
        <div class="glass-card p-6 md:p-8 order-1 md:order-2 md:col-span-2 space-y-6">
            @if($pembayaran->status === 'berhasil')
                <div class="text-center py-8 space-y-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-forest-100 to-emerald-50 rounded-full flex items-center justify-center text-4xl mx-auto shadow-lg shadow-forest-500/10">
                        ✅
                    </div>
                    <h3 class="font-display font-bold text-mountain-800 text-xl">Pembayaran Telah Lunas</h3>
                    <p class="text-sm text-mountain-500 max-w-sm mx-auto">Terima kasih, pembayaran Anda telah kami terima. E-ticket Anda telah diterbitkan dan dapat dilihat di halaman detail booking.</p>
                    <a href="{{ route('pendaki.booking.show', $pembayaran->booking) }}" class="btn-primary inline-flex mt-2">
                        Lihat Tiket Saya
                    </a>
                </div>
            @else
                @if($pembayaran->status === 'ditolak' || $pembayaran->status === 'gagal' || $pembayaran->catatan_penolakan)
                    <div class="p-5 bg-red-50 border-2 border-red-300 rounded-2xl text-sm text-red-850 space-y-2 mb-6 shadow-sm animate-shake">
                        <div class="flex items-center gap-2 font-bold text-base text-red-900">
                            <span class="text-xl">⚠️</span>
                            <span>Pembayaran Ditolak oleh Admin Basecamp</span>
                        </div>
                        <p class="text-xs text-red-750 leading-relaxed">
                            Maaf, bukti pembayaran yang Anda unggah sebelumnya ditolak atau tidak sesuai dengan mutasi rekening admin.
                        </p>
                        @if($pembayaran->catatan_penolakan)
                            <div class="text-xs font-semibold bg-white p-3.5 rounded-xl border border-red-200 text-red-900 shadow-inner space-y-1">
                                <span class="text-[10px] uppercase font-bold text-red-600 block tracking-wider">Alasan Penolakan dari Admin:</span>
                                <p class="italic font-mono text-xs">"{{ $pembayaran->catatan_penolakan }}"</p>
                            </div>
                        @endif
                        <p class="text-xs font-medium text-red-800 pt-1">
                            👉 <strong>Petunjuk:</strong> Silakan lakukan transfer ulang dan unggah bukti transfer yang baru pada pilihan <strong>Transfer Manual Bank Mandiri</strong> di bawah ini agar dapat diverifikasi ulang oleh admin.
                        </p>
                    </div>
                @endif

                <div>
                    <h3 class="font-display font-bold text-mountain-800 text-lg pb-1">Pilih Metode Pembayaran</h3>
                    <p class="text-xs text-mountain-500 mb-4">Pilih salah satu metode pembayaran berikut untuk memproses tiket Anda:</p>
                    
                    <!-- Responsive Payment Method Selector Tabs -->
                    @php
                        $activeTab = ($pembayaran->bukti_pembayaran || $pembayaran->status === 'gagal' || $pembayaran->status === 'ditolak') ? 'manual' : 'midtrans';
                    @endphp
                    <div class="grid grid-cols-2 gap-2.5 sm:gap-3 mb-5">
                        <button type="button" id="tab-btn-midtrans" onclick="switchTab('midtrans')" 
                                class="p-3 sm:p-4 rounded-2xl border-2 text-left transition-all duration-200 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 sm:gap-2 mb-1">
                                    <span class="text-base sm:text-lg">💳</span>
                                    <span class="font-bold text-xs sm:text-sm text-mountain-800">Otomatis</span>
                                </div>
                                <p class="text-[10px] sm:text-xs text-mountain-500 font-medium leading-tight">Midtrans (VA / QRIS)</p>
                            </div>
                            <span class="mt-2 text-[9px] sm:text-[10px] font-bold text-forest-700 bg-forest-100/70 px-2 py-0.5 rounded-md self-start">⚡ Langsung Lunas</span>
                        </button>

                        <button type="button" id="tab-btn-manual" onclick="switchTab('manual')" 
                                class="p-3 sm:p-4 rounded-2xl border-2 text-left transition-all duration-200 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 sm:gap-2 mb-1">
                                    <span class="text-base sm:text-lg">🏦</span>
                                    <span class="font-bold text-xs sm:text-sm text-mountain-800">Transfer Manual</span>
                                </div>
                                <p class="text-[10px] sm:text-xs text-mountain-500 font-medium leading-tight">Bank Mandiri</p>
                            </div>
                            <span class="mt-2 text-[9px] sm:text-[10px] font-bold text-amber-700 bg-amber-100/70 px-2 py-0.5 rounded-md self-start">⏳ Upload Bukti</span>
                        </button>
                    </div>
                </div>

                <!-- Tab Content 1: Midtrans -->
                <div id="tab-content-midtrans" class="p-5 bg-gradient-to-r from-forest-50 to-emerald-50 border border-forest-100 rounded-2xl space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-forest-100 rounded-xl flex items-center justify-center text-xl">💳</div>
                        <div>
                            <h4 class="font-bold text-forest-800 text-sm">Pembayaran Virtual Account / QRIS</h4>
                            <p class="text-xs text-forest-600">QRIS, Transfer Bank Virtual Account, Gopay, ShopeePay</p>
                        </div>
                    </div>

                    @if($snapToken)
                        <button id="pay-button" class="btn-primary w-full py-3.5 justify-center shadow-xl shadow-forest-600/30 text-base">
                            ⚡ Bayar Sekarang
                        </button>
                        <p class="text-xs text-forest-700 font-medium bg-forest-100/50 p-2.5 rounded-xl text-center">
                            ✅ Otomatis tervalidasi pembayaran / otomatis lunas tanpa menunggu validasi dari admin
                        </p>
                    @else
                        <div class="text-xs text-red-500 font-medium bg-red-50 p-3 rounded-xl">
                            Gagal menghubungkan ke Midtrans. Silakan gunakan metode transfer manual.
                        </div>
                    @endif
                </div>

                <!-- Tab Content 2: Transfer Manual -->
                <div id="tab-content-manual" class="border border-mountain-200 rounded-2xl p-5 space-y-4 hidden">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-mountain-100 rounded-xl flex items-center justify-center text-xl">🏦</div>
                        <div>
                            <h4 class="font-bold text-mountain-800 text-sm">Transfer Bank Manual</h4>
                            <p class="text-xs text-mountain-500">Transfer bank konvensional & verifikasi manual</p>
                        </div>
                    </div>
                    <p class="text-xs text-amber-700 font-medium bg-amber-50 p-2.5 rounded-xl border border-amber-200">
                        ⏳ Harus menunggu validasi dari admin untuk bukti pembayarannya
                    </p>

                    <!-- Bank Account Info Card -->
                    <div class="bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 text-white p-5 rounded-2xl shadow-xl relative overflow-hidden space-y-3.5 border border-blue-700/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xs bg-yellow-400 text-blue-950 px-2.5 py-1 rounded-lg font-black tracking-wider uppercase shadow-sm">BANK MANDIRI</span>
                            </div>
                            <span class="text-[11px] text-blue-200 font-medium">Transfer Bank Manual</span>
                        </div>

                        <div>
                            <span class="text-[10px] text-blue-200 uppercase tracking-widest block font-medium">Nomor Rekening Basecamp</span>
                            <div class="flex items-center justify-between gap-2 mt-1">
                                <span id="norek-text" class="font-mono font-extrabold text-xl sm:text-2xl tracking-widest text-yellow-300 drop-shadow">1770022419482</span>
                                <button type="button" onclick="copyToClipboard('1770022419482', 'btn-copy-norek')" id="btn-copy-norek" class="px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs font-bold rounded-xl transition-all duration-200 flex items-center gap-1 active:scale-95 border border-white/20 shrink-0">
                                    📋 Salin
                                </button>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-white/15 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                            <div>
                                <span class="text-blue-200 block text-[10px] uppercase font-semibold">Atas Nama Pemilik Rekening</span>
                                <span class="font-bold text-white text-sm tracking-wide">ABDUL ROHMAN</span>
                            </div>
                            <div class="bg-white/10 px-3 py-2 rounded-xl border border-white/10 text-left sm:text-right">
                                <span class="text-blue-200 block text-[10px] uppercase font-semibold">Nominal Transfer Harus Persis</span>
                                <div class="flex items-center sm:justify-end gap-1.5 mt-0.5">
                                    <span class="font-extrabold text-yellow-300 text-base font-display">Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                                    <button type="button" onclick="copyToClipboard('{{ $pembayaran->jumlah_bayar }}', 'btn-copy-nominal')" id="btn-copy-nominal" class="text-[10px] bg-white/20 hover:bg-white/30 text-white px-2 py-0.5 rounded-lg font-bold transition-all">
                                        Salin
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('pendaki.pembayaran.upload-bukti', $pembayaran) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label class="form-label text-xs font-bold text-mountain-700">📤 Unggah Bukti Transfer</label>
                            <!-- Custom Upload Zone -->
                            <label for="bukti_pembayaran" id="upload-zone" class="flex flex-col items-center justify-center w-full py-8 px-4 border-2 border-dashed border-forest-300 bg-gradient-to-br from-forest-50/50 to-emerald-50/30 rounded-2xl cursor-pointer hover:border-forest-500 hover:bg-forest-50 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-forest-100 rounded-2xl flex items-center justify-center text-2xl mb-3 group-hover:scale-110 transition-transform duration-300">
                                    📷
                                </div>
                                <p id="upload-text" class="text-sm font-bold text-forest-700 text-center">Klik di sini untuk pilih file</p>
                                <p id="upload-filename" class="hidden text-sm font-bold text-forest-800 text-center"></p>
                                <p class="text-[11px] text-mountain-400 mt-1.5 text-center">Format: JPG, PNG, PDF • Maks. <strong>5MB</strong></p>
                            </label>
                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="hidden" required accept=".jpg,.jpeg,.png,.pdf"
                                   onchange="handleFileSelect(this)">
                        </div>
                        
                        @if($pembayaran->bukti_pembayaran)
                            <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 flex items-center gap-2">
                                ⏳ Bukti sudah diunggah. Menunggu verifikasi admin. 
                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="font-bold underline text-amber-900 ml-auto">Lihat File</a>
                            </div>
                        @endif

                        <button type="submit" class="btn-primary w-full py-3.5 justify-center text-sm font-bold shadow-lg shadow-forest-600/20">
                            📤 Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Order Summary (Shown second on mobile) -->
        <div class="glass-card p-6 h-fit space-y-4 order-2 md:order-1">
            <h3 class="font-display font-bold text-mountain-800 text-sm border-b border-mountain-100 pb-2 flex items-center gap-2">
                <span class="w-6 h-6 bg-forest-100 rounded-lg flex items-center justify-center text-xs">📋</span>
                Ringkasan Pemesanan
            </h3>
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-mountain-400 block">Kode Booking</span>
                    <span class="font-semibold text-mountain-800 text-sm">{{ $pembayaran->booking->kode_booking }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block">Tanggal Pendakian</span>
                    <span class="font-semibold text-mountain-800">{{ $pembayaran->booking->jadwal->tanggal->locale('id')->isoFormat('D MMMM Y') }}</span>
                </div>
                <div>
                    <span class="text-mountain-400 block">Jumlah Rombongan</span>
                    <span class="font-semibold text-mountain-800">{{ $pembayaran->booking->jumlah_pendaki }} orang</span>
                </div>
                <div class="pt-3 border-t border-mountain-100 flex justify-between items-center text-sm">
                    <span class="text-mountain-600 font-medium">Total Tagihan</span>
                    <span class="font-bold text-forest-700 font-display text-lg">
                        Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function copyToClipboard(text, btnId) {
        navigator.clipboard.writeText(text).then(() => {
            const btn = document.getElementById(btnId);
            if (btn) {
                const origText = btn.innerHTML;
                btn.innerHTML = '✓ Tersalin';
                btn.classList.add('bg-emerald-500', 'text-white');
                setTimeout(() => {
                    btn.innerHTML = origText;
                    btn.classList.remove('bg-emerald-500', 'text-white');
                }, 2000);
            }
        });
    }

    function switchTab(tab) {
        const btnMidtrans = document.getElementById('tab-btn-midtrans');
        const btnManual = document.getElementById('tab-btn-manual');
        const contentMidtrans = document.getElementById('tab-content-midtrans');
        const contentManual = document.getElementById('tab-content-manual');

        if (tab === 'midtrans') {
            btnMidtrans.className = "p-3 sm:p-4 rounded-2xl border-2 text-left transition-all duration-200 flex flex-col justify-between border-forest-500 bg-forest-50/80 shadow-md";
            btnManual.className = "p-3 sm:p-4 rounded-2xl border-2 border-mountain-200 bg-white hover:border-mountain-300 text-left transition-all duration-200 opacity-70 flex flex-col justify-between";
            contentMidtrans.classList.remove('hidden');
            contentManual.classList.add('hidden');
        } else {
            btnManual.className = "p-3 sm:p-4 rounded-2xl border-2 text-left transition-all duration-200 flex flex-col justify-between border-amber-500 bg-amber-50/80 shadow-md";
            btnMidtrans.className = "p-3 sm:p-4 rounded-2xl border-2 border-mountain-200 bg-white hover:border-mountain-300 text-left transition-all duration-200 opacity-70 flex flex-col justify-between";
            contentManual.classList.remove('hidden');
            contentMidtrans.classList.add('hidden');
        }
    }

    function handleFileSelect(input) {
        const zone = document.getElementById('upload-zone');
        const text = document.getElementById('upload-text');
        const filename = document.getElementById('upload-filename');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes

            if (file.size > maxSize) {
                alert('⚠️ Ukuran file terlalu besar (' + (file.size / (1024 * 1024)).toFixed(2) + 'MB).\n\nMaksimal ukuran file yang diperbolehkan adalah 5MB. Silakan kompres atau pilih gambar yang lebih kecil.');
                input.value = '';
                text.classList.remove('hidden');
                filename.classList.add('hidden');
                zone.classList.add('border-forest-300', 'bg-gradient-to-br', 'from-forest-50/50', 'to-emerald-50/30');
                zone.classList.remove('border-forest-500', 'bg-forest-50');
                return;
            }

            text.classList.add('hidden');
            filename.classList.remove('hidden');
            filename.textContent = '✅ ' + file.name;
            zone.classList.remove('border-forest-300', 'bg-gradient-to-br', 'from-forest-50/50', 'to-emerald-50/30');
            zone.classList.add('border-forest-500', 'bg-forest-50');
        } else {
            text.classList.remove('hidden');
            filename.classList.add('hidden');
            zone.classList.add('border-forest-300', 'bg-gradient-to-br', 'from-forest-50/50', 'to-emerald-50/30');
            zone.classList.remove('border-forest-500', 'bg-forest-50');
        }
    }

    // Set initial tab state on load
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('tab-btn-midtrans')) {
            switchTab('{{ $activeTab }}');
        }
    });
</script>

@if($snapToken && $pembayaran->status === 'menunggu')
    @push('scripts')
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    window.location.href = "{{ route('pendaki.booking.show', $pembayaran->booking) }}";
                },
                onPending: function (result) {
                    window.location.reload();
                },
                onError: function (result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function () {
                    alert('Anda menutup popup sebelum menyelesaikan pembayaran.');
                }
            });
        });
    </script>
    @endpush
@endif
@endsection
