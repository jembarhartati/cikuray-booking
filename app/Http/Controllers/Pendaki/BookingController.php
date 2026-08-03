<?php

namespace App\Http\Controllers\Pendaki;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function syarat()
    {
        return view('pendaki.booking.syarat');
    }

    public function setujuSyarat(Request $request)
    {
        $request->validate([
            'setuju' => 'required|accepted',
        ], [
            'setuju.accepted' => 'Anda harus menyetujui syarat dan ketentuan untuk melanjutkan.',
        ]);

        session(['setuju_syarat' => true]);

        return redirect()->route('pendaki.booking.create');
    }

    public function create(Request $request)
    {
        if (!session('setuju_syarat')) {
            return redirect()->route('pendaki.booking.syarat')
                ->with('warning', 'Anda harus menyetujui syarat dan ketentuan terlebih dahulu.');
        }

        Jadwal::generateUpcomingSchedules();

        $jadwalId = $request->get('jadwal_id');
        $jadwals  = Jadwal::where('status', 'aktif')
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->take(30)
            ->get();

        $selectedJadwal = $jadwalId ? Jadwal::find($jadwalId) : null;

        return view('pendaki.booking.create', compact('jadwals', 'selectedJadwal'));
    }

    public function store(Request $request)
    {
        if (!session('setuju_syarat')) {
            return redirect()->route('pendaki.booking.syarat')
                ->with('warning', 'Anda harus menyetujui syarat dan ketentuan terlebih dahulu.');
        }

        $request->validate([
            'jadwal_id'       => 'required|exists:jadwals,id',
            'nama_ketua'      => 'required|string|max:255',
            'provinsi'        => 'required|string',
            'kabupaten'       => 'required|string',
            'detail_alamat'   => 'required|string',
            'no_telepon'      => 'required|string|max:20',
            'no_darurat'      => 'required|string|max:20',
            'jumlah_pendaki'  => 'required|integer|min:2',
            'tanggal_turun'   => 'required|date',
            'nama_anggota'    => 'required|array|min:2',
            'nama_anggota.*'  => 'required|string|max:255',
        ], [
            'jadwal_id.required'      => 'Pilih tanggal pendakian.',
            'nama_ketua.required'     => 'Nama ketua rombongan wajib diisi.',
            'provinsi.required'       => 'Pilih provinsi asal.',
            'kabupaten.required'      => 'Pilih kota/kabupaten asal.',
            'detail_alamat.required'  => 'Detail alamat wajib diisi.',
            'no_darurat.required'     => 'Nomor HP keluarga / kontak darurat wajib diisi.',
            'jumlah_pendaki.min'      => 'Minimal 2 orang dalam satu booking.',
            'tanggal_turun.required'  => 'Tanggal turun wajib diisi.',
            'tanggal_turun.date'      => 'Format tanggal turun tidak valid.',
            'nama_anggota.*.required' => 'Nama setiap anggota wajib diisi.',
        ]);

        $jadwal = Jadwal::findOrFail($request->jadwal_id);
        $tanggalNaik = $jadwal->tanggal->toDateString();

        $request->validate([
            'tanggal_turun' => 'date|after_or_equal:' . $tanggalNaik,
        ], [
            'tanggal_turun.after_or_equal' => 'Tanggal turun harus sama dengan atau setelah tanggal naik (' . $jadwal->tanggal->format('d/m/Y') . ').',
        ]);

        // Validasi kuota
        if ($jadwal->sisaKuota() < $request->jumlah_pendaki) {
            return back()->withErrors(['jumlah_pendaki' => 'Sisa kuota tidak mencukupi. Sisa: ' . $jadwal->sisaKuota() . ' orang.'])->withInput();
        }

        if ($jadwal->status !== 'aktif') {
            return back()->withErrors(['jadwal_id' => 'Jadwal ini tidak aktif.'])->withInput();
        }

        $tanggalNaik = \Carbon\Carbon::parse($jadwal->tanggal)->startOfDay();
        $tanggalTurun = \Carbon\Carbon::parse($request->tanggal_turun)->startOfDay();
        $selisihHari = $tanggalNaik->diffInDays($tanggalTurun);

        $hargaPerOrang = 30000;
        if ($selisihHari >= 2) {
            $hargaPerOrang = 60000;
        }

        $totalHarga = $request->jumlah_pendaki * $hargaPerOrang;
        $alamatCombined = $request->provinsi . ', ' . $request->kabupaten . ' - ' . $request->detail_alamat;

        $booking = Booking::create([
            'kode_booking'   => Booking::generateKode(),
            'user_id'        => auth()->id(),
            'jadwal_id'      => $request->jadwal_id,
            'tanggal_turun'  => $request->tanggal_turun,
            'nama_ketua'     => $request->nama_ketua,
            'alamat'         => $alamatCombined,
            'no_telepon'     => $request->no_telepon,
            'no_darurat'     => $request->no_darurat,
            'jumlah_pendaki' => $request->jumlah_pendaki,
            'harga_per_orang'=> $hargaPerOrang,
            'total_harga'    => $totalHarga,
            'status_booking' => 'menunggu',
        ]);

        foreach ($request->nama_anggota as $i => $nama) {
            $booking->anggota()->create([
                'nama'   => $nama,
                'urutan' => $i + 1,
            ]);
        }

        $pembayaran = Pembayaran::create([
            'booking_id'  => $booking->id,
            'order_id'    => $booking->kode_booking,
            'status'      => 'menunggu',
            'jumlah_bayar'=> $totalHarga,
        ]);

        session()->forget('setuju_syarat');

        return redirect()->route('pendaki.pembayaran.show', $pembayaran->id)
            ->with('success', 'Booking berhasil dibuat! Silakan lanjutkan pembayaran.');
    }

    public function show(Booking $booking, MidtransService $midtrans)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        $booking->load(['jadwal', 'anggota', 'pembayaran', 'eticket']);

        if ($booking->pembayaran && $booking->pembayaran->status === 'menunggu') {
            $midtrans->checkStatus($booking->pembayaran);
            $booking->pembayaran->refresh();
        }

        return view('pendaki.booking.show', compact('booking'));
    }
}
