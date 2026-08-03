<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gunung Cikuray via Cintanagara — Booking Pendakian</title>
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
                <video autoplay muted loop playsinline class="landing-video-element">
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
                <div class="landing-hero-badge">
                    <span class="w-2 h-2 bg-forest-400 rounded-full animate-pulse-slow"></span>
                    📍 Garut, Jawa Barat — Indonesia
                </div>
                <h2 class="landing-hero-title">
                    Gunung <span class="text-forest-400">Cikuray</span>
                </h2>
                <p class="landing-hero-subtitle">
                    Jelajahi keindahan puncak tertinggi keempat di Jawa Barat melalui jalur Cintanagara.
                    <br class="hidden md:block">
                    Rasakan sensasi samudera awan di ketinggian <strong class="text-white">2.821 mdpl</strong>.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
                    <a href="{{ route('register') }}" class="landing-btn-primary">
                        🎫 Booking Pendakian <span class="ml-1">→</span>
                    </a>
                    <a href="#informasi" class="landing-btn-secondary">
                        ℹ️ Pelajari Lebih Lanjut
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
                <span class="landing-section-badge">🏔️ Tentang Gunung Cikuray</span>
                <h3 class="landing-section-title">Keajaiban Alam di Tanah Priangan</h3>
                <p class="landing-section-desc">
                    Gunung Cikuray (2.821 mdpl) merupakan gunung tertinggi keempat di Jawa Barat setelah Gunung Ciremai, 
                    Pangrango, dan Gede. Terletak di Kabupaten Garut, gunung ini menawarkan panorama samudera awan 
                    yang memukau serta jalur pendakian yang menantang.
                </p>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <div class="landing-info-card">
                    <div class="landing-info-icon bg-gradient-to-br from-emerald-500/20 to-forest-500/20">🗺️</div>
                    <h4 class="landing-info-title">Jalur Cintanagara</h4>
                    <p class="landing-info-desc">Jalur pendakian via Desa Cintanagara, Kecamatan Cisurupan, Garut. Jalur ini menawarkan pemandangan hutan tropis yang rimbun dan track yang beragam dari landai hingga terjal.</p>
                </div>
                <div class="landing-info-card">
                    <div class="landing-info-icon bg-gradient-to-br from-blue-500/20 to-cyan-500/20">🌊</div>
                    <h4 class="landing-info-title">Samudera Awan</h4>
                    <p class="landing-info-desc">Pemandangan ikonik Gunung Cikuray berupa lautan awan putih tebal yang terbentang luas di bawah puncak, paling indah dinikmati saat golden sunrise pagi hari.</p>
                </div>
                <div class="landing-info-card">
                    <div class="landing-info-icon bg-gradient-to-br from-amber-500/20 to-orange-500/20">⛺</div>
                    <h4 class="landing-info-title">Area Camp</h4>
                    <p class="landing-info-desc">Terdapat beberapa titik camp yang bisa digunakan sepanjang jalur pendakian. Area puncak cukup luas untuk mendirikan tenda dengan view 360° panorama pegunungan.</p>
                </div>
            </div>

            {{-- Deskripsi Detail --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="landing-detail-card">
                    <h4 class="landing-detail-title">
                        <span class="landing-detail-icon">📋</span>
                        Informasi Pendakian
                    </h4>
                    <div class="space-y-4">
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Ketinggian</span>
                            <span class="landing-detail-value">2.821 mdpl</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Lokasi</span>
                            <span class="landing-detail-value">Kab. Garut, Jawa Barat</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Jalur Pendakian</span>
                            <span class="landing-detail-value">Via Cintanagara</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Estimasi Waktu</span>
                            <span class="landing-detail-value">6 - 8 Jam (one way)</span>
                        </div>
                        <div class="landing-detail-row">
                            <span class="landing-detail-label">Harga Tiket</span>
                            <span class="landing-detail-value text-forest-400 font-bold">Rp30.000 / orang / hari</span>
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
                        <span class="landing-detail-icon">🎒</span>
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
                                'Senter / headlamp & P3K',
                            ];
                        @endphp
                        @foreach($perlengkapan as $item)
                            <li class="landing-checklist-item">
                                <span class="landing-checklist-icon">✓</span>
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
                <span class="landing-section-badge">📸 Galeri & Video</span>
                <h3 class="landing-section-title">Pesona Gunung Cikuray</h3>
                <p class="landing-section-desc">
                    Nikmati keindahan alam Gunung Cikuray melalui galeri foto dan video dari para pendaki.
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
                <span class="landing-section-badge">⚠️ Aturan Pendakian</span>
                <h3 class="landing-section-title">Jaga Alam, Jaga Keselamatan</h3>
                <p class="landing-section-desc">
                    Setiap pendaki wajib mematuhi aturan dan larangan berikut demi keselamatan bersama 
                    serta kelestarian alam Gunung Cikuray.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                @php
                    $aturan = [
                        ['icon' => '🚯', 'text' => 'Dilarang keras membuang sampah sembarangan. Sampah wajib dibawa turun kembali.'],
                        ['icon' => '🔥', 'text' => 'Dilarang membuat perapian langsung di tanah tanpa alas seng/tungku portable.'],
                        ['icon' => '🌿', 'text' => 'Dilarang vandalisme, memotong dahan pohon, atau merusak flora & fauna.'],
                        ['icon' => '🚫', 'text' => 'Dilarang membawa senjata tajam berlebih, miras, obat terlarang, atau petasan.'],
                        ['icon' => '📝', 'text' => 'Setiap pendaki wajib melapor di loket basecamp saat naik maupun turun.'],
                        ['icon' => '👥', 'text' => 'Minimal 2 orang per rombongan. Pendakian solo tidak diperkenankan.'],
                    ];
                @endphp
                @foreach($aturan as $rule)
                    <div class="landing-rule-card">
                        <div class="landing-rule-icon">{{ $rule['icon'] }}</div>
                        <p class="landing-rule-text">{{ $rule['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════ PROSEDUR BOOKING ═══════════ --}}
    <section class="landing-section bg-gradient-to-b from-mountain-900 to-mountain-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="landing-section-badge">📝 Cara Booking</span>
                <h3 class="landing-section-title">Prosedur Pemesanan Tiket</h3>
                <p class="landing-section-desc">
                    Ikuti langkah-langkah mudah berikut untuk memesan tiket pendakian Gunung Cikuray.
                </p>
            </div>

            <div class="landing-steps">
                <div class="landing-step">
                    <div class="landing-step-number">1</div>
                    <div class="landing-step-content">
                        <h4 class="landing-step-title">Daftar Akun</h4>
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
                        <h4 class="landing-step-title">Pembayaran</h4>
                        <p class="landing-step-desc">Lakukan pembayaran melalui transfer manual atau payment gateway digital Midtrans (QRIS, e-wallet, bank transfer).</p>
                    </div>
                </div>
                <div class="landing-step">
                    <div class="landing-step-number">5</div>
                    <div class="landing-step-content">
                        <h4 class="landing-step-title">Dapatkan E-Ticket</h4>
                        <p class="landing-step-desc">Setelah pembayaran terverifikasi, e-ticket otomatis diterbitkan. Tunjukkan e-ticket saat tiba di basecamp.</p>
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
                Siap Mendaki? 🏔️
            </h3>
            <p class="text-white/70 text-lg max-w-2xl mx-auto mb-8">
                Daftarkan diri Anda sekarang dan booking tiket pendakian Gunung Cikuray via Cintanagara. 
                Petualangan menanti di ketinggian 2.821 mdpl!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="landing-btn-primary text-lg px-8 py-4">
                    🎫 Daftar & Booking Sekarang
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
        });
    </script>
    <!-- Chatbot Widget -->
    @include('components.chatbot')
</body>
</html>
