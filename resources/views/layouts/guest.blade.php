<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Booking Tiket') — Gunung Cikuray via Cintanagara</title>
    <meta name="description" content="@yield('meta_description', 'Sistem booking tiket pendakian Gunung Cikuray via Basecamp Cintanagara.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gradient-to-br from-mountain-900 via-forest-950 to-mountain-950">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <!-- Brand Header -->
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white border border-forest-500/30 rounded-full mb-4 overflow-hidden shadow-md">
                    <img src="{{ asset('images/logo-cikuray.jpg') }}" alt="Logo Gunung Cikuray" class="w-full h-full object-cover">
                </div>
                <h1 class="font-display text-2xl font-bold text-white">Gunung Cikuray</h1>
                <p class="text-mountain-400 text-sm mt-1">Basecamp Cintanagara · 2.821 mdpl</p>
            </div>

            <!-- Card -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-8 shadow-2xl">
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 bg-forest-500/20 border border-forest-500/30 rounded-xl text-forest-300 text-sm flex items-center gap-2">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 px-4 py-3 bg-red-500/20 border border-red-500/30 rounded-xl text-red-300 text-sm flex items-center gap-2">
                        <span>❌</span> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>

            <p class="text-center text-mountain-500 text-xs mt-6">
                © {{ date('Y') }} Basecamp Cintanagara · Gunung Cikuray, Garut
            </p>
        </div>
    </div>
    <!-- Chatbot Widget -->
    @include('components.chatbot')
</body>
</html>
