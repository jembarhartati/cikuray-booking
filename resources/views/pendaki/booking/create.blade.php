@extends('layouts.pendaki')

@section('title', 'Booking Tiket Pendakian')

@section('content')
<!-- ═══════════ HERO ═══════════ -->
<section class="hero-section py-8 md:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up">
        <div class="text-white text-center max-w-2xl mx-auto">
            <p class="text-forest-300 text-sm font-medium mb-2">🎫 Booking Tiket</p>
            <h2 class="text-3xl md:text-4xl font-display font-extrabold leading-tight">Formulir Booking Tiket</h2>
            <p class="text-mountain-300 text-sm mt-2">Silakan isi formulir pendaftaran rombongan pendakian Anda.</p>
        </div>
        <!-- Stepper -->
        <div class="flex items-center justify-center gap-0 mt-8 max-w-md mx-auto">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-forest-700 font-bold text-xs shadow-lg">1</div>
                <span class="text-white text-xs font-medium hidden sm:inline">Isi Data</span>
            </div>
            <div class="flex-1 h-px bg-white/30 mx-3"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white/60 font-bold text-xs border border-white/20">2</div>
                <span class="text-white/50 text-xs font-medium hidden sm:inline">Bayar</span>
            </div>
            <div class="flex-1 h-px bg-white/30 mx-3"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white/60 font-bold text-xs border border-white/20">3</div>
                <span class="text-white/50 text-xs font-medium hidden sm:inline">E-Ticket</span>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ FORM ═══════════ -->
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-10 pb-8">
    <div class="glass-card p-0 overflow-hidden">
        <form action="{{ route('pendaki.booking.store') }}" method="POST" id="bookingForm" novalidate>
            @csrf

            {{-- ══ SECTION 1: Jadwal Pendakian ══ --}}
            <div class="p-6 md:p-8 border-b border-mountain-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-sm shadow-md">📅</div>
                    <div>
                        <h3 class="font-display font-bold text-mountain-800 text-base">Jadwal Pendakian</h3>
                        <p class="text-xs text-mountain-400">Pilih tanggal naik dan turun gunung</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="jadwal_id" class="form-label">Tanggal Naik <span class="text-red-500">*</span></label>
                        <select name="jadwal_id" id="jadwal_id" class="form-input" required onchange="updateQuotaInfo()">
                            <option value="">-- Pilih Tanggal Naik --</option>
                            @foreach($jadwals as $j)
                                <option value="{{ $j->id }}" 
                                        data-sisa="{{ $j->sisaKuota() }}"
                                        data-tanggal="{{ $j->tanggal->toDateString() }}"
                                        {{ (old('jadwal_id') == $j->id || ($selectedJadwal && $selectedJadwal->id == $j->id)) ? 'selected' : '' }}>
                                    {{ $j->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }} (Sisa: {{ $j->sisaKuota() }})
                                </option>
                            @endforeach
                        </select>
                        <p id="quota-warning" class="mt-1.5 text-xs text-red-500 font-semibold hidden">
                            ⚠️ Sisa kuota tinggal <span id="quota-remaining">0</span> orang!
                        </p>
                        @error('jadwal_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_turun" class="form-label">Tanggal Turun <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_turun" id="tanggal_turun" class="form-input" 
                               value="{{ old('tanggal_turun') }}" required min="{{ date('Y-m-d') }}" onchange="updatePrice()">
                        @error('tanggal_turun')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ══ SECTION 2: Data Ketua Rombongan ══ --}}
            <div class="p-6 md:p-8 border-b border-mountain-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-forest-500 to-emerald-600 flex items-center justify-center text-white text-sm shadow-md">👤</div>
                    <div>
                        <h3 class="font-display font-bold text-mountain-800 text-base">Data Ketua Rombongan</h3>
                        <p class="text-xs text-mountain-400">Informasi penanggung jawab rombongan</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="nama_ketua" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_ketua" id="nama_ketua" class="form-input" 
                               placeholder="Nama lengkap ketua" value="{{ old('nama_ketua', auth()->user()->name) }}" required>
                        @error('nama_ketua')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="no_telepon" class="form-label">No. Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="no_telepon" id="no_telepon" class="form-input" 
                               placeholder="08xxxxxxxxxx" value="{{ old('no_telepon', auth()->user()->pendaki->no_telepon ?? '') }}" required>
                        @error('no_telepon')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="no_darurat" class="form-label">No. HP Keluarga / Kontak Darurat <span class="text-red-500">*</span></label>
                        <input type="text" name="no_darurat" id="no_darurat" class="form-input" 
                               placeholder="08xxxxxxxxxx (keluarga yang bisa dihubungi)" value="{{ old('no_darurat') }}" required>
                        @error('no_darurat')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ══ SECTION 3: Alamat Asal ══ --}}
            <div class="p-6 md:p-8 border-b border-mountain-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white text-sm shadow-md">📍</div>
                    <div>
                        <h3 class="font-display font-bold text-mountain-800 text-base">Alamat Asal</h3>
                        <p class="text-xs text-mountain-400">Domisili tempat tinggal ketua rombongan</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="provinsi" class="form-label">Provinsi <span class="text-red-500">*</span></label>
                        <select name="provinsi" id="provinsi" class="form-input" required onchange="updateKabupatenOptions()">
                            <option value="">-- Pilih Provinsi --</option>
                        </select>
                        @error('provinsi')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="kabupaten" class="form-label">Kota / Kabupaten <span class="text-red-500">*</span></label>
                        <select name="kabupaten" id="kabupaten" class="form-input" required>
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                        </select>
                        @error('kabupaten')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="detail_alamat" class="form-label">Detail Alamat (Jalan, RT/RW, Kec., Kel.) <span class="text-red-500">*</span></label>
                        <textarea name="detail_alamat" id="detail_alamat" rows="2" class="form-input resize-none" 
                                  placeholder="Masukkan detail jalan, RT/RW, kecamatan, dan kelurahan..." required>{{ old('detail_alamat') }}</textarea>
                        @error('detail_alamat')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ══ SECTION 4: Jumlah Pendaki & Anggota ══ --}}
            <div class="p-6 md:p-8 border-b border-mountain-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-500 to-violet-600 flex items-center justify-center text-white text-sm shadow-md">👥</div>
                    <div>
                        <h3 class="font-display font-bold text-mountain-800 text-base">Anggota Rombongan</h3>
                        <p class="text-xs text-mountain-400">Minimal 2 orang per rombongan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                    <div>
                        <label for="jumlah_pendaki" class="form-label">Jumlah Pendaki <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_pendaki" id="jumlah_pendaki" class="form-input" 
                               min="0" value="{{ old('jumlah_pendaki', 0) }}" required oninput="generateMemberInputs()">
                        <span class="text-[11px] text-mountain-400 mt-1 block">Min. 2 orang per booking</span>
                        <p id="jumlah-pendaki-warning" class="hidden mt-1 text-xs text-red-500 font-semibold">⚠️ Minimal 2 orang dalam satu booking!</p>
                        @error('jumlah_pendaki')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Estimasi Biaya</label>
                        <div class="bg-gradient-to-r from-forest-50 to-emerald-50 border border-forest-200/60 p-4 rounded-xl flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-forest-600 font-bold uppercase tracking-wider block">Total Biaya</span>
                                <span id="price-per-person-display" class="text-xs text-mountain-400 font-medium">Rp30.000 / orang / hari</span>
                            </div>
                            <span class="text-2xl font-bold font-display text-forest-700" id="total-price-display">Rp0</span>
                        </div>
                    </div>
                </div>

                {{-- Daftar Nama Anggota --}}
                <div class="bg-mountain-50/50 rounded-xl p-4 md:p-5 border border-mountain-100">
                    <h4 class="text-xs font-bold text-mountain-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                        📝 Daftar Nama Anggota
                    </h4>
                    <div id="members-container" class="space-y-2.5">
                        <!-- Inputs generated by JS -->
                    </div>
                </div>
            </div>

            {{-- ══ SECTION 5: Submit ══ --}}
            <div class="p-6 md:p-8 bg-mountain-50/30 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-mountain-400 max-w-md">
                    Dengan mengirim formulir ini, Anda menyetujui <strong class="text-mountain-600">syarat & ketentuan</strong> pendakian Gunung Cikuray via Cintanagara.
                </p>
                <button type="submit" class="btn-primary w-full sm:w-auto px-8 py-3.5 justify-center text-sm font-bold shadow-lg shadow-forest-600/20">
                    Kirim Booking & Lanjut Bayar →
                </button>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    const regions = {
        "Aceh": ["Banda Aceh", "Langsa", "Lhokseumawe", "Sabang", "Subulussalam", "Aceh Besar", "Aceh Utara", "Aceh Timur", "Aceh Tengah", "Aceh Barat", "Aceh Selatan", "Aceh Singkil", "Aceh Tamiang", "Aceh Tenggara", "Bener Meriah", "Bireuen", "Gayo Lues", "Nagan Raya", "Pidie", "Pidie Jaya", "Simeulue"],
        "Bali": ["Denpasar", "Badung", "Bangli", "Buleleng", "Gianyar", "Jembrana", "Karangasem", "Klungkung", "Tabanan"],
        "Banten": ["Cilegon", "Serang", "Tangerang", "Tangerang Selatan", "Lebak", "Pandeglang"],
        "Bengkulu": ["Bengkulu Kota", "Bengkulu Selatan", "Bengkulu Tengah", "Bengkulu Utara", "Kaur", "Kepahiang", "Lebong", "Mukomuko", "Rejang Lebong", "Seluma"],
        "Daerah Istimewa Yogyakarta": ["Yogyakarta", "Bantul", "Gunungkidul", "Kulon Progo", "Sleman"],
        "DKI Jakarta": ["Jakarta Barat", "Jakarta Pusat", "Jakarta Selatan", "Jakarta Timur", "Jakarta Utara", "Kepulauan Seribu"],
        "Gorontalo": ["Gorontalo Kota", "Boalemo", "Bone Bolango", "Gorontalo Kabupaten", "Gorontalo Utara", "Pohuwato"],
        "Jambi": ["Jambi Kota", "Sungaipenuh", "Batanghari", "Bungo", "Kerinci", "Merangin", "Muaro Jambi", "Sarolangun", "Tanjung Jabung Barat", "Tanjung Jabung Timur", "Tebo"],
        "Jawa Barat": ["Bandung", "Bandung Barat", "Banjar", "Bekasi", "Bogor", "Ciamis", "Cianjur", "Cimahi", "Cirebon", "Depok", "Garut", "Indramayu", "Karawang", "Kuningan", "Majalengka", "Pangandaran", "Purwakarta", "Subang", "Sukabumi", "Sumedang", "Tasikmalaya"],
        "Jawa Tengah": ["Semarang", "Surakarta", "Magelang", "Pekalongan", "Salatiga", "Tegal", "Banjarnegara", "Banyumas", "Batang", "Blora", "Boyolali", "Brebes", "Cilacap", "Demak", "Grobogan", "Jepara", "Karanganyar", "Kebumen", "Kendal", "Klaten", "Kudus", "Pati", "Pemalang", "Purbalingga", "Purworejo", "Rembang", "Sragen", "Sukoharjo", "Temanggung", "Wonogiri", "Wonosobo"],
        "Jawa Timur": ["Batu", "Blitar", "Kediri", "Madiun", "Malang", "Mojokerto", "Pasuruan", "Probolinggo", "Surabaya", "Bangkalan", "Banyuwangi", "Bojonegoro", "Bondowoso", "Gresik", "Jember", "Jombang", "Lamongan", "Lumajang", "Magetan", "Nganjuk", "Ngawi", "Pacitan", "Pamekasan", "Pasuruan Kabupaten", "Ponorogo", "Sampang", "Sidoarjo", "Situbondo", "Sumenep", "Trenggalek", "Tuban", "Tulungagung"],
        "Kalimantan Barat": ["Pontianak", "Singkawang", "Bengkayang", "Kapuas Hulu", "Kayong Utara", "Ketapang", "Kubu Raya", "Landak", "Melawi", "Mempawah", "Sambas", "Sanggau", "Sekadau", "Sintang"],
        "Kalimantan Selatan": ["Banjarbaru", "Banjarmasin", "Balangan", "Banjar Kabupaten", "Barito Kuala", "Hulu Sungai Selatan", "Hulu Sungai Tengah", "Hulu Sungai Utara", "Kotabaru", "Tabalong", "Tanah Bumbu", "Tanah Laut", "Tapin"],
        "Kalimantan Tengah": ["Palangka Raya", "Barito Selatan", "Barito Timur", "Barito Utara", "Gunung Mas", "Kapuas", "Katingan", "Kotawaringin Barat", "Kotawaringin Timur", "Lamandau", "Murung Raya", "Pulang Pisau", "Sukamara", "Seruyan"],
        "Kalimantan Timur": ["Balikpapan", "Bontang", "Samarinda", "Berau", "Kutai Barat", "Kutai Kartanegara", "Kutai Timur", "Mahakam Ulu", "Paser", "Penajam Paser Utara"],
        "Kalimantan Utara": ["Tarakan", "Bulungan", "Malinau", "Nunukan", "Tana Tidung"],
        "Kepulauan Bangka Belitung": ["Pangkalpinang", "Bangka", "Bangka Barat", "Bangka Selatan", "Bangka Tengah", "Belitung", "Belitung Timur"],
        "Kepulauan Riau": ["Batam", "Tanjungpinang", "Bintan", "Karimun", "Kepulauan Anambas", "Lingga", "Natuna"],
        "Lampung": ["Bandar Lampung", "Metro", "Lampung Barat", "Lampung Selatan", "Lampung Tengah", "Lampung Timur", "Lampung Utara", "Mesuji", "Pesawaran", "Pesisir Barat", "Pringsewu", "Tanggamus", "Tulang Bawang", "Tulang Bawang Barat", "Way Kanan"],
        "Maluku": ["Ambon", "Tual", "Buru", "Buru Selatan", "Kepulauan Aru", "Kepulauan Tanimbar", "Maluku Barat Daya", "Maluku Tengah", "Maluku Tenggara", "Seram Bagian Barat", "Seram Bagian Timur"],
        "Maluku Utara": ["Ternate", "Tidore Kepulauan", "Halmahera Barat", "Halmahera Tengah", "Halmahera Timur", "Halmahera Selatan", "Halmahera Utara", "Kepulauan Sula", "Pulau Morotai", "Pulau Taliabu"],
        "Nusa Tenggara Barat": ["Bima Kota", "Mataram", "Bima Kabupaten", "Dompu", "Lombok Barat", "Lombok Tengah", "Lombok Timur", "Lombok Utara", "Sumbawa", "Sumbawa Barat"],
        "Nusa Tenggara Timur": ["Kupang Kota", "Alor", "Belu", "Ende", "Flores Timur", "Kupang Kabupaten", "Lembata", "Malaka", "Manggarai", "Manggarai Barat", "Manggarai Timur", "Nagekeo", "Ngada", "Rote Ndao", "Sabu Raijua", "Sikka", "Sumba Barat", "Sumba Barat Daya", "Sumba Tengah", "Sumba Timur", "Timor Tengah Selatan", "Timor Tengah Utara"],
        "Papua": ["Jayapura Kota", "Biak Numfor", "Jayapura Kabupaten", "Keerom", "Kepulauan Yapen", "Mamberamo Raya", "Sarmi", "Supiori", "Waropen"],
        "Papua Barat": ["Manokwari", "Fakfak", "Kaimana", "Manokwari Selatan", "Pegunungan Arfak", "Teluk Bintuni", "Teluk Wondama"],
        "Papua Barat Daya": ["Sorong Kota", "Maybrat", "Raja Ampat", "Sorong Kabupaten", "Sorong Selatan", "Tambrauw"],
        "Papua Pegunungan": ["Jayawijaya", "Lanny Jaya", "Mamberamo Tengah", "Nduga", "Pegunungan Bintang", "Tolikara", "Yahukimo", "Yalimo"],
        "Papua Selatan": ["Merauke", "Asmat", "Boven Digoel", "Mappi"],
        "Papua Tengah": ["Nabire", "Deiyai", "Dogiyai", "Intan Jaya", "Mimika", "Paniai", "Puncak", "Puncak Jaya"],
        "Riau": ["Dumai", "Pekanbaru", "Bengkalis", "Indragiri Hilir", "Indragiri Hulu", "Kampar", "Kepulauan Meranti", "Kuantan Singingi", "Pelalawan", "Rokan Hilir", "Rokan Hulu", "Siak"],
        "Sulawesi Barat": ["Majene", "Mamasa", "Mamuju", "Mamuju Tengah", "Pasangkayu", "Polewali Mandar"],
        "Sulawesi Selatan": ["Makassar", "Palopo", "Parepare", "Bantaeng", "Barru", "Bone", "Bulukumba", "Enrekang", "Gowa", "Jeneponto", "Kepulauan Selayar", "Luwu", "Luwu Timur", "Luwu Utara", "Maros", "Pangkajene dan Kepulauan", "Pinrang", "Sinjai", "Sidenreng Rappang", "Soppeng", "Takalar", "Tana Toraja", "Toraja Utara", "Wajo"],
        "Sulawesi Tengah": ["Palu", "Banggai", "Banggai Kepulauan", "Banggai Laut", "Buol", "Donggala", "Morowali", "Morowali Utara", "Parigi Moutong", "Poso", "Sigi", "Tojo Una-Una", "Toli-Toli"],
        "Sulawesi Tenggara": ["Kendari", "Bau-Bau", "Bombana", "Buton", "Buton Selatan", "Buton Tengah", "Buton Utara", "Kolaka", "Kolaka Timur", "Kolaka Utara", "Konawe", "Konawe Kepulauan", "Konawe Selatan", "Konawe Utara", "Muna", "Muna Barat", "Wakatobi"],
        "Sulawesi Utara": ["Bitung", "Kotamobagu", "Manado", "Tomohon", "Bolaang Mongondow", "Bolaang Mongondow Selatan", "Bolaang Mongondow Timur", "Bolaang Mongondow Utara", "Kepulauan Sangihe", "Kepulauan Siau Tagulandang Biaro", "Kepulauan Talaud", "Minahasa", "Minahasa Selatan", "Minahasa Tenggara", "Minahasa Utara"],
        "Sumatera Barat": ["Bukittinggi", "Padang", "Padang Panjang", "Pariaman", "Payakumbuh", "Sawahlunto", "Solok Kota", "Agam", "Dharmasraya", "Kepulauan Mentawai", "Lima Puluh Kota", "Padang Pariaman", "Pasaman", "Pasaman Barat", "Pesisir Selatan", "Sijunjung", "Solok Kabupaten", "Solok Selatan", "Tanah Datar"],
        "Sumatera Selatan": ["Lubuklinggau", "Pagar Alam", "Palembang", "Prabumulih", "Banyuasin", "Empat Lawang", "Muara Enim", "Musi Banyuasin", "Musi Rawas", "Musi Rawas Utara", "Ogan Ilir", "Ogan Komering Ilir", "Ogan Komering Ulu", "Ogan Komering Ulu Selatan", "Ogan Komering Ulu Timur", "Penukal Abab Lematang Ilir"],
        "Sumatera Utara": ["Binjai", "Gunungsitoli", "Medan", "Padangsidimpuan", "Pematangsiantar", "Sibolga", "Tanjungbalai", "Tebing Tinggi", "Asahan", "Batu Bara", "Dairi", "Deli Serdang", "Humbang Hasundutan", "Karo", "Labuhanbatu", "Labuhanbatu Selatan", "Labuhanbatu Utara", "Langkat", "Mandailing Natal", "Nias", "Nias Barat", "Nias Selatan", "Nias Utara", "Padang Lawas", "Padang Lawas Utara", "Pakpak Bharat", "Samosir", "Serdang Bedagai", "Simalungun", "Tapanuli Selatan", "Tapanuli Tengah", "Tapanuli Utara", "Toba"],
        "Lainnya": ["Luar Pulau Jawa / Lainnya"]
    };

    document.addEventListener("DOMContentLoaded", function() {
        updateQuotaInfo();
        generateMemberInputs();
        initAddressDropdowns();
    });

    function initAddressDropdowns() {
        const provSelect = document.getElementById('provinsi');
        provSelect.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
        
        const sortedProvinces = Object.keys(regions).sort(function(a, b) {
            if (a === "Lainnya") return 1;
            if (b === "Lainnya") return -1;
            return a.localeCompare(b, 'id');
        });

        sortedProvinces.forEach(function(prov) {
            const opt = document.createElement('option');
            opt.value = prov;
            opt.textContent = prov;
            provSelect.appendChild(opt);
        });
    }

    function updateKabupatenOptions() {
        const provSelect = document.getElementById('provinsi');
        const kabSelect = document.getElementById('kabupaten');
        const selectedProv = provSelect.value;

        kabSelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';

        if (selectedProv && regions[selectedProv]) {
            const sortedCities = [...regions[selectedProv]].sort(function(a, b) {
                return a.localeCompare(b, 'id');
            });

            sortedCities.forEach(function(kab) {
                const opt = document.createElement('option');
                opt.value = kab;
                opt.textContent = kab;
                kabSelect.appendChild(opt);
            });
        }
    }

    function updatePrice() {
        const BASE_PRICE = 30000;
        const countInput = document.getElementById('jumlah_pendaki');
        let count = parseInt(countInput.value) || 0;

        const select = document.getElementById('jadwal_id');
        const selectedOption = select.options[select.selectedIndex];
        const tanggalNaikStr = (selectedOption && selectedOption.value) ? selectedOption.getAttribute('data-tanggal') : '';
        const tanggalTurunStr = document.getElementById('tanggal_turun').value;

        // Hitung jumlah malam: tektok (0 malam) & camp 1 malam = 1x, camp 2 malam = 2x, dst.
        let pengali = 1;
        let jumlahMalam = 0;
        if (tanggalNaikStr && tanggalTurunStr) {
            const dNaik = new Date(tanggalNaikStr);
            const dTurun = new Date(tanggalTurunStr);
            dNaik.setHours(0,0,0,0);
            dTurun.setHours(0,0,0,0);
            const diffTime = dTurun - dNaik;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            jumlahMalam = diffDays;
            // 0 malam (tektok) atau 1 malam (camp) = 1x, 2 malam = 2x, 3 malam = 3x, dst.
            pengali = Math.max(1, diffDays);
        }

        const pricePerPerson = BASE_PRICE * pengali;

        const priceDisplay = document.getElementById('price-per-person-display');
        if (priceDisplay) {
            if (jumlahMalam === 0) {
                priceDisplay.textContent = 'Rp' + pricePerPerson.toLocaleString('id-ID') + ' / orang (Tektok / PP)';
            } else if (jumlahMalam === 1) {
                priceDisplay.textContent = 'Rp' + pricePerPerson.toLocaleString('id-ID') + ' / orang (Camp 1 malam)';
            } else {
                priceDisplay.textContent = 'Rp' + BASE_PRICE.toLocaleString('id-ID') + ' × ' + pengali + ' malam = Rp' + pricePerPerson.toLocaleString('id-ID') + ' / orang';
            }
        }

        const total = count * pricePerPerson;
        const totalDisplay = document.getElementById('total-price-display');
        if (totalDisplay) {
            totalDisplay.textContent = 'Rp' + total.toLocaleString('id-ID');
        }
    }

    function updateQuotaInfo() {
        const select = document.getElementById('jadwal_id');
        const selectedOption = select.options[select.selectedIndex];
        const warning = document.getElementById('quota-warning');
        const remainingEl = document.getElementById('quota-remaining');
        const tanggalTurunInput = document.getElementById('tanggal_turun');

        if (selectedOption && selectedOption.value) {
            const sisa = parseInt(selectedOption.getAttribute('data-sisa'));
            if (sisa <= 50) {
                remainingEl.textContent = sisa;
                warning.classList.remove('hidden');
            } else {
                warning.classList.add('hidden');
            }

            const tanggalNaik = selectedOption.getAttribute('data-tanggal');
            if (tanggalNaik) {
                tanggalTurunInput.min = tanggalNaik;
                if (tanggalTurunInput.value && tanggalTurunInput.value < tanggalNaik) {
                    tanggalTurunInput.value = tanggalNaik;
                }
            }
        } else {
            warning.classList.add('hidden');
        }

        updatePrice();
    }

    function generateMemberInputs() {
        const countInput = document.getElementById('jumlah_pendaki');
        let count = parseInt(countInput.value) || 0;
        const warningEl = document.getElementById('jumlah-pendaki-warning');
        
        // Tampilkan peringatan jika jumlah pendaki diisi 1
        if (count >= 1 && count < 2) {
            warningEl.classList.remove('hidden');
            countInput.classList.add('border-red-500', 'ring-2', 'ring-red-200');
        } else {
            warningEl.classList.add('hidden');
            countInput.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        }

        if (count < 2) {
            // Jangan generate form anggota jika kurang dari 2
            document.getElementById('members-container').innerHTML = '';
            updatePrice();
            return;
        }

        updatePrice();

        const container = document.getElementById('members-container');
        const currentInputsCount = container.children.length;

        const existingValues = [];
        for (let i = 0; i < currentInputsCount; i++) {
            const input = container.children[i].querySelector('input');
            if (input) existingValues.push(input.value);
        }

        container.innerHTML = '';

        for (let i = 0; i < count; i++) {
            const isKetua = i === 0;
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 animate-fade-in';
            
            let value = '';
            if (isKetua) {
                value = document.getElementById('nama_ketua').value;
            } else if (existingValues[i]) {
                value = existingValues[i];
            }

            const numBadge = document.createElement('span');
            numBadge.className = 'w-8 h-8 rounded-lg bg-gradient-to-br from-forest-100 to-emerald-50 flex items-center justify-center text-xs font-bold text-forest-700 flex-shrink-0 border border-forest-200';
            numBadge.textContent = i + 1;

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'nama_anggota[]';
            input.className = 'w-full px-4 py-2.5 border border-mountain-200 rounded-xl text-sm focus:ring-2 focus:ring-forest-500 focus:border-transparent focus:bg-white bg-white/80 transition-all duration-200';
            input.placeholder = isKetua ? 'Nama Ketua (otomatis)' : `Nama Anggota ke-${i + 1}`;
            input.required = true;
            input.value = value;
            
            if (isKetua) {
                input.id = 'member-ketua-input';
                input.readOnly = true;
                input.className += ' bg-mountain-100 text-mountain-500 cursor-not-allowed';
            }

            div.appendChild(numBadge);
            div.appendChild(input);
            container.appendChild(div);
        }

        document.getElementById('nama_ketua').addEventListener('input', function() {
            const memberKetua = document.getElementById('member-ketua-input');
            if (memberKetua) {
                memberKetua.value = this.value;
            }
        });
    }
    // ══ Client-Side Form Validation ══
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        // Clear previous validation errors
        document.querySelectorAll('.js-validation-error').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        });

        const requiredFields = this.querySelectorAll('[required]');
        let hasError = false;
        let firstErrorField = null;

        requiredFields.forEach(function(field) {
            if (field.name === 'nama_anggota[]' && field.readOnly) return; // Skip ketua readonly

            let isEmpty = false;
            if (field.tagName === 'SELECT') {
                isEmpty = !field.value || field.value === '';
            } else if (field.type === 'number') {
                isEmpty = !field.value || parseInt(field.value) < (parseInt(field.min) || 1);
            } else {
                isEmpty = !field.value.trim();
            }

            if (isEmpty) {
                hasError = true;
                field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                
                // Add error message below field
                const errorMsg = document.createElement('p');
                errorMsg.className = 'js-validation-error mt-1 text-xs text-red-500 font-semibold';
                errorMsg.textContent = '⚠️ Kolom ini wajib diisi';
                field.parentNode.appendChild(errorMsg);

                if (!firstErrorField) firstErrorField = field;
            }
        });

        // Validasi khusus jumlah pendaki minimal 2
        const jumlahPendakiField = document.getElementById('jumlah_pendaki');
        const jumlahPendakiVal = parseInt(jumlahPendakiField.value) || 0;
        if (jumlahPendakiVal < 2) {
            hasError = true;
            jumlahPendakiField.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            // Hapus pesan error generic sebelumnya di field ini jika ada
            const existingErr = jumlahPendakiField.parentNode.querySelector('.js-validation-error');
            if (existingErr) existingErr.remove();
            // Tampilkan pesan error khusus
            const errorMsg = document.createElement('p');
            errorMsg.className = 'js-validation-error mt-1 text-xs text-red-500 font-semibold';
            errorMsg.textContent = '⚠️ Minimal 2 orang dalam satu booking!';
            jumlahPendakiField.parentNode.appendChild(errorMsg);
            if (!firstErrorField) firstErrorField = jumlahPendakiField;
        }

        if (hasError) {
            e.preventDefault();
            if (firstErrorField) {
                firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstErrorField.focus();
            }
        }
    });

    // Remove red border when user starts filling in
    document.querySelectorAll('#bookingForm [required]').forEach(function(field) {
        const events = ['input', 'change'];
        events.forEach(function(evt) {
            field.addEventListener(evt, function() {
                this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                const err = this.parentNode.querySelector('.js-validation-error');
                if (err) err.remove();
            });
        });
    });
</script>
@endpush
@endsection
