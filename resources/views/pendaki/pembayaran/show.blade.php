@extends('layouts.pendaki')

@section('title', 'Pembayaran Tiket')

@section('content')
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

<!-- ═══════════ PAYMENT CONTENT ═══════════ -->
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Order Summary -->
        <div class="glass-card p-6 h-fit space-y-4">
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

        <!-- Payment Methods -->
        <div class="glass-card p-6 md:p-8 md:col-span-2 space-y-6">
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
                @if($pembayaran->status === 'gagal')
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-750 space-y-1 mb-6">
                        <p class="font-bold flex items-center gap-1.5 text-base">❌ Pembayaran Ditolak</p>
                        <p class="text-xs text-red-700">Maaf, bukti pembayaran yang Anda unggah sebelumnya ditolak oleh admin.</p>
                        @if($pembayaran->catatan_penolakan)
                            <div class="text-xs font-semibold bg-white p-3 rounded-xl border border-red-150 mt-2 text-red-800">
                                <strong>Alasan Penolakan:</strong> {{ $pembayaran->catatan_penolakan }}
                            </div>
                        @endif
                        <p class="text-xs text-red-700 pt-1">Silakan lakukan transfer ulang dan unggah bukti transfer yang baru di bawah ini.</p>
                    </div>
                @endif

                <h3 class="font-display font-bold text-mountain-800 text-lg border-b border-mountain-100 pb-3">Pilih Metode Pembayaran</h3>

                <!-- Midtrans -->
                <div class="p-5 bg-gradient-to-r from-forest-50 to-emerald-50 border border-forest-100 rounded-2xl space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-forest-100 rounded-xl flex items-center justify-center text-xl">💳</div>
                        <div>
                            <h4 class="font-bold text-forest-800 text-sm">Pembayaran Melalui Virtual Account/Dompet Digital</h4>
                            <p class="text-xs text-forest-600">QRIS, Transfer Bank Virtual Account, Gopay, ShopeePay</p>
                        </div>
                    </div>

                    @if($snapToken)
                        <button id="pay-button" class="btn-primary w-full py-3.5 justify-center shadow-xl shadow-forest-600/30 text-base">
                            ⚡ Bayar Sekarang (Midtrans)
                        </button>
                        <p class="text-xs text-forest-700 font-medium bg-forest-100/50 p-2.5 rounded-xl text-center">
                            ✅ Otomatis tervalidasi pembayaran / otomatis lunas tanpa menunggu validasi dari admin
                        </p>
                    @else
                        <div class="text-xs text-red-500 font-medium bg-red-50 p-3 rounded-xl">
                            Gagal menghubungkan ke Midtrans. Silakan gunakan metode transfer manual di bawah.
                        </div>
                    @endif
                </div>

                <!-- Divider -->
                <div class="flex items-center gap-3 text-mountain-300 text-xs">
                    <hr class="flex-1 border-mountain-200">
                    <span class="font-semibold uppercase tracking-wider">Atau Transfer Manual</span>
                    <hr class="flex-1 border-mountain-200">
                </div>

                <!-- Manual Transfer -->
                <div class="border border-mountain-200 rounded-2xl p-5 space-y-4">
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

                    <div class="bg-mountain-50 p-4 rounded-xl text-sm text-mountain-700 space-y-1.5">
                        <p class="text-xs text-mountain-400">Silakan transfer ke nomor rekening berikut:</p>
                        <p class="font-bold text-mountain-800">Bank Mandiri: <span class="text-forest-700">1770022419482</span></p>
                        <p class="font-medium">A/N: ABDUL ROHMAN</p>
                        <p class="text-xs text-mountain-400 pt-1">Nominal harus persis: <span class="font-bold text-mountain-700">Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span></p>
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('pendaki.pembayaran.upload-bukti', $pembayaran) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label for="bukti_pembayaran" class="form-label text-xs">Unggah Bukti Transfer</label>
                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-input text-xs" required>
                            <span class="text-[10px] text-mountain-400 block mt-1">Format file: JPG, PNG, PDF (Maks. 2MB)</span>
                        </div>
                        
                        @if($pembayaran->bukti_pembayaran)
                            <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 flex items-center gap-2">
                                ⏳ Bukti sudah diunggah. Menunggu verifikasi admin. 
                                <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="font-bold underline text-amber-900 ml-auto">Lihat File</a>
                            </div>
                        @endif

                        <button type="submit" class="btn-secondary w-full py-3 justify-center text-sm font-bold border border-mountain-200 bg-white">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</section>

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
