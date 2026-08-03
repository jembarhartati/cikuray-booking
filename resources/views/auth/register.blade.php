@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')
<h2 class="text-xl font-display font-bold text-white text-center mb-6">Daftar Akun Pendaki Baru</h2>

<form action="{{ route('register') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label for="name" class="block text-sm font-semibold text-mountain-200 mb-1.5">Nama Lengkap</label>
        <input type="text" name="name" id="name" 
               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white/10 transition-all duration-200" 
               placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required autofocus>
        @error('name')
            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-semibold text-mountain-200 mb-1.5">Alamat Email</label>
        <input type="email" name="email" id="email" 
               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white/10 transition-all duration-200" 
               placeholder="nama@email.com" value="{{ old('email') }}" required>
        @error('email')
            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="no_telepon" class="block text-sm font-semibold text-mountain-200 mb-1.5">Nomor Telepon / WhatsApp</label>
        <input type="text" name="no_telepon" id="no_telepon" 
               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white/10 transition-all duration-200" 
               placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}" required>
        @error('no_telepon')
            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="alamat" class="block text-sm font-semibold text-mountain-200 mb-1.5">Alamat Lengkap</label>
        <textarea name="alamat" id="alamat" rows="2"
                  class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white/10 transition-all duration-200 resize-none" 
                  placeholder="Alamat Lengkap Anda" required>{{ old('alamat') }}</textarea>
        @error('alamat')
            <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="password" class="block text-sm font-semibold text-mountain-200 mb-1.5">Password</label>
            <input type="password" name="password" id="password" 
                   class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white/10 transition-all duration-200" 
                   placeholder="••••••••" required>
            @error('password')
                <p class="mt-1 text-xs text-red-400 font-medium">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-mountain-200 mb-1.5">Konfirmasi</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-mountain-400 focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white/10 transition-all duration-200" 
                   placeholder="••••••••" required>
        </div>
    </div>

    <button type="submit" class="w-full mt-2 inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-forest-600 hover:bg-forest-500 text-white font-semibold rounded-xl active:scale-[0.98] transition-all duration-200 shadow-lg shadow-forest-900/30">
        <span>Daftar</span> ➔
    </button>
</form>

<div class="mt-6 text-center text-sm border-t border-white/10 pt-4">
    <p class="text-mountain-400">Sudah memiliki akun? 
        <a href="{{ route('login') }}" class="text-forest-400 hover:text-forest-300 font-semibold transition-all duration-200">Masuk Sekarang</a>
    </p>
</div>
@endsection
