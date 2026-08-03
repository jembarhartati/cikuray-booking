@extends('layouts.admin')

@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal Baru')
@section('page-subtitle', 'Buka tanggal pendakian baru untuk dipesan oleh pendaki.')

@section('content')
<div class="card p-6 md:p-8 max-w-2xl mx-auto animate-fade-in">
    <div class="border-b border-mountain-100 pb-4 mb-6">
        <h3 class="font-display font-bold text-mountain-850">Formulir Jadwal Pendakian</h3>
    </div>

    <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Tanggal -->
        <div>
            <label for="tanggal" class="form-label">Tanggal Pendakian</label>
            <input type="date" name="tanggal" id="tanggal" class="form-input" 
                   value="{{ old('tanggal') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            <span class="text-xs text-mountain-400 mt-1 block">Hanya diperbolehkan membuat jadwal untuk besok dan seterusnya.</span>
            @error('tanggal')
                <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kuota Maksimal -->
        <div>
            <label for="kuota_maksimal" class="form-label">Kuota Maksimal (Orang/Hari)</label>
            <input type="number" name="kuota_maksimal" id="kuota_maksimal" class="form-input" 
                   value="{{ old('kuota_maksimal', 200) }}" min="1" max="200" required>
            <span class="text-xs text-mountain-400 mt-1 block">Batas maksimal kuota standar adalah 200 orang per hari.</span>
            @error('kuota_maksimal')
                <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="form-label">Status Awal</label>
            <select name="status" id="status" class="form-input" required>
                <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif (Dapat Dipesan)</option>
                <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif (Ditutup Sementara)</option>
            </select>
            @error('status')
                <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Keterangan -->
        <div>
            <label for="keterangan" class="form-label">Keterangan / Catatan Tambahan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-input resize-none" 
                      placeholder="Tulis informasi khusus jika ada (misal: penutupan sebagian rute, cuaca, dll.)">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <p class="mt-1 text-xs text-red-500 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t border-mountain-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.jadwal.index') }}" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Simpan Jadwal ➔
            </button>
        </div>
    </form>
</div>
@endsection
