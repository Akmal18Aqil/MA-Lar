<?php

namespace App\Http\Controllers;

use App\Models\Mahasantri;
use App\Models\Kegiatan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exports\RekapAbsensiExport;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $bulan = str_pad($request->input('bulan', now()->format('m')), 2, '0', STR_PAD_LEFT);
        $tahun = $request->input('tahun', now()->format('Y'));
        $filter = $request->input('filter', 'harian');

        $mahasantris = Mahasantri::with('user')->get();
        $kegiatan = Kegiatan::all();
        $absensi = Absensi::query();
        if ($filter === 'harian') {
            $absensi = $absensi->whereDate('tanggal', $tanggal);
        } elseif ($filter === 'bulanan') {
            $absensi = $absensi->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        } elseif ($filter === 'tahunan') {
            $absensi = $absensi->whereYear('tanggal', $tahun);
        }
        $absensi = $absensi->get();

        // Untuk filter bulanan: hitung jumlah absensi per mahasantri per kegiatan per status
        $rekapBulanan = [];
        if ($filter === 'bulanan') {
            foreach ($mahasantris as $m) {
                foreach ($kegiatan as $k) {
                    $rekapBulanan[$m->id][$k->id] = [
                        'hadir' => 0,
                        'izin' => 0,
                        'sakit' => 0,
                        'alfa' => 0,
                    ];
                }
            }
            foreach ($absensi as $a) {
                if (isset($rekapBulanan[$a->mahasantri_id][$a->kegiatan_id][$a->status])) {
                    $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id][$a->status]++;
                }
            }
        }
        // Untuk filter tahunan: rekap sama seperti bulanan, tapi untuk setahun
        $rekapTahunan = [];
        if ($filter === 'tahunan') {
            foreach ($mahasantris as $m) {
                foreach ($kegiatan as $k) {
                    $rekapTahunan[$m->id][$k->id] = [
                        'hadir' => 0,
                        'izin' => 0,
                        'sakit' => 0,
                        'alfa' => 0,
                    ];
                }
            }
            foreach ($absensi as $a) {
                if (isset($rekapTahunan[$a->mahasantri_id][$a->kegiatan_id][$a->status])) {
                    $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id][$a->status]++;
                }
            }
        }

        return view('admin.absensi.index', compact('mahasantris', 'kegiatan', 'absensi', 'tanggal', 'bulan', 'tahun', 'filter', 'rekapBulanan', 'rekapTahunan'));
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

    public function export(Request $request)
    {
        $filter = $request->input('filter', 'bulanan');
        $bulan = str_pad($request->input('bulan', now()->format('m')), 2, '0', STR_PAD_LEFT);
        $tahun = $request->input('tahun', now()->format('Y'));

        $mahasantris = Mahasantri::with('user')->get();
        $kegiatan = Kegiatan::all();
        $absensi = Absensi::query();
        if ($filter === 'bulanan') {
            $absensi = $absensi->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        } elseif ($filter === 'tahunan') {
            $absensi = $absensi->whereYear('tanggal', $tahun);
        } else {
            abort(404);
        }
        $absensi = $absensi->get();

        $rekap = [];
        foreach ($mahasantris as $m) {
            foreach ($kegiatan as $k) {
                $rekap[$m->id][$k->id] = [
                    'hadir' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alfa' => 0,
                ];
            }
        }
        foreach ($absensi as $a) {
            if (isset($rekap[$a->mahasantri_id][$a->kegiatan_id][$a->status])) {
                $rekap[$a->mahasantri_id][$a->kegiatan_id][$a->status]++;
            }
        }

        $fileName = 'Rekap_Absensi_' . $filter . '_' . ($filter === 'bulanan' ? $bulan . '_' : '') . $tahun . '.xlsx';
        return Excel::download(new RekapAbsensiExport($mahasantris, $kegiatan, $rekap, $filter, $bulan, $tahun), $fileName);
    }
}
