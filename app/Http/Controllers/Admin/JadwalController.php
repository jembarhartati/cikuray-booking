<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal', 'asc')
            ->paginate(15);
        foreach ($jadwals as $jadwal) {
            $jadwal->sisa_kuota  = $jadwal->sisaKuota();
            $jadwal->kuota_terisi = $jadwal->kuotaTerisi();
        }
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'        => 'required|date|unique:jadwals,tanggal|after:today',
            'kuota_maksimal' => 'required|integer|min:1|max:200',
            'status'         => 'required|in:aktif,nonaktif',
            'keterangan'     => 'nullable|string',
        ], [
            'tanggal.unique'  => 'Jadwal pada tanggal ini sudah ada.',
            'tanggal.after'   => 'Tanggal harus setelah hari ini.',
        ]);

        Jadwal::create($request->only('tanggal', 'kuota_maksimal', 'status', 'keterangan'));

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'tanggal'        => 'required|date|unique:jadwals,tanggal,' . $jadwal->id,
            'kuota_maksimal' => 'required|integer|min:1|max:200',
            'status'         => 'required|in:aktif,nonaktif',
            'keterangan'     => 'nullable|string',
        ]);

        $jadwal->update($request->only('tanggal', 'kuota_maksimal', 'status', 'keterangan'));

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        if ($jadwal->bookings()->count() > 0) {
            return back()->with('error', 'Jadwal tidak dapat dihapus karena sudah ada booking.');
        }
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function toggleStatus(Jadwal $jadwal)
    {
        $jadwal->update([
            'status' => $jadwal->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);
        return back()->with('success', 'Status jadwal berhasil diubah.');
    }
}
