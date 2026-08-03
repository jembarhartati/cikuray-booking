@extends('layouts.admin')

@section('title', 'Tambah Knowledge Base')
@section('page-title', 'Tambah Knowledge Base')
@section('page-subtitle', 'Buat data pertanyaan dan kata kunci chatbot baru.')

@section('content')
<div class="card p-6 md:p-8 max-w-2xl mx-auto animate-fade-in">
    <div class="border-b border-mountain-100 pb-4 mb-6">
        <h3 class="font-display font-bold text-mountain-850">Formulir Chatbot Knowledge Base</h3>
    </div>

    <form action="{{ route('admin.knowledge-base.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Kategori -->
        <div>
            <label for="kategori" class="form-label">Kategori Informasi</label>
            <select name="kategori" id="kategori" class="form-input" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="biaya" {{ old('kategori') === 'biaya' ? 'selected' : '' }}>Biaya & Tiket</option>
                <option value="jadwal" {{ old('kategori') === 'jadwal' ? 'selected' : '' }}>Jadwal Buka/Tutup</option>
                <option value="kuota" {{ old('kategori') === 'kuota' ? 'selected' : '' }}>Kuota Kuota Harian</option>
                <option value="perlengkapan" {{ old('kategori') === 'perlengkapan' ? 'selected' : '' }}>Perlengkapan Wajib</option>
                <option value="aturan" {{ old('kategori') === 'aturan' ? 'selected' : '' }}>Aturan & Larangan</option>
                <option value="booking" {{ old('kategori') === 'booking' ? 'selected' : '' }}>Prosedur Booking</option>
                <option value="pembayaran" {{ old('kategori') === 'pembayaran' ? 'selected' : '' }}>Prosedur Pembayaran</option>
                <option value="umum" {{ old('kategori') === 'umum' ? 'selected' : '' }}>Umum / Lainnya</option>
            </select>
            @error('kategori')
                <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Pertanyaan Contoh -->
        <div>
            <label for="pertanyaan" class="form-label">Contoh Pertanyaan Pendaki</label>
            <input type="text" name="pertanyaan" id="pertanyaan" class="form-input" 
                   value="{{ old('pertanyaan') }}" placeholder="Misal: Berapa harga tiket masuk?" required>
            @error('pertanyaan')
                <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kata Kunci Pemicu -->
        <div>
            <label for="kata_kunci" class="form-label">Kata Kunci Pemicu (Pisahkan dengan Koma)</label>
            <input type="text" name="kata_kunci" id="kata_kunci" class="form-input" 
                   value="{{ old('kata_kunci') }}" placeholder="Misal: tiket, biaya, harga, tarif, bayar" required>
            <span class="text-xs text-mountain-400 mt-1 block">Tulis kata-kata penting yang paling mungkin dicari pendaki. Pisahkan setiap kata dengan tanda koma.</span>
            @error('kata_kunci')
                <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jawaban Chatbot -->
        <div>
            <label for="jawaban" class="form-label">Jawaban Otomatis Chatbot</label>
            <textarea name="jawaban" id="jawaban" rows="4" class="form-input resize-none" 
                      placeholder="Tulis respon jawaban chatbot..." required>{{ old('jawaban') }}</textarea>
            @error('jawaban')
                <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status Aktif -->
        <div class="flex items-center gap-2 pt-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                   class="w-4 h-4 rounded border-mountain-300 text-forest-600 focus:ring-forest-500">
            <label for="is_active" class="text-sm font-semibold text-mountain-700 select-none cursor-pointer">Aktifkan data ini langsung ke chatbot</label>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t border-mountain-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.knowledge-base.index') }}" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Simpan Data KB ➔
            </button>
        </div>
    </form>
</div>
@endsection
