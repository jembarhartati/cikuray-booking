<?php

namespace Database\Seeders;

use App\Models\KnowledgeBase;
use Illuminate\Database\Seeder;

class KnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kategori'   => 'biaya',
                'pertanyaan' => 'Berapa harga tiket pendakian Gunung Cikuray?',
                'kata_kunci' => ['harga', 'tiket', 'biaya', 'tarif', 'bayar', 'berapa', 'cost', 'murah'],
                'jawaban'    => "Harga tiket pendakian Gunung Cikuray via Cintanagara adalah **Rp30.000 per orang**. Harga sudah termasuk retribusi masuk kawasan pendakian. Pembayaran dilakukan secara digital melalui sistem booking online kami.",
            ],
            [
                'kategori'   => 'kuota',
                'pertanyaan' => 'Berapa kuota pendaki per hari?',
                'kata_kunci' => ['kuota', 'kapasitas', 'batas', 'maksimal', 'limit', 'penuh', 'sisa', 'tersedia'],
                'jawaban'    => "Kuota pendakian Gunung Cikuray via Cintanagara adalah **maksimal 200 orang per hari**. Sisa kuota dapat dilihat secara real-time pada halaman Jadwal & Kuota. Segera booking sebelum kuota habis!",
            ],
            [
                'kategori'   => 'jadwal',
                'pertanyaan' => 'Kapan jadwal pendakian tersedia?',
                'kata_kunci' => ['jadwal', 'tanggal', 'hari', 'kapan', 'buka', 'tutup', 'schedule', 'waktu'],
                'jawaban'    => "Jadwal pendakian dibuka setiap hari. Anda dapat melihat tanggal yang tersedia beserta sisa kuota pada halaman **Jadwal & Kuota**. Pastikan memilih tanggal yang masih aktif dan memiliki sisa kuota yang cukup.",
            ],
            [
                'kategori'   => 'perlengkapan',
                'pertanyaan' => 'Apa saja perlengkapan yang harus dibawa?',
                'kata_kunci' => ['bawa', 'perlengkapan', 'alat', 'persiapan', 'tas', 'jaket', 'tenda', 'sleeping bag', 'sepatu', 'equipment'],
                'jawaban'    => "Perlengkapan wajib yang harus dibawa:\n• 🎒 Carrier/ransel (40-60L)\n• 🧥 Jaket tebal & jas hujan\n• 👟 Sepatu gunung/tracking\n• 🏕️ Tenda & sleeping bag\n• 🍱 Logistik & air minum cukup\n• 💡 Senter + baterai cadangan\n• 🩹 Kotak P3K\n• 🗺️ Peta & kompas\n• 📱 Powerbank\n• Pakaian hangat ganti",
            ],
            [
                'kategori'   => 'aturan',
                'pertanyaan' => 'Apa aturan pendakian Gunung Cikuray?',
                'kata_kunci' => ['aturan', 'larangan', 'dilarang', 'wajib', 'rules', 'peraturan', 'ketentuan', 'syarat'],
                'jawaban'    => "Aturan pendakian Gunung Cikuray via Cintanagara:\n✅ Wajib melakukan booking dan pembayaran online\n✅ Wajib membawa e-ticket yang sudah divalidasi\n✅ Wajib membawa KTP/identitas diri\n✅ Wajib menjaga kebersihan, tidak membuang sampah sembarangan\n❌ Dilarang membawa minuman keras\n❌ Dilarang membuat api unggun di luar area yang ditentukan\n❌ Dilarang merusak tanaman/flora\n❌ Dilarang membawa hewan peliharaan\n❌ Dilarang mendaki saat cuaca ekstrem/larangan resmi",
            ],
            [
                'kategori'   => 'booking',
                'pertanyaan' => 'Bagaimana cara booking tiket pendakian?',
                'kata_kunci' => ['cara', 'daftar', 'booking', 'pesan', 'reservasi', 'proses', 'langkah', 'how', 'beli'],
                'jawaban'    => "Cara booking tiket pendakian Gunung Cikuray:\n1️⃣ Daftar/Login akun pendaki\n2️⃣ Buka menu **Jadwal & Kuota** untuk memilih tanggal\n3️⃣ Klik **Booking Sekarang** pada tanggal yang tersedia\n4️⃣ Isi data ketua rombongan dan daftar anggota (maks. 10 orang)\n5️⃣ Cek total harga (Rp30.000/orang)\n6️⃣ Klik **Buat Booking** dan lanjutkan ke pembayaran\n7️⃣ Selesaikan pembayaran via Midtrans\n8️⃣ Tunggu validasi tiket oleh admin\n9️⃣ E-ticket siap digunakan!",
            ],
            [
                'kategori'   => 'pembayaran',
                'pertanyaan' => 'Bagaimana cara pembayaran tiket?',
                'kata_kunci' => ['pembayaran', 'transfer', 'qris', 'metode', 'bayar', 'payment', 'dana', 'ovo', 'gopay', 'bca', 'mandiri', 'bni', 'bri'],
                'jawaban'    => "Pembayaran tiket pendakian dilakukan secara **digital melalui Midtrans**. Metode pembayaran yang tersedia:\n💳 Kartu Kredit/Debit\n📱 QRIS (GoPay, OVO, Dana, dll)\n🏦 Transfer Bank Virtual Account (BCA, Mandiri, BNI, BRI)\n🏪 Gerai Retail (Alfamart, Indomaret)\n\nSetelah booking dibuat, klik tombol **Bayar Sekarang** dan ikuti instruksi pembayaran. Status pembayaran akan diperbarui otomatis.",
            ],
            [
                'kategori'   => 'umum',
                'pertanyaan' => 'Di mana lokasi basecamp Cintanagara?',
                'kata_kunci' => ['lokasi', 'alamat', 'basecamp', 'cintanagara', 'dimana', 'tempat', 'maps', 'google', 'akses', 'jalan'],
                'jawaban'    => "Basecamp Cintanagara berlokasi di **Desa Cintanagara, Kecamatan Cigedug, Kabupaten Garut, Jawa Barat**. Gunung Cikuray memiliki ketinggian 2.821 mdpl. Jalur via Cintanagara merupakan jalur resmi yang dikelola dengan baik. Akses dapat ditempuh dari Kota Garut sekitar ±1 jam perjalanan.",
            ],
        ];

        foreach ($data as $item) {
            KnowledgeBase::firstOrCreate(
                ['pertanyaan' => $item['pertanyaan']],
                $item
            );
        }
    }
}
