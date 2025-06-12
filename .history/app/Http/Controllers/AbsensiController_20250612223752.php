<?php

namespace App\Http\Controllers;

use App\Models\Mahasantri;
use App\Models\Kegiatan;
use App\Models\Absensi;
use App\Models\LiburKegiatan;
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

        $mahasantris = Mahasantri::with('user')
            ->when($request->filled('semester'), function($q) use ($request) {
                $q->where('semester', $request->semester);
            })
            ->when($request->filled('status_lulus'), function($q) use ($request) {
                $q->where('status_lulus', $request->status_lulus);
            })
            ->get();
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
                        'terlambat' => 0, // Tambah field terlambat
                        'sholat_subuh' => 0,
                        'sholat_dzuhur' => 0,
                        'sholat_ashar' => 0,
                        'sholat_maghrib' => 0,
                        'sholat_isya' => 0,
                        'terlambat_sholat' => 0,
                    ];
                }
            }
            foreach ($absensi as $a) {
                if (isset($rekapBulanan[$a->mahasantri_id][$a->kegiatan_id][$a->status])) {
                    $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id][$a->status]++;
                }
                $kegiatanObj = $kegiatan->firstWhere('id', $a->kegiatan_id);
                if ($kegiatanObj && $kegiatanObj->jenis_kegiatan == 'sholat_jamaah') {
                    $nama = strtolower($kegiatanObj->nama_kegiatan);
                    if (strpos($nama, 'subuh') !== false) $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id]['sholat_subuh']++;
                    if (strpos($nama, 'dzuhur') !== false) $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id]['sholat_dzuhur']++;
                    if (strpos($nama, 'ashar') !== false) $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id]['sholat_ashar']++;
                    if (strpos($nama, 'maghrib') !== false) $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id]['sholat_maghrib']++;
                    if (strpos($nama, 'isya') !== false) $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id]['sholat_isya']++;
                    if ($a->is_late) $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id]['terlambat_sholat']++;
                }
                if (isset($rekapBulanan[$a->mahasantri_id][$a->kegiatan_id]) && $a->is_late) {
                    $rekapBulanan[$a->mahasantri_id][$a->kegiatan_id]['terlambat']++;
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
                        'terlambat' => 0, // Tambah field terlambat
                        'sholat_subuh' => 0,
                        'sholat_dzuhur' => 0,
                        'sholat_ashar' => 0,
                        'sholat_maghrib' => 0,
                        'sholat_isya' => 0,
                        'terlambat_sholat' => 0,
                    ];
                }
            }
            foreach ($absensi as $a) {
                if (isset($rekapTahunan[$a->mahasantri_id][$a->kegiatan_id][$a->status])) {
                    $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id][$a->status]++;
                }
                $kegiatanObj = $kegiatan->firstWhere('id', $a->kegiatan_id);
                if ($kegiatanObj && $kegiatanObj->jenis_kegiatan == 'sholat_jamaah') {
                    $nama = strtolower($kegiatanObj->nama_kegiatan);
                    if (strpos($nama, 'subuh') !== false) $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id]['sholat_subuh']++;
                    if (strpos($nama, 'dzuhur') !== false) $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id]['sholat_dzuhur']++;
                    if (strpos($nama, 'ashar') !== false) $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id]['sholat_ashar']++;
                    if (strpos($nama, 'maghrib') !== false) $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id]['sholat_maghrib']++;
                    if (strpos($nama, 'isya') !== false) $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id]['sholat_isya']++;
                    if ($a->is_late) $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id]['terlambat_sholat']++;
                }
                if (isset($rekapTahunan[$a->mahasantri_id][$a->kegiatan_id]) && $a->is_late) {
                    $rekapTahunan[$a->mahasantri_id][$a->kegiatan_id]['terlambat']++;
                }
            }
        }

        $liburKegiatan = collect();
        $liburKegiatanCount = [];
        if ($filter === 'harian' && $tanggal) {
            $liburKegiatan = LiburKegiatan::where('tanggal', $tanggal)->pluck('kegiatan_id')->toArray();
        } elseif (($filter === 'bulanan' || $filter === 'tahunan') && $tahun) {
            $query = LiburKegiatan::query();
            if ($filter === 'bulanan') {
                $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            } else {
                $query->whereYear('tanggal', $tahun);
            }
            $liburKegiatan = $query->get();
            foreach ($kegiatan as $k) {
                $liburKegiatanCount[$k->id] = $liburKegiatan->where('kegiatan_id', $k->id)->count();
            }
        }

        $liburKegiatan = collect();
        if ($request->has('libur') && $request->input('libur') == 1 && $request->filled(['tanggal','kegiatan_id'])) {
            $tanggal = $request->input('tanggal');
            $kegiatan_id = $request->input('kegiatan_id');
            LiburKegiatan::firstOrCreate([
                'tanggal' => $tanggal,
                'kegiatan_id' => $kegiatan_id,
            ]);
            return redirect()->route('admin.absensi.index', array_merge($request->except(['libur','kegiatan_id']), ['tanggal'=>$tanggal]))->with('success', 'Kegiatan berhasil ditandai libur!');
        }
        // Untuk menampilkan status libur di view (opsional)
        if ($filter === 'harian' && $tanggal) {
            $liburKegiatan = LiburKegiatan::where('tanggal', $tanggal)->pluck('kegiatan_id')->toArray();
        }

        return view('admin.absensi.index', compact('mahasantris', 'kegiatan', 'absensi', 'tanggal', 'bulan', 'tahun', 'filter', 'rekapBulanan', 'rekapTahunan', 'liburKegiatan', 'liburKegiatanCount'));
    }

    public function create(Request $request)
    {
        $mahasantris = Mahasantri::with('user')->get();
        $kegiatan = Kegiatan::all();
        $tanggal = $request->input('tanggal', now()->toDateString());
        $kegiatan_id = $request->input('kegiatan_id');
        $liburKegiatan = [];
        if ($tanggal) {
            $liburKegiatan = \App\Models\LiburKegiatan::where('tanggal', $tanggal)->pluck('kegiatan_id')->toArray();
        }
        return view('admin.absensi.create', compact('mahasantris', 'kegiatan', 'liburKegiatan', 'tanggal', 'kegiatan_id'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'tanggal' => 'required|date',
            'mahasantri_ids' => 'required|array',
            'mahasantri_ids.*' => 'exists:mahasantri,id',
            'status' => 'required|array',
            'keterangan' => 'nullable|array',
            'is_late' => 'array', // tambahkan validasi is_late
        ]);
        // Cek libur sebelum simpan
        $isLibur = \App\Models\LiburKegiatan::where('tanggal', $data['tanggal'])->where('kegiatan_id', $data['kegiatan_id'])->exists();
        if ($isLibur) {
            return redirect()->back()->withInput()->with('error', 'Kegiatan ini sedang libur pada tanggal tersebut.');
        }
        foreach ($data['mahasantri_ids'] as $mahasantri_id) {
            $absensiData = [
                'status' => $data['status'][$mahasantri_id] ?? 'hadir',
                'keterangan' => $data['keterangan'][$mahasantri_id] ?? null,
                'updated_by' => Auth::id(),
                'is_late' => 0,
            ];
            $kegiatan = Kegiatan::find($data['kegiatan_id']);
            // Admin manual lateness for pengajian
            if ($kegiatan && $kegiatan->jenis == 'pengajian' && isset($data['is_late']) && isset($data['is_late'][$mahasantri_id])) {
                $absensiData['is_late'] = 1;
            }
            Absensi::updateOrCreate([
                'mahasantri_id' => $mahasantri_id,
                'kegiatan_id' => $data['kegiatan_id'],
                'tanggal' => $data['tanggal'],
            ], $absensiData);
        }
        return redirect()->route('admin.absensi.create', ['kegiatan_id' => $data['kegiatan_id'], 'tanggal' => $data['tanggal']])->with('success', 'Absensi berhasil disimpan!');
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
        $exportFields = $request->input('export_fields');
        if (!$exportFields || !is_array($exportFields) || count($exportFields) === 0) {
            $exportFields = ['hadir','izin','sakit','alfa','terlambat'];
        }

        // Terapkan filter semester dan status_lulus
        $mahasantris = Mahasantri::with('user')
            ->when($request->filled('semester'), function($q) use ($request) {
                $q->where('semester', $request->semester);
            })
            ->when($request->filled('status_lulus'), function($q) use ($request) {
                $q->where('status_lulus', $request->status_lulus);
            })
            ->get();
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
                    'terlambat' => 0,
                ];
            }
        }
        foreach ($absensi as $a) {
            if (isset($rekap[$a->mahasantri_id][$a->kegiatan_id][$a->status])) {
                $rekap[$a->mahasantri_id][$a->kegiatan_id][$a->status]++;
            }
            if (isset($rekap[$a->mahasantri_id][$a->kegiatan_id]) && $a->is_late) {
                $rekap[$a->mahasantri_id][$a->kegiatan_id]['terlambat']++;
            }
        }
        $fileName = 'Rekap_Absensi_' . $filter . '_' . ($filter === 'bulanan' ? $bulan . '_' : '') . $tahun . '.xlsx';
        return Excel::download(new RekapAbsensiExport($mahasantris, $kegiatan, $rekap, $filter, $bulan, $tahun, $exportFields), $fileName);
    }

    public function hapusLibur(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $kegiatan_id = $request->input('kegiatan_id');
        if ($tanggal && $kegiatan_id) {
            $deleted = \App\Models\LiburKegiatan::where('tanggal', $tanggal)
                ->where('kegiatan_id', $kegiatan_id)
                ->delete();
            return redirect()->route('admin.absensi.index', array_merge($request->except(['libur','kegiatan_id','hapus_libur']), ['tanggal'=>$tanggal]))->with('success', 'Libur kegiatan berhasil dihapus!');
        }
        return redirect()->back()->with('error', 'Tanggal dan kegiatan harus dipilih!');
    }
}
