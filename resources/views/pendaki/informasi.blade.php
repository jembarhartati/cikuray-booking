@extends('layouts.pendaki')

@section('title', 'Informasi Gunung Cikuray')

@section('content')
<!-- ═══════════ HERO IMAGE ═══════════ -->
<section class="relative h-72 md:h-96 flex items-end overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/10 z-10"></div>
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/gunung-cikuray.png') }}')"></div>
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 w-full">
        <span class="px-3 py-1 bg-forest-600/90 backdrop-blur-sm rounded-full text-xs font-semibold text-white tracking-wider inline-block mb-3">📍 Garut, Jawa Barat</span>
        <h2 class="text-3xl md:text-4xl font-display font-extrabold text-white leading-tight">Gunung Cikuray via Cintanagara</h2>
        <p class="text-mountain-300 text-sm mt-2 max-w-xl">Gunung tertinggi keempat di Jawa Barat dengan pemandangan samudera awan yang memukau dan jalur menantang.</p>
    </div>
</section>

<!-- ═══════════ QUICK INFO CARDS ═══════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="glass-card p-6">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-forest-50 rounded-xl flex items-center justify-center text-2xl">💰</div>
                <div>
                    <h4 class="font-display font-bold text-mountain-800">Harga Tiket Masuk</h4>
                    <p class="text-xs text-mountain-400">Tarif retribusi resmi</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-forest-700 font-display">Rp30.000 <span class="text-xs text-mountain-400 font-normal">/ orang / hari</span></p>
        </div>

        <div class="glass-card p-6">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-sky-50 rounded-xl flex items-center justify-center text-2xl">👥</div>
                <div>
                    <h4 class="font-display font-bold text-mountain-800">Kuota Pendakian</h4>
                    <p class="text-xs text-mountain-400">Demi kelestarian alam</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-forest-700 font-display">Maks. 200 <span class="text-xs text-mountain-400 font-normal">orang / hari</span></p>
        </div>

        <div class="glass-card p-6">
            <div class="flex items-center gap-4 mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-100 to-yellow-50 rounded-xl flex items-center justify-center text-2xl">📏</div>
                <div>
                    <h4 class="font-display font-bold text-mountain-800">Ketinggian & Jalur</h4>
                    <p class="text-xs text-mountain-400">Estimasi waktu tempuh</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-forest-700 font-display">2.821 <span class="text-sm text-mountain-400 font-normal">mdpl</span> <span class="text-xs text-mountain-400 font-normal ml-1">(6-8 jam trek)</span></p>
        </div>
    </div>
</section>

<!-- ═══════════ DETAILS ═══════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 pb-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column: Perlengkapan & Aturan -->
        <div class="space-y-6">
            <!-- Perlengkapan Wajib -->
            <div class="glass-card p-6">
                <h3 class="font-display font-bold text-mountain-800 text-lg border-b border-mountain-100 pb-3 mb-5 flex items-center gap-2">
                    🎒 Perlengkapan Wajib
                </h3>
                <ul class="space-y-3 text-sm text-mountain-600">
                    @php
                        $perlengkapan = [
                            'Tenda dome (sesuai kapasitas rombongan)',
                            'Sleeping bag & matras untuk setiap anggota',
                            'Jaket tebal (anti angin & air) & jas hujan',
                            'Sepatu tracking (tidak disarankan memakai sandal biasa)',
                            'Peralatan memasak (kompor gas portable/nesting)',
                            'Logistik makanan & air minum yang cukup',
                            'Senter/headlamp & obat-obatan pribadi (P3K)',
                        ];
                    @endphp
                    @foreach($perlengkapan as $item)
                        <li class="flex items-start gap-3 group">
                            <span class="w-6 h-6 bg-forest-100 rounded-lg flex items-center justify-center text-forest-600 font-bold text-xs flex-shrink-0 group-hover:bg-forest-200 transition-colors">✓</span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Aturan -->
            <div class="glass-card p-6">
                <h3 class="font-display font-bold text-mountain-800 text-lg border-b border-mountain-100 pb-3 mb-5 flex items-center gap-2">
                    ⚠️ Aturan & Larangan
                </h3>
                <ul class="space-y-3 text-sm text-mountain-600">
                    @php
                        $aturan = [
                            'Dilarang keras membuang sampah sembarangan (sampah wajib dibawa turun kembali).',
                            'Dilarang membuat perapian langsung di tanah tanpa alas seng/tungku portable.',
                            'Dilarang melakukan vandalisme, memotong dahan pohon, atau merusak flora & fauna.',
                            'Dilarang membawa senjata tajam berlebih, miras, obat terlarang, atau petasan.',
                            'Setiap pendaki wajib melapor di loket basecamp saat naik maupun turun.',
                        ];
                    @endphp
                    @foreach($aturan as $item)
                        <li class="flex items-start gap-3 group">
                            <span class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center text-red-500 font-bold text-xs flex-shrink-0 group-hover:bg-red-200 transition-colors">!</span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Right Column: Prosedur -->
        <div class="glass-card p-6 md:p-8 h-fit">
            <h3 class="font-display font-bold text-mountain-800 text-lg border-b border-mountain-100 pb-3 mb-8 flex items-center gap-2">
                📝 Prosedur Booking & Pembayaran
            </h3>

            <div class="space-y-0">
                <div class="info-step">
                    <div class="info-step-number">1</div>
                    <h4 class="font-display font-bold text-mountain-800 text-sm mb-1">Pengecekan Kuota & Jadwal</h4>
                    <p class="text-sm text-mountain-500 leading-relaxed">Pilih menu <strong>Jadwal & Kuota</strong> untuk memeriksa sisa kuota pada tanggal pendakian yang Anda inginkan.</p>
                </div>

                <div class="info-step">
                    <div class="info-step-number">2</div>
                    <h4 class="font-display font-bold text-mountain-800 text-sm mb-1">Mengisi Form Booking</h4>
                    <p class="text-sm text-mountain-500 leading-relaxed">Pilih menu <strong>Booking Tiket</strong>, isi nama ketua rombongan, nomor telepon, alamat, tanggal pendakian, serta nama-nama seluruh anggota rombongan (maks. 10 orang per booking).</p>
                </div>

                <div class="info-step">
                    <div class="info-step-number">3</div>
                    <h4 class="font-display font-bold text-mountain-800 text-sm mb-1">Pembayaran Digital</h4>
                    <p class="text-sm text-mountain-500 leading-relaxed">Setelah form dikirim, Anda akan dialihkan ke halaman pembayaran. Pembayaran aman melalui payment gateway Midtrans sandbox (QRIS, transfer bank, e-wallet, dll).</p>
                </div>

                <div class="info-step">
                    <div class="info-step-number">4</div>
                    <h4 class="font-display font-bold text-mountain-800 text-sm mb-1">Penerbitan & Validasi E-Ticket</h4>
                    <p class="text-sm text-mountain-500 leading-relaxed">Setelah pembayaran berhasil, e-ticket otomatis diterbitkan. Pengelola basecamp akan memvalidasi tiket Anda saat tiba di lokasi.</p>
                </div>
            </div>

            <!-- CTA -->
            <div class="mt-8 bg-gradient-to-r from-forest-50 to-emerald-50 p-5 rounded-2xl border border-forest-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h4 class="font-bold text-forest-800">Sudah Siap Mendaki? 🏔️</h4>
                    <p class="text-xs text-forest-600">Pesan tiket Anda sekarang dan amankan kuotanya!</p>
                </div>
                <a href="{{ route('pendaki.booking.create') }}" class="btn-primary flex-shrink-0">
                    Pesan Tiket →
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
