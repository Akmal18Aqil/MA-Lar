<?php

namespace App\Http\Controllers;

use App\Models\Mahasantri;
use App\Models\Kegiatan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $bulan = $request->input('bulan', now()->format('m'));
        $tahun = $request->input('tahun', now()->format('Y'));
        $filter = $request->input('filter', 'harian');

        $mahasantris = Mahasantri::with('user')->get();
        $kegiatan = Kegiatan::all();
        $absensi = Absensi::whereYear('tanggal', $tahun)
            ->when($filter === 'bulanan', fn($q) => $q->whereMonth('tanggal', $bulan))
            ->when($filter === 'harian', fn($q) => $q->whereDate('tanggal', $tanggal))
            ->get();

        return view('admin.absensi.index', compact('mahasantris', 'kegiatan', 'absensi', 'tanggal', 'bulan', 'tahun', 'filter'));
    }

    public function create()
    {
        $mahasantris = Mahasantri::with('user')->get();
        $kegiatan = Kegiatan::all();
        return view('admin.absensi.create', compact('mahasantris', 'kegiatan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mahasantri_id' => 'required|exists:mahasantri,id',
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();
        Absensi::updateOrCreate([
            'mahasantri_id' => $data['mahasantri_id'],
            'kegiatan_id' => $data['kegiatan_id'],
            'tanggal' => $data['tanggal'],
        ], $data);
        return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil disimpan!');
    }

    public function edit(Absensi $absensi)
    {
        $mahasantris = Mahasantri::with('user')->get();
        $kegiatan = Kegiatan::all();
        return view('admin.absensi.edit', compact('absensi', 'mahasantris', 'kegiatan'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $data = $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();
        $absensi->update($data);
        return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil diupdate!');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect()->route('admin.absensi.index')->with('success', 'Absensi berhasil dihapus!');
    }
}
