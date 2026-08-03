@extends('layouts.admin')

@section('title', 'Knowledge Base Chatbot')
@section('page-title', '🤖 Asisten AI Knowledge Base')
@section('page-subtitle', 'Kelola basis pengetahuan chatbot untuk membantu menjawab pertanyaan pendaki secara otomatis.')

@section('content')
@php
    $categories = [
        'biaya' => ['label' => 'Biaya & Tiket', 'icon' => '💵', 'color' => 'bg-emerald-50 text-emerald-700 border-emerald-100 hover:bg-emerald-100/50'],
        'jadwal' => ['label' => 'Jadwal Buka/Tutup', 'icon' => '📅', 'color' => 'bg-blue-50 text-blue-700 border-blue-100 hover:bg-blue-100/50'],
        'kuota' => ['label' => 'Kuota Harian', 'icon' => '🎟️', 'color' => 'bg-amber-50 text-amber-700 border-amber-100 hover:bg-amber-100/50'],
        'perlengkapan' => ['label' => 'Perlengkapan Wajib', 'icon' => '🎒', 'color' => 'bg-purple-50 text-purple-700 border-purple-100 hover:bg-purple-100/50'],
        'aturan' => ['label' => 'Aturan & Larangan', 'icon' => '🚫', 'color' => 'bg-red-50 text-red-700 border-red-100 hover:bg-red-100/50'],
        'booking' => ['label' => 'Prosedur Booking', 'icon' => '📝', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-100 hover:bg-indigo-100/50'],
        'pembayaran' => ['label' => 'Prosedur Pembayaran', 'icon' => '💳', 'color' => 'bg-cyan-50 text-cyan-700 border-cyan-100 hover:bg-cyan-100/50'],
        'umum' => ['label' => 'Umum / Lainnya', 'icon' => '💬', 'color' => 'bg-slate-50 text-slate-700 border-slate-100 hover:bg-slate-100/50'],
    ];
@endphp

<!-- Statistics Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Stat 1 -->
    <div class="stat-card animate-fade-in">
        <div class="stat-icon bg-forest-50 text-forest-600">
            🤖
        </div>
        <div>
            <p class="text-xs font-semibold text-mountain-400 uppercase tracking-wider">Total Pengetahuan</p>
            <h3 class="text-2xl font-display font-bold text-mountain-800 mt-0.5">{{ $totalItems }}</h3>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="stat-card animate-fade-in" style="animation-delay: 100ms;">
        <div class="stat-icon bg-forest-100 text-forest-700">
            🟢
        </div>
        <div>
            <p class="text-xs font-semibold text-mountain-400 uppercase tracking-wider">Aktif di Chatbot</p>
            <h3 class="text-2xl font-display font-bold text-mountain-800 mt-0.5">{{ $activeItems }}</h3>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="stat-card animate-fade-in" style="animation-delay: 200ms;">
        <div class="stat-icon bg-amber-50 text-amber-600">
            ⚠️
        </div>
        <div>
            <p class="text-xs font-semibold text-mountain-400 uppercase tracking-wider">Draft / Nonaktif</p>
            <h3 class="text-2xl font-display font-bold text-mountain-800 mt-0.5">{{ $inactiveItems }}</h3>
        </div>
    </div>
</div>

<!-- Control Panel: Filter, Search, Action -->
<div class="card p-5 mb-6 animate-fade-in" style="animation-delay: 150ms;">
    <form action="{{ route('admin.knowledge-base.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4 items-center justify-between">
        <!-- Search Bar -->
        <div class="relative w-full lg:w-96">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-sm">
                🔍
            </span>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari pertanyaan, jawaban, atau kata kunci..." class="form-input py-2.5 text-sm" style="padding-left: 2.75rem; padding-right: 4rem;">
            @if($search)
                <a href="{{ route('admin.knowledge-base.index', ['category' => $category]) }}" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-mountain-450 hover:text-mountain-600 text-xs font-semibold">
                    Batal
                </a>
            @endif
        </div>

        <!-- Filters & Action Button -->
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto justify-end">
            <!-- Category Filter -->
            <select name="category" onchange="this.form.submit()" class="form-input py-2.5 text-sm w-full sm:w-52">
                <option value="">Semua Kategori</option>
                @foreach($categories as $key => $cat)
                    <option value="{{ $key }}" {{ $category === $key ? 'selected' : '' }}>
                        {{ $cat['icon'] }} {{ $cat['label'] }}
                    </option>
                @endforeach
            </select>

            @if($search || $category)
                <a href="{{ route('admin.knowledge-base.index') }}" class="btn-secondary py-2.5 text-sm w-full sm:w-auto justify-center text-center">
                    Reset
                </a>
            @endif

            <a href="{{ route('admin.knowledge-base.create') }}" class="btn-primary py-2.5 text-sm w-full sm:w-auto whitespace-nowrap justify-center">
                <span>✨</span> Tambah Data KB
            </a>
        </div>
    </form>
</div>

<!-- Main Content Grid -->
@if($items->isEmpty())
    <div class="card p-12 text-center animate-fade-in" style="animation-delay: 200ms;">
        <div class="w-20 h-20 bg-forest-50 text-forest-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl animate-float">
            🤖
        </div>
        <h3 class="font-display font-bold text-mountain-850 text-lg">Basis Pengetahuan Tidak Ditemukan</h3>
        <p class="text-sm text-mountain-500 mt-1.5 max-w-md mx-auto">
            @if($search || $category)
                Tidak ada data basis pengetahuan yang cocok dengan kata kunci "{{ $search }}" atau filter kategori yang dipilih.
            @else
                Silakan buat data pertanyaan, kata kunci pemicu, dan jawaban otomatis untuk mengaktifkan asisten pintar chatbot.
            @endif
        </p>
        <div class="mt-6 flex justify-center gap-3">
            @if($search || $category)
                <a href="{{ route('admin.knowledge-base.index') }}" class="btn-secondary">
                    Reset Pencarian
                </a>
            @endif
            <a href="{{ route('admin.knowledge-base.create') }}" class="btn-primary">
                Tambah Data Pertama
            </a>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 250ms;">
        @foreach($items as $index => $item)
            @php
                $catInfo = $categories[$item->kategori] ?? ['label' => $item->kategori, 'icon' => '💬', 'color' => 'bg-slate-50 text-slate-700 border-slate-100'];
            @endphp
            <div class="card hover:shadow-md hover:border-forest-200 transition-all duration-300 flex flex-col justify-between group relative animate-fade-in-up" style="animation-delay: {{ $index * 50 }}ms;">
                
                <div class="p-6 pb-5 flex-1">
                    <!-- Top Header (Category & Status) -->
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <!-- Category Badge -->
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold border {{ $catInfo['color'] }} transition-all duration-200">
                            <span>{{ $catInfo['icon'] }}</span>
                            <span>{{ $catInfo['label'] }}</span>
                        </span>

                        <!-- Status Badge -->
                        <div>
                            @if($item->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-forest-50 text-forest-700 border border-forest-100 shadow-sm whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-forest-500 animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-mountain-50 text-mountain-500 border border-mountain-200 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-mountain-400"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Question -->
                    <div class="mb-4">
                        <p class="text-[10px] font-bold text-mountain-400 uppercase tracking-wider mb-1">Pertanyaan Contoh</p>
                        <h4 class="font-display font-bold text-mountain-850 text-base leading-snug group-hover:text-forest-700 transition-colors">
                            "{{ $item->pertanyaan }}"
                        </h4>
                    </div>

                    <!-- Trigger Keywords -->
                    <div class="mb-5">
                        <p class="text-[10px] font-bold text-mountain-400 uppercase tracking-wider mb-1.5">Kata Kunci Pemicu</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($item->kata_kunci as $tag)
                                <span class="px-2 py-0.5 bg-mountain-50 group-hover:bg-mountain-100/70 border border-mountain-200 rounded-lg text-xs font-mono text-mountain-600 transition-all duration-200">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Chat Answer Bubble -->
                    <div>
                        <p class="text-[10px] font-bold text-mountain-400 uppercase tracking-wider mb-1.5">Respon Jawaban Chatbot</p>
                        <div class="p-4 bg-mountain-50 group-hover:bg-forest-50/10 rounded-2xl border border-mountain-100 relative transition-all duration-300">
                            <!-- Bubble pointer -->
                            <div class="absolute -top-1.5 left-5 w-3 h-3 bg-mountain-50 border-t border-l border-mountain-100 rotate-45 group-hover:bg-forest-50/10 transition-all duration-300"></div>
                            <p class="text-sm text-mountain-600 line-clamp-4 relative z-10 leading-relaxed font-normal" title="{{ $item->jawaban }}">
                                {{ $item->jawaban }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card Footer Actions -->
                <div class="px-6 py-4 bg-mountain-50/30 border-t border-mountain-100 flex items-center justify-between rounded-b-2xl mt-auto">
                    <span class="text-[10px] text-mountain-400 font-medium">
                        Diperbarui {{ $item->updated_at->diffForHumans() }}
                    </span>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.knowledge-base.edit', $item) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white hover:bg-forest-50 border border-mountain-200 hover:border-forest-200 text-mountain-700 hover:text-forest-700 rounded-xl text-xs font-bold shadow-sm transition-all duration-200 whitespace-nowrap">
                            ✏️ Edit
                        </a>
                        
                        <form action="{{ route('admin.knowledge-base.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                           @csrf
                           @method('DELETE')
                           <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-650 rounded-xl text-xs font-bold transition-all duration-200 whitespace-nowrap">
                               🗑️ Hapus
                           </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $items->links('partials.pagination') }}
    </div>
@endif
@endsection
