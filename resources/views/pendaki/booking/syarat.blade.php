@extends('layouts.pendaki')

@section('title', 'Syarat & Ketentuan Pendakian')

@section('content')
<!-- ═══════════ HERO ═══════════ -->
<section class="hero-section py-10 md:py-14 text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up">
        <p class="text-forest-300 text-sm font-medium mb-2 uppercase tracking-wider">⚠️ Persyaratan Penting</p>
        <h2 class="text-3xl md:text-5xl font-display font-extrabold text-white leading-tight">Syarat & Ketentuan Pendakian</h2>
        <p class="text-mountain-300 text-sm md:text-base mt-3 max-w-xl mx-auto">
            Demi keselamatan bersama dan kelestarian ekosistem Gunung Cikuray, harap baca dan setujui syarat & ketentuan berikut sebelum melanjutkan pemesanan tiket.
        </p>
    </div>
</section>

<!-- ═══════════ T&C CARDS ═══════════ -->
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-12">
    <div class="glass-card p-6 md:p-8 space-y-8">
        
        <!-- Grid Ketentuan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Harga & Biaya -->
            <div class="p-5 rounded-2xl bg-forest-950/20 border border-forest-500/10 space-y-3">
                <div class="w-10 h-10 bg-forest-500/10 border border-forest-500/20 rounded-xl flex items-center justify-center text-xl">
                    💵
                </div>
                <h3 class="font-display font-bold text-mountain-850 text-base">Detail Biaya</h3>
                <ul class="text-xs text-mountain-500 space-y-2">
                    <li class="flex items-start gap-1.5">
                        <span class="text-forest-500">•</span>
                        <span><strong>Tiket Masuk:</strong> Rp30.000 / orang per malam.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-forest-500">•</span>
                        <span><strong>Retribusi Sampah:</strong> Wajib membawa kantong sampah (trash bag).</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-forest-500">•</span>
                        <span><strong>Pembayaran:</strong> Melalui transfer bank manual atau instan via Midtrans.</span>
                    </li>
                </ul>
            </div>

            <!-- Aturan & Larangan -->
            <div class="p-5 rounded-2xl bg-red-950/20 border border-red-500/10 space-y-3">
                <div class="w-10 h-10 bg-red-500/10 border border-red-500/20 rounded-xl flex items-center justify-center text-xl">
                    🚫
                </div>
                <h3 class="font-display font-bold text-mountain-850 text-base">Aturan & Larangan</h3>
                <ul class="text-xs text-mountain-500 space-y-2">
                    <li class="flex items-start gap-1.5">
                        <span class="text-red-500">•</span>
                        <span>Dilarang membuang sampah sembarangan di sepanjang jalur pendakian.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-red-500">•</span>
                        <span>Dilarang membawa senjata tajam (kecuali pisau masak standar), miras, & obat terlarang.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-red-500">•</span>
                        <span>Dilarang merusak tumbuhan, memetik bunga Edelweis, atau mengganggu satwa liar.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-red-500">•</span>
                        <span>Dilarang membawa tisu basah (kecuali tisu kering yang diberi air).</span>
                    </li>
                </ul>
            </div>

            <!-- Peralatan Wajib -->
            <div class="p-5 rounded-2xl bg-amber-950/20 border border-amber-500/10 space-y-3">
                <div class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-center justify-center text-xl">
                    ⛺
                </div>
                <h3 class="font-display font-bold text-mountain-850 text-base">Peralatan Wajib</h3>
                <ul class="text-xs text-mountain-500 space-y-2">
                    <li class="flex items-start gap-1.5">
                        <span class="text-amber-500">•</span>
                        <span>Tenda dome layak pakai sesuai kapasitas rombongan.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-amber-500">•</span>
                        <span>Sleeping bag, matras, jaket gunung hangat, & jas hujan.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-amber-500">•</span>
                        <span>Kompor gas portable, logistik makanan, air minum, & P3K pribadi.</span>
                    </li>
                    <li class="flex items-start gap-1.5">
                        <span class="text-amber-500">•</span>
                        <span>Headlamp/Senter serta sepatu pendakian yang layak.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Warning Area -->
        <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 flex gap-3 text-xs text-amber-700">
            <span class="text-lg flex-shrink-0">⚠️</span>
            <div>
                <p class="font-bold uppercase tracking-wider mb-0.5">Ketentuan Pembatalan & Kuota</p>
                <p class="leading-relaxed">
                    Kuota maksimal pendakian harian adalah 200 orang. Tiket yang sudah dipesan tidak dapat dibatalkan atau direfund, namun bisa diajukan reschedule dengan menghubungi admin minimal H-3 dari jadwal pendakian semula.
                </p>
            </div>
        </div>

        <!-- Form Persetujuan -->
        <form action="{{ route('pendaki.booking.syarat.setuju') }}" method="POST" class="pt-6 border-t border-mountain-100 space-y-4">
            @csrf

            <label class="flex items-start gap-3 p-4 bg-mountain-50 border border-mountain-200 rounded-2xl cursor-pointer select-none hover:bg-mountain-100/30 transition-all">
                <input type="checkbox" name="setuju" id="setuju" value="1" class="w-5 h-5 rounded border-mountain-300 text-forest-600 focus:ring-forest-500 mt-0.5" required>
                <div class="text-xs md:text-sm text-mountain-700">
                    <span class="font-bold text-mountain-850 block mb-0.5">Saya Menyetujui Syarat & Ketentuan</span>
                    Saya menyatakan bahwa saya telah membaca, memahami, dan siap menaati seluruh ketentuan tarif, tata tertib, larangan, serta membawa perlengkapan wajib yang berlaku di Gunung Cikuray via Cintanagara.
                </div>
            </label>
            @error('setuju')
                <p class="text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
                <a href="{{ route('pendaki.jadwal') }}" class="btn-secondary py-3.5 text-center justify-center border border-mountain-250 bg-white">
                    ✕ Batalkan
                </a>
                <button type="submit" class="btn-primary py-3.5 justify-center shadow-xl shadow-forest-600/30">
                    Setujui & Lanjutkan ke Booking →
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
