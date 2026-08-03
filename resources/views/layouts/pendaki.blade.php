<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Booking tiket pendakian Gunung Cikuray via Basecamp Cintanagara - Garut, Jawa Barat">
    <title>@yield('title', 'Dashboard') — Cikuray Booking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-mountain-50 text-mountain-800 flex flex-col">

    <!-- ═══════════ NAVBAR ═══════════ -->
    <nav class="pendaki-navbar" id="mainNavbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('pendaki.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-full overflow-hidden shadow-lg shadow-forest-500/30 group-hover:shadow-forest-500/50 transition-all duration-300 group-hover:scale-105 bg-white flex items-center justify-center">
                        <img src="{{ asset('images/logo-cikuray.jpg') }}" alt="Logo Gunung Cikuray" class="w-full h-full object-cover">
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="font-display font-bold text-mountain-900 text-sm leading-tight">Gunung Cikuray</h1>
                        <p class="text-[10px] text-mountain-400 font-medium tracking-wide">Basecamp Cintanagara</p>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('pendaki.dashboard') }}" class="nav-link {{ request()->routeIs('pendaki.dashboard') ? 'active' : '' }}">
                        <span class="text-sm">🏠</span> Beranda
                    </a>
                    <a href="{{ route('pendaki.jadwal') }}" class="nav-link {{ request()->routeIs('pendaki.jadwal') ? 'active' : '' }}">
                        <span class="text-sm">📅</span> Jadwal
                    </a>
                    <a href="{{ route('pendaki.booking.create') }}" class="nav-link {{ request()->routeIs('pendaki.booking.create') ? 'active' : '' }}">
                        <span class="text-sm">🎫</span> Booking
                    </a>
                    <a href="{{ route('pendaki.status-booking') }}" class="nav-link {{ request()->routeIs('pendaki.status-booking') ? 'active' : '' }}">
                        <span class="text-sm">📋</span> Status
                    </a>
                    <a href="{{ route('pendaki.informasi') }}" class="nav-link {{ request()->routeIs('pendaki.informasi') ? 'active' : '' }}">
                        <span class="text-sm">ℹ️</span> Informasi
                    </a>
                </div>

                <!-- User Menu & Mobile Toggle -->
                <div class="flex items-center gap-3">
                    <!-- User Badge (Desktop) -->
                    <div class="hidden md:flex items-center gap-3">
                        <span class="text-xs text-mountain-400 hidden lg:inline">{{ now()->locale('id')->isoFormat('dddd, D MMM Y') }}</span>
                        <div class="flex items-center gap-2.5 pl-3 border-l border-mountain-200">
                            <div class="w-8 h-8 bg-gradient-to-br from-forest-500 to-forest-700 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-md">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden lg:block">
                                <p class="text-xs font-semibold text-mountain-800 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-mountain-400">Pendaki</p>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-mountain-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200" title="Logout">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Mobile Hamburger -->
                    <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-mountain-600 hover:bg-mountain-100 rounded-xl transition-colors" id="mobileMenuBtn">
                        <svg class="w-6 h-6" id="menuIconOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg class="w-6 h-6 hidden" id="menuIconClose" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div class="md:hidden hidden border-t border-mountain-100 bg-white/95 backdrop-blur-xl" id="mobileMenu">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('pendaki.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('pendaki.dashboard') ? 'active' : '' }}">🏠 Beranda</a>
                <a href="{{ route('pendaki.jadwal') }}" class="mobile-nav-link {{ request()->routeIs('pendaki.jadwal') ? 'active' : '' }}">📅 Jadwal & Kuota</a>
                <a href="{{ route('pendaki.booking.create') }}" class="mobile-nav-link {{ request()->routeIs('pendaki.booking.create') ? 'active' : '' }}">🎫 Booking Tiket</a>
                <a href="{{ route('pendaki.status-booking') }}" class="mobile-nav-link {{ request()->routeIs('pendaki.status-booking') ? 'active' : '' }}">📋 Status Booking</a>
                <a href="{{ route('pendaki.informasi') }}" class="mobile-nav-link {{ request()->routeIs('pendaki.informasi') ? 'active' : '' }}">ℹ️ Informasi Gunung</a>
            </div>
            <div class="px-4 py-3 border-t border-mountain-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-gradient-to-br from-forest-500 to-forest-700 rounded-full flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-mountain-700">{{ auth()->user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-red-500 font-semibold hover:text-red-700 transition-colors">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- ═══════════ FLASH MESSAGES ═══════════ -->
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
        @if(session('success'))
            <div class="mb-4 px-5 py-4 bg-gradient-to-r from-forest-50 to-emerald-50 border border-forest-200 rounded-2xl text-forest-700 text-sm flex items-center gap-3 animate-fade-in shadow-sm">
                <span class="w-8 h-8 bg-forest-100 rounded-full flex items-center justify-center flex-shrink-0">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 px-5 py-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-2xl text-red-700 text-sm flex items-center gap-3 animate-fade-in shadow-sm">
                <span class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">❌</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 px-5 py-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-2xl text-red-700 text-sm animate-fade-in shadow-sm">
                <p class="font-semibold mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 text-xs">❌</span>
                    Terdapat kesalahan:
                </p>
                <ul class="list-disc list-inside space-y-0.5 pl-8">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- ═══════════ PAGE CONTENT ═══════════ -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- ═══════════ FOOTER ═══════════ -->
    <footer class="bg-gradient-to-b from-mountain-900 to-mountain-950 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-white flex items-center justify-center">
                            <img src="{{ asset('images/logo-cikuray.jpg') }}" alt="Logo Gunung Cikuray" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-sm">Gunung Cikuray</h3>
                            <p class="text-mountain-400 text-[10px]">Basecamp Cintanagara</p>
                        </div>
                    </div>
                    <p class="text-mountain-400 text-xs leading-relaxed max-w-xs">
                        Sistem booking tiket pendakian resmi Gunung Cikuray (2.821 mdpl) via Basecamp Cintanagara, Garut, Jawa Barat.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-display font-bold text-sm mb-4">Menu Cepat</h4>
                    <div class="space-y-2">
                        <a href="{{ route('pendaki.jadwal') }}" class="block text-xs text-mountain-400 hover:text-forest-400 transition-colors">📅 Jadwal & Kuota</a>
                        <a href="{{ route('pendaki.booking.create') }}" class="block text-xs text-mountain-400 hover:text-forest-400 transition-colors">🎫 Booking Tiket</a>
                        <a href="{{ route('pendaki.informasi') }}" class="block text-xs text-mountain-400 hover:text-forest-400 transition-colors">ℹ️ Informasi Gunung</a>
                        <a href="{{ route('pendaki.status-booking') }}" class="block text-xs text-mountain-400 hover:text-forest-400 transition-colors">📋 Status Booking</a>
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-display font-bold text-sm mb-4">Kontak Basecamp</h4>
                    <div class="space-y-2 text-xs text-mountain-400">
                        <p>📍 Basecamp Cintanagara, Kec. Cigedug, Kab. Garut</p>
                        <p>📞 WhatsApp/Telp: 0897-6869-943</p>
                        <p>⏰ Loket buka: 06:00 – 16:00 WIB</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-mountain-800 mt-8 pt-6 text-center">
                <p class="text-[10px] text-mountain-500">© {{ date('Y') }} Sistem Booking Tiket Gunung Cikuray — Basecamp Cintanagara. Dibuat untuk kemudahan pendaki.</p>
            </div>
        </div>
    </footer>

    <!-- Chatbot Widget -->
    @include('components.chatbot')

    @stack('scripts')

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 20) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const iconOpen = document.getElementById('menuIconOpen');
            const iconClose = document.getElementById('menuIconClose');

            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        }
    </script>
</body>
</html>
