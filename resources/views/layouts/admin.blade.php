<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Cikuray Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-mountain-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Admin Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-gradient-to-b from-mountain-950 to-mountain-900 flex flex-col overflow-y-auto">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-white flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('images/logo-cikuray.jpg') }}" alt="Logo Gunung Cikuray" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h2 class="font-display font-bold text-white text-sm leading-tight">Admin Panel</h2>
                        <p class="text-mountain-400 text-xs">Basecamp Cintanagara</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <p class="text-mountain-500 text-xs font-semibold uppercase tracking-wider px-4 pt-2 pb-1">Utama</p>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>📊</span> Dashboard
                </a>

                <p class="text-mountain-500 text-xs font-semibold uppercase tracking-wider px-4 pt-4 pb-1">Kelola Data</p>
                <a href="{{ route('admin.booking.index') }}" class="sidebar-link {{ request()->routeIs('admin.pendaki.*') || request()->routeIs('admin.booking.*') ? 'active' : '' }}">
                    <span>👥</span> Data Pendaki & Booking
                </a>
                <a href="{{ route('admin.jadwal.index') }}" class="sidebar-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                    <span>📅</span> Jadwal & Kuota
                </a>
                <a href="{{ route('admin.pembayaran.index') }}" class="sidebar-link {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }} flex items-center justify-between">
                    <span class="flex items-center gap-3">
                        <span>💳</span> Kelola Pembayaran
                    </span>
                    @php
                        $pendingPaymentsCount = \App\Models\Pembayaran::where('status', 'menunggu')->count();
                    @endphp
                    @if($pendingPaymentsCount > 0)
                        <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full min-w-[20px] text-center">
                            {{ $pendingPaymentsCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.eticket.index') }}" class="sidebar-link {{ request()->routeIs('admin.eticket.*') ? 'active' : '' }}">
                    <span>🧗</span> Validasi Pendaki
                </a>

                <p class="text-mountain-500 text-xs font-semibold uppercase tracking-wider px-4 pt-4 pb-1">Lainnya</p>
                <a href="{{ route('admin.knowledge-base.index') }}" class="sidebar-link {{ request()->routeIs('admin.knowledge-base.*') ? 'active' : '' }}">
                    <span>🤖</span> Knowledge Base
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="sidebar-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <span>📈</span> Laporan
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left sidebar-link text-red-400 hover:bg-red-500/10">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b border-mountain-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
                <div>
                    <h1 class="font-display font-bold text-mountain-800 text-lg">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-mountain-500 text-sm">@yield('page-subtitle', '')</p>
                </div>
                <div class="flex items-center gap-3">
                    @yield('header-actions')
                    <span class="badge-gray">{{ now()->locale('id')->isoFormat('D MMM Y') }}</span>
                </div>
            </header>

            <div class="px-6 pt-4">
                @if(session('success'))
                    <div class="mb-4 px-4 py-3 bg-forest-50 border border-forest-200 rounded-xl text-forest-700 text-sm flex items-center gap-2">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center gap-2">
                        <span>❌</span> {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        <p class="font-semibold mb-1">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <main class="flex-1 overflow-y-auto px-6 pb-6">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
