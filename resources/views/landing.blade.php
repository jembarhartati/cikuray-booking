<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gunung Cikuray via Cintanagara — Booking Pendakian Resmi</title>
    <meta name="description" content="Selamat datang di sistem booking pendakian Gunung Cikuray via Basecamp Cintanagara, Garut, Jawa Barat. Ketinggian 2.821 mdpl.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-mountain-950 text-white overflow-x-hidden">

    {{-- Navigation Bar --}}
    <nav class="landing-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white/30 shadow-lg">
                    <img src="{{ asset('images/logo-cikuray.jpg') }}" alt="Logo" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-sm font-bold text-white leading-tight">Gunung Cikuray</h1>
                    <p class="text-[10px] text-white/60 leading-tight">via Cintanagara</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="#informasi" class="hidden sm:inline-flex text-sm text-white/70 hover:text-white transition-colors duration-200 px-3 py-1.5">Informasi</a>
                <a href="#galeri" class="hidden sm:inline-flex text-sm text-white/70 hover:text-white transition-colors duration-200 px-3 py-1.5">Galeri</a>
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-white bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl hover:bg-white/20 transition-all duration-200">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-forest-600 rounded-xl hover:bg-forest-500 transition-all duration-200 shadow-lg shadow-forest-700/30">Daftar</a>
            </div>
        </div>
    </nav>

    {{-- ═══════════ HERO SECTION WITH VIDEO BACKGROUND ═══════════ --}}
    <section id="hero" class="landing-hero">
        {{-- Video Background --}}
        <div class="landing-hero-video">
            @php
                $videoFile = null;
                $videoType = null;
                $formats = [
                    'cikuray.mp4' => 'video/mp4',
                    'cikuray.MOV' => 'video/mp4',
                    'cikuray.mov' => 'video/mp4',
                    'cikuray.webm' => 'video/webm',
                ];
                foreach ($formats as $file => $type) {
                    if (file_exists(public_path('videos/' . $file))) {
                        $videoFile = $file;
                        $videoType = $type;
                        break;
                    }
                }
            @endphp
            @if($videoFile)
                <video autoplay muted loop playsinline preload="auto" poster="{{ asset('images/gunung-cikuray.png') }}" class="landing-video-element" id="hero-bg-video">
                    <source src="{{ asset('videos/' . $videoFile) }}" type="{{ $videoType }}">
                </video>
            @else
                {{-- Fallback: gambar background jika video belum ada --}}
                <div class="landing-hero-image" style="background-image: url('{{ asset('images/gunung-cikuray.png') }}')"></div>
            @endif
        </div>

        {{-- Overlay Gradients --}}
        <div class="landing-hero-overlay"></div>

        {{-- Floating Particles --}}
        <div class="landing-particles">
            <div class="landing-particle" style="--delay: 0s; --x: 10%; --size: 3px;"></div>
            <div class="landing-particle" style="--delay: 2s; --x: 25%; --size: 2px;"></div>
            <div class="landing-particle" style="--delay: 4s; --x: 45%; --size: 4px;"></div>
            <div class="landing-particle" style="--delay: 1s; --x: 65%; --size: 2px;"></div>
            <div class="landing-particle" style="--delay: 3s; --x: 80%; --size: 3px;"></div>
            <div class="landing-particle" style="--delay: 5s; --x: 92%; --size: 2px;"></div>
        </div>

        {{-- Hero Content --}}
        <div class="landing-hero-content">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="landing-hero-badge inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Garut, Jawa Barat — Indonesia</span>
                </div>
                <h2 class="landing-hero-title">
                    Gunung <span class="text-forest-400">Cikuray</span>
                </h2>
                <p class="landing-hero-subtitle">
                    Jelajahi keindahan puncak tertinggi kedua di Jawa Barat melalui jalur Cintanagara.
                    <br class="hidden md:block">
                    Rasakan sensasi samudera awan di ketinggian <strong class="text-white">2.821 mdpl</strong>.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
                    <a href="{{ route('register') }}" class="landing-btn-primary flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        <span>Booking Pendakian</span>
                        <span class="ml-1">→</span>
                    </a>
                    <a href="#informasi" class="landing-btn-secondary flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Pelajari Lebih Lanjut</span>
                    </a>
                </div>

                {{-- Quick Stats --}}
                <div class="landing-quick-stats">
                    <div class="landing-stat">
                        <span class="landing-stat-value">2.821</span>
                        <span class="landing-stat-label">mdpl</span>
                    </div>
                    <div class="landing-stat-divider"></div>
                    <div class="landing-stat">
                        <span class="landing-stat-value">6-8</span>
                        <span class="landing-stat-label">Jam Trek</span>
                    </div>
                    <div class="landing-stat-divider"></div>
                    <div class="landing-stat">
                        <span class="landing-stat-value">200</span>
                        <span class="landing-stat-label">Kuota / Hari</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="landing-scroll-indicator">
            <div class="landing-scroll-mouse">
                <div class="landing-scroll-wheel"></div>
            </div>
            <p class="text-[10px] text-white/40 mt-2 tracking-widest uppercase">Scroll</p>
        </div>
    </section>

    {{-- ═══════════ INFORMASI SECTION ═══════════ --}}
    <section id="informasi" class="landing-section bg-gradient-to-b from-mountain-950 to-mountain-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="landing-section-badge inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span>Tentang Gunung Cikuray</span>
                </div>
                <h3 class="landing-section-title">Keajaiban Alam di Tanah Priangan</h3>
                <p class="landing-section-desc">
                    Gunung Cikuray (2.821 mdpl) merupakan gunung tertinggi kedua di Jawa Barat. Terletak di Kabupaten Garut, 
                    gunung ini menawarkan panorama samudera awan yang memukau serta jalur pendakian yang menantang via Basecamp Cintanagara.
                </p>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <div class="landing-info-card">
                    <div class="landing-info-icon bg-gradient-to-br from-emerald-500/20 to-forest-500/20 text-emerald-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    <h4 class="landing-info-title">Jalur Cintanagara</h4>
                    <p class="landing-info-desc">Jalur pendakian via Desa Cintanagara, Kecamatan Cigedug, Garut. Jalur ini menawarkan pemandangan hutan tropis yang rimbun dan trek yang bervariasi.</p>
                </div>
                <div class="landing-info-card">
                    <div class="landing-info-icon bg-gradient-to-br from-cyan-500/20 to-blue-500/20 text-cyan-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                    </div>
                    <h4 class="landing-info-title">Samudera Awan</h4>
                    <p class="landing-info-desc">Pemandangan ikonik Gunung Cikuray berupa lautan awan putih tebal yang terbentang di bawah puncak saat golden sunrise pagi hari.</p>
                </div>
                <div class="landing-info-card">
                    <div class="landing-info-icon bg-gradient-to-br from-amber-500/20 to-orange-500/20 text-amber-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21l7-18 7 18M9 21l3-7 3 7"/></svg>
                    </div>
                    <h4 class="landing-info-title">Area Camping</h4>
                    <p class="landing-info-desc">Terdapat beberapa titik pos camp ideal di sepanjang rute pendakian serta area puncak yang cukup luas untuk mendirikan tenda.</p>
                </div>
            </div>

            {{-- Deskripsi Detail --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="landing-detail-card">
                    <h4 class="landing-detail-title">
                        <span class="landing-detail-icon">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </span>
                        Informasi Pendakian
                    </h4>
                    <div class="space-y-4">
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Ketinggian</span>
                            <span class="landing-detail-value">2.821 mdpl</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Lokasi Basecamp</span>
                            <span class="landing-detail-value">Desa Cintanagara, Garut</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Jalur Pendakian</span>
                            <span class="landing-detail-value">Via Cintanagara</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Estimasi Waktu</span>
                            <span class="landing-detail-value">6 - 8 Jam (Satu Arah)</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Harga Tiket SIMAKSI</span>
                            <span class="landing-detail-value text-emerald-400 font-bold">Rp30.000 / orang / hari</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Kuota Harian</span>
                            <span class="landing-detail-value">Maks. 200 orang</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Min. Rombongan</span>
                            <span class="landing-detail-value">2 orang</span>
                        </div>
                    </div>
                </div>

                <div class="landing-detail-card">
                    <h4 class="landing-detail-title">
                        <span class="landing-detail-icon">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        </span>
                        Perlengkapan Wajib
                    </h4>
                    <ul class="space-y-3">
                        @php
                            $perlengkapan = [
                                'Tenda dome (sesuai kapasitas rombongan)',
                                'Sleeping bag & matras untuk setiap anggota',
                                'Jaket tebal (anti angin & air) & jas hujan',
                                'Sepatu tracking (bukan sandal)',
                                'Peralatan memasak (kompor portable/nesting)',
                                'Logistik makanan & air minum yang cukup',
                                'Senter / headlamp & P3K standar',
                            ];
                        @endphp
                        @foreach($perlengkapan as $item)
                            <li class="landing-checklist-item flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400 shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════ GALERI / VIDEO SECTION ═══════════ --}}
    <section id="galeri" class="landing-section bg-gradient-to-b from-mountain-900 to-mountain-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="landing-section-badge inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Galeri & Dokumentasi</span>
                </div>
                <h3 class="landing-section-title">Pesona Gunung Cikuray</h3>
                <p class="landing-section-desc">
                    Nikmati keindahan pemandangan alam Gunung Cikuray melalui dokumentasi foto dan video dari para pendaki.
                </p>
            </div>

            {{-- Video Embed --}}
            @php
                $galleryVideo = null;
                $galleryVideoType = null;
                $vFormats = [
                    'cikuray.mp4' => 'video/mp4',
                    'cikuray.MOV' => 'video/mp4',
                    'cikuray.mov' => 'video/mp4',
                    'cikuray.webm' => 'video/webm',
                ];
                foreach ($vFormats as $vf => $vt) {
                    if (file_exists(public_path('videos/' . $vf))) {
                        $galleryVideo = $vf;
                        $galleryVideoType = $vt;
                        break;
                    }
                }
            @endphp
            @if($galleryVideo)
                <div class="landing-video-showcase">
                    <video controls class="w-full rounded-2xl" poster="{{ asset('images/gunung-cikuray.png') }}">
                        <source src="{{ asset('videos/' . $galleryVideo) }}" type="{{ $galleryVideoType }}">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                </div>
            @endif

            {{-- Image Gallery --}}
            <div class="landing-gallery">
                <div class="landing-gallery-item landing-gallery-item-large">
                    <img src="{{ asset('images/gunung-cikuray.png') }}" alt="Gunung Cikuray" class="landing-gallery-img">
                    <div class="landing-gallery-overlay">
                        <p class="text-white font-bold text-lg">Puncak Gunung Cikuray</p>
                        <p class="text-white/70 text-sm">2.821 mdpl</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════ ATURAN SECTION ═══════════ --}}
    <section class="landing-section bg-gradient-to-b from-mountain-950 to-mountain-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="landing-section-badge inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Aturan & Larangan Pendakian</span>
                </div>
                <h3 class="landing-section-title">Jaga Alam, Jaga Keselamatan</h3>
                <p class="landing-section-desc">
                    Setiap pendaki wajib mematuhi aturan dan larangan berikut demi keselamatan bersama 
                    serta kelestarian alam Gunung Cikuray.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                {{-- Rule 1: Zero Waste --}}
                <div class="landing-rule-card flex items-start gap-4 p-5 rounded-2xl bg-mountain-900/80 border border-mountain-800 backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-red-500/15 border border-red-500/30 flex items-center justify-center text-red-400 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Larangan Sampah</h4>
                        <p class="text-xs text-white/70 mt-1 leading-relaxed">Dilarang keras membuang sampah sembarangan. Seluruh sampah wajib dibawa turun kembali ke basecamp.</p>
                    </div>
                </div>

                {{-- Rule 2: Perapian --}}
                <div class="landing-rule-card flex items-start gap-4 p-5 rounded-2xl bg-mountain-900/80 border border-mountain-800 backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center text-orange-400 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Aturan API / Api Unggun</h4>
                        <p class="text-xs text-white/70 mt-1 leading-relaxed">Dilarang membuat perapian langsung di atas tanah tanpa alas seng atau kompor portable demi mencegah kebakaran hutan.</p>
                    </div>
                </div>

                {{-- Rule 3: Perlindungan Flora & Fauna --}}
                <div class="landing-rule-card flex items-start gap-4 p-5 rounded-2xl bg-mountain-900/80 border border-mountain-800 backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Perlindungan Alam</h4>
                        <p class="text-xs text-white/70 mt-1 leading-relaxed">Dilarang melakukan vandalisme, merusak pohon, memetik bunga edelweis, atau mengganggu satwa liar di kawasan Gunung Cikuray.</p>
                    </div>
                </div>

                {{-- Rule 4: Barang Terlarang --}}
                <div class="landing-rule-card flex items-start gap-4 p-5 rounded-2xl bg-mountain-900/80 border border-mountain-800 backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-rose-500/15 border border-rose-500/30 flex items-center justify-center text-rose-400 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Barang Terlarang</h4>
                        <p class="text-xs text-white/70 mt-1 leading-relaxed">Dilarang membawa senjata tajam berlebih, minuman keras, obat-obatan terlarang, maupun kembang api/petasan.</p>
                    </div>
                </div>

                {{-- Rule 5: Lapor Basecamp --}}
                <div class="landing-rule-card flex items-start gap-4 p-5 rounded-2xl bg-mountain-900/80 border border-mountain-800 backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-sky-500/15 border border-sky-500/30 flex items-center justify-center text-sky-400 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Wajib Registrasi & Lapor</h4>
                        <p class="text-xs text-white/70 mt-1 leading-relaxed">Setiap pendaki wajib melapor dan melakukan verifikasi e-ticket di loket basecamp saat memulai pendakian maupun saat turun.</p>
                    </div>
                </div>

                {{-- Rule 6: Ketentuan Rombongan --}}
                <div class="landing-rule-card flex items-start gap-4 p-5 rounded-2xl bg-mountain-900/80 border border-mountain-800 backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/15 border border-amber-500/30 flex items-center justify-center text-amber-400 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Batas Minimum Rombongan</h4>
                        <p class="text-xs text-white/70 mt-1 leading-relaxed">Pendakian wajib dilakukan dalam kelompok minimal 2 orang. Pendakian solo tidak diperkenankan demi alasan keselamatan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════ PROSEDUR BOOKING ═══════════ --}}
    <section class="landing-section bg-gradient-to-b from-mountain-900 to-mountain-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="landing-section-badge inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Prosedur Pemesanan Tiket</span>
                </div>
                <h3 class="landing-section-title">Langkah Mudah Online Booking</h3>
                <p class="landing-section-desc">
                    Ikuti tahapan praktis berikut untuk memesan kuota pendakian Gunung Cikuray secara resmi.
                </p>
            </div>

            <div class="landing-steps">
                <div class="landing-step">
                    <div class="landing-step-number">1</div>
                    <div class="landing-step-content">
                        <h4 class="landing-step-title">Daftar Akun Pendaki</h4>
                        <p class="landing-step-desc">Buat akun terlebih dahulu melalui halaman pendaftaran. Isi data diri Anda dengan lengkap dan benar.</p>
                    </div>
                </div>
                <div class="landing-step">
                    <div class="landing-step-number">2</div>
                    <div class="landing-step-content">
                        <h4 class="landing-step-title">Cek Jadwal & Kuota</h4>
                        <p class="landing-step-desc">Periksa ketersediaan kuota pendaki pada tanggal yang Anda inginkan melalui menu Jadwal & Kuota.</p>
                    </div>
                </div>
                <div class="landing-step">
                    <div class="landing-step-number">3</div>
                    <div class="landing-step-content">
                        <h4 class="landing-step-title">Isi Form Booking</h4>
                        <p class="landing-step-desc">Lengkapi formulir booking: data ketua rombongan, anggota, tanggal naik dan turun, serta kontak darurat.</p>
                    </div>
                </div>
                <div class="landing-step">
                    <div class="landing-step-number">4</div>
                    <div class="landing-step-content">
                        <h4 class="landing-step-title">Pembayaran Tiket</h4>
                        <p class="landing-step-desc">Lakukan pembayaran via Transfer Bank Mandiri atau Payment Gateway Midtrans (QRIS, E-Wallet, Virtual Account).</p>
                    </div>
                </div>
                <div class="landing-step">
                    <div class="landing-step-number">5</div>
                    <div class="landing-step-content">
                        <h4 class="landing-step-title">Dapatkan E-Ticket Resmi</h4>
                        <p class="landing-step-desc">Setelah pembayaran terverifikasi, E-Ticket resmi terbit otomatis. Tunjukkan E-Ticket saat verifikasi di Basecamp Cintanagara.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════ CTA SECTION ═══════════ --}}
    <section class="landing-cta">
        <div class="landing-cta-bg"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="w-20 h-20 rounded-full overflow-hidden border-3 border-white/30 shadow-2xl mx-auto mb-6">
                <img src="{{ asset('images/logo-cikuray.jpg') }}" alt="Logo" class="w-full h-full object-cover">
            </div>
            <h3 class="text-3xl md:text-4xl font-display font-extrabold text-white mb-4">
                Siap Menjelajah Gunung Cikuray? 🏔️
            </h3>
            <p class="text-white/70 text-lg max-w-2xl mx-auto mb-8">
                Daftarkan diri Anda sekarang dan booking tiket pendakian Gunung Cikuray via Basecamp Cintanagara. 
                Petualangan menanti di ketinggian 2.821 mdpl!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="landing-btn-primary text-lg px-8 py-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    <span>Daftar & Booking Sekarang</span>
                </a>
                <a href="{{ route('login') }}" class="landing-btn-secondary text-lg px-8 py-4">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </section>

    {{-- ═══════════ FOOTER ═══════════ --}}
    <footer class="landing-footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full overflow-hidden border border-white/20">
                        <img src="{{ asset('images/logo-cikuray.jpg') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>
                    <span class="text-sm text-white/60">Basecamp Cintanagara · Gunung Cikuray, Garut</span>
                </div>
                <p class="text-white/40 text-xs">
                    © {{ date('Y') }} Gunung Cikuray via Cintanagara. Hak cipta dilindungi.
                </p>
            </div>
        </div>
    </footer>

    {{-- Smooth Scroll Script --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Navbar scroll effect
        const nav = document.querySelector('.landing-nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('landing-nav-scrolled');
            } else {
                nav.classList.remove('landing-nav-scrolled');
            }
        });

        // Fade-in on scroll animation
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('landing-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.landing-info-card, .landing-detail-card, .landing-rule-card, .landing-step, .landing-gallery-item').forEach(el => {
            el.classList.add('landing-animate-on-scroll');
            observer.observe(el);
        // Force play video background for mobile & desktop autoplay policy
        const bgVideo = document.getElementById('hero-bg-video');
        if (bgVideo) {
            const playPromise = bgVideo.play();
            if (playPromise !== undefined) {
                playPromise.catch(function(error) {
                    console.log('Video autoplay deferred:', error);
                });
            }
        }
    </script>
    <!-- Chatbot Widget -->
    @include('components.chatbot')
</body>
</html>
