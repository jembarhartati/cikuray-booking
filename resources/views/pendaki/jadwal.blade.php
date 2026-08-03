@extends('layouts.pendaki')

@section('title', 'Jadwal & Kuota Pendakian')

@section('content')
<!-- ═══════════ HERO ═══════════ -->
<section class="hero-section py-10 md:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-white animate-fade-in-up">
                <p class="text-forest-300 text-sm font-medium mb-2">📅 Jadwal Pendakian</p>
                <h2 class="text-3xl md:text-4xl font-display font-extrabold leading-tight mb-2">Jadwal & Kuota Pendakian</h2>
                <p class="text-mountain-300 text-sm max-w-lg">
                    Pilih tanggal pendakian Anda. Demi pelestarian ekosistem Gunung Cikuray, kuota dibatasi maksimal <strong class="text-white">200 pendaki per hari</strong>.
                </p>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 px-6 py-4 text-center flex-shrink-0">
                <span class="block text-xs uppercase tracking-widest text-forest-300 font-semibold mb-1">Kuota Per Hari</span>
                <span class="text-3xl font-bold font-display text-white">200</span>
                <span class="text-sm text-mountain-300 ml-1">Orang</span>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ SCHEDULES ═══════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-8">
    @if($jadwals->isEmpty())
        <div class="glass-card p-12 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-mountain-100 to-mountain-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                📅
            </div>
            <h4 class="font-display font-bold text-mountain-700 text-lg">Tidak Ada Jadwal Pendakian Aktif</h4>
            <p class="text-sm text-mountain-400 mt-2 max-w-sm mx-auto">Saat ini belum ada jadwal pendakian yang dibuka oleh administrator. Silakan hubungi basecamp untuk informasi lebih lanjut.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($jadwals as $jadwal)
                @php
                    $persen = $jadwal->kuota_maksimal > 0 ? round(($jadwal->kuota_terisi / $jadwal->kuota_maksimal) * 100) : 0;
                    $sisaKuota = $jadwal->sisa_kuota;
                    $isTutup = $jadwal->status === 'nonaktif';
                    $isPenuh = $sisaKuota <= 0;
                    
                    if ($isTutup) {
                        $barColor = 'bg-red-500/50';
                        $statusText = 'DITUTUP ❌';
                        $statusClass = 'badge-danger bg-red-100 text-red-700 border border-red-200';
                    } elseif ($isPenuh) {
                        $barColor = 'bg-red-500';
                        $statusText = 'PENUH ❌';
                        $statusClass = 'badge-danger bg-red-100 text-red-700 border border-red-200';
                    } elseif ($sisaKuota <= 50) {
                        $barColor = 'bg-amber-500';
                        $statusText = 'Hampir Penuh';
                        $statusClass = 'badge-warning';
                    } else {
                        $barColor = 'bg-forest-500';
                        $statusText = 'Tersedia';
                        $statusClass = 'badge-success';
                    }
                @endphp
                <div class="schedule-card flex flex-col transition-all duration-300 {{ ($isTutup || $isPenuh) ? 'border-red-200 bg-red-50/5 opacity-80' : '' }}">
                    <!-- Date Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br {{ ($isTutup || $isPenuh) ? 'from-red-100 to-red-50 text-red-700 border-red-200' : 'from-forest-100 to-emerald-50 text-forest-700 border-forest-200' }} rounded-xl flex flex-col items-center justify-center border">
                                <span class="text-xs font-bold leading-none">{{ $jadwal->tanggal->format('d') }}</span>
                                <span class="text-[9px] font-medium uppercase">{{ $jadwal->tanggal->locale('id')->isoFormat('MMM') }}</span>
                            </div>
                            <div>
                                <h4 class="font-display font-bold text-mountain-800 text-sm {{ $isTutup ? 'line-through text-red-400' : '' }}">{{ $jadwal->tanggal->locale('id')->isoFormat('dddd') }}</h4>
                                <p class="text-xs text-mountain-400">{{ $jadwal->tanggal->locale('id')->isoFormat('D MMMM Y') }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusClass }}">{{ $statusText }}</span>
                    </div>

                    <!-- Quota Progress -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-mountain-500 font-medium">Kuota Terisi</span>
                            <span class="font-bold text-mountain-700">{{ $jadwal->kuota_terisi }} / {{ $jadwal->kuota_maksimal }}</span>
                        </div>
                        <div class="quota-bar bg-mountain-100 rounded-full h-2 overflow-hidden">
                            <div class="quota-bar-fill {{ $barColor }} h-full transition-all duration-500" style="width: {{ $persen }}%"></div>
                        </div>
                        <p class="text-xs text-mountain-400 mt-1.5">
                            @if($isTutup)
                                <span class="text-red-500 font-semibold">Pendaftaran ditutup oleh admin</span>
                            @elseif($isPenuh)
                                <span class="text-red-500 font-semibold">Kuota telah habis terjual</span>
                            @else
                                Sisa <strong class="text-mountain-700">{{ $sisaKuota }} orang</strong> lagi
                            @endif
                        </p>
                    </div>

                    <!-- Keterangan dari Admin -->
                    @if($jadwal->keterangan)
                        <div class="mb-4 p-3 {{ $isTutup ? 'bg-red-50 border-red-200 text-red-700' : 'bg-mountain-50 border-mountain-100 text-mountain-600' }} border rounded-xl text-xs">
                            <strong class="{{ $isTutup ? 'text-red-800' : 'text-mountain-700' }} block mb-0.5">{{ $isTutup ? '🚫 Alasan Penutupan:' : 'ℹ️ Keterangan:' }}</strong>
                            {{ $jadwal->keterangan }}
                        </div>
                    @endif

                    <!-- Action -->
                    <div class="mt-auto pt-3 border-t border-mountain-100">
                        @if(!$isTutup && !$isPenuh)
                            <a href="{{ route('pendaki.booking.create', ['jadwal_id' => $jadwal->id]) }}" class="btn-primary w-full justify-center py-2.5 text-sm">
                                Booking Tiket →
                            </a>
                        @else
                            <button disabled class="w-full py-2.5 bg-red-100/50 text-red-600 rounded-xl text-sm font-bold cursor-not-allowed flex items-center justify-center gap-1.5 border border-red-200">
                                ❌ {{ $isTutup ? 'Pendaftaran Ditutup' : 'Kuota Penuh' }}
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
