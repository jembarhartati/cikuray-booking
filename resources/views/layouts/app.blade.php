<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Cikuray Booking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-mountain-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-gradient-to-b from-mountain-900 to-forest-950 flex flex-col overflow-y-auto">
            <!-- Logo -->
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-forest-500/30 rounded-xl flex items-center justify-center">
                        <span class="text-xl">🏔️</span>
                    </div>
                    <div>
                        <h2 class="font-display font-bold text-white text-sm leading-tight">Cikuray Booking</h2>
                        <p class="text-mountain-400 text-xs">Pendaki</p>
                    </div>
                </div>
            </div>

            <!-- Nav -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('pendaki.dashboard') }}" class="sidebar-link {{ request()->routeIs('pendaki.dashboard') ? 'active' : '' }}">
                    <span class="text-lg">🏠</span> Dashboard
                </a>
                <a href="{{ route('pendaki.informasi') }}" class="sidebar-link {{ request()->routeIs('pendaki.informasi') ? 'active' : '' }}">
                    <span class="text-lg">ℹ️</span> Informasi Gunung
                </a>
                <a href="{{ route('pendaki.jadwal') }}" class="sidebar-link {{ request()->routeIs('pendaki.jadwal') ? 'active' : '' }}">
                    <span class="text-lg">📅</span> Jadwal & Kuota
                </a>
                <a href="{{ route('pendaki.booking.create') }}" class="sidebar-link {{ request()->routeIs('pendaki.booking.create') ? 'active' : '' }}">
                    <span class="text-lg">🎟️</span> Booking Tiket
                </a>
                <a href="{{ route('pendaki.status-booking') }}" class="sidebar-link {{ request()->routeIs('pendaki.status-booking') ? 'active' : '' }}">
                    <span class="text-lg">📋</span> Status Booking
                </a>
            </nav>

            <!-- User -->
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 bg-forest-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-mountain-400 text-xs">Pendaki</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left sidebar-link text-red-400 hover:bg-red-500/10 hover:text-red-300">
                        <span class="text-lg">🚪</span> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-mountain-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
                <div>
                    <h1 class="font-display font-bold text-mountain-800 text-lg">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-mountain-500 text-sm">@yield('page-subtitle', '')</p>
                </div>
                <div class="flex items-center gap-3">
                    @yield('header-actions')
                    <span class="text-xs text-mountain-400">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </header>

            <!-- Flash Messages -->
            <div class="px-6 pt-4">
                @if(session('success'))
                    <div class="mb-4 px-4 py-3 bg-forest-50 border border-forest-200 rounded-xl text-forest-700 text-sm flex items-center gap-2 animate-fade-in">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center gap-2 animate-fade-in">
                        <span>❌</span> {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm animate-fade-in">
                        <p class="font-semibold mb-1">❌ Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto px-6 pb-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Chatbot Widget -->
    @include('components.chatbot')

    @stack('scripts')
</body>
</html>
