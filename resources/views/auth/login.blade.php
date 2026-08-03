@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<h2 class="text-xl font-display font-bold text-white text-center mb-6">Selamat Datang Kembali</h2>

<form action="{{ route('login') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label for="email" class="block text-sm font-semibold text-mountain-200 mb-1.5">Alamat Email</label>
        <div class="relative">
            <input type="email" name="email" id="email" 
                   class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white/10 transition-all duration-200" 
                   placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
        </div>
        @error('email')
            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <div class="flex justify-between items-center mb-1.5">
            <label for="password" class="block text-sm font-semibold text-mountain-200">Password</label>
        </div>
        <div class="relative">
            <input type="password" name="password" id="password" 
                   class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white/10 transition-all duration-200" 
                   placeholder="••••••••" required>
        </div>
        @error('password')
            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between pt-1">
        <label class="flex items-center gap-2 cursor-pointer select-none">
            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/10 bg-white/5 text-forest-600 focus:ring-forest-500 focus:ring-offset-mountain-900">
            <span class="text-xs text-mountain-300">Ingat saya</span>
        </label>
    </div>

    <button type="submit" class="w-full mt-2 inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-forest-600 hover:bg-forest-500 text-white font-semibold rounded-xl active:scale-[0.98] transition-all duration-200 shadow-lg shadow-forest-900/30">
        <span>Masuk</span> ➔
    </button>
</form>

<div class="mt-6 text-center text-sm border-t border-white/10 pt-4">
    <p class="text-mountain-400">Belum punya akun? 
        <a href="{{ route('register') }}" class="text-forest-400 hover:text-forest-300 font-semibold transition-all duration-200">Daftar Sekarang</a>
    </p>
</div>
@endsection
