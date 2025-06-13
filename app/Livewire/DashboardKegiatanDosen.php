<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mahasantri;
use App\Models\Absensi;
use Carbon\Carbon;

class DashboardKegiatanDosen extends Component
{
    public $filter = 'harian';
    public $jumlahMahasantri;
    public $laporanAbsensi = [];
    public $tanggal;
    public $bulan;
    public $tahun;
    public $semester;
    public $daftarKegiatan = [];
    public $daftarSemester = [];
    public $filterKegiatan = [];

    public function mount()
    {
        $this->jumlahMahasantri = Mahasantri::count();
        $this->tanggal = now()->toDateString();
        $this->bulan = now()->format('m');
        $this->tahun = now()->format('Y');
        $this->daftarKegiatan = \App\Models\Kegiatan::orderBy('nama_kegiatan')->get();
        $this->daftarSemester = Mahasantri::select('semester')->distinct()->pluck('semester')->filter()->sort()->values()->toArray();
        $this->updateLaporanAbsensi();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filter', 'tanggal', 'bulan', 'tahun', 'semester'])) {
            $this->updateLaporanAbsensi();
        }
    }

    public function applyKegiatanFilter()
    {
        $this->updateLaporanAbsensi();
    }

    public function getListeners()
    {
        return [
            'selectAllKegiatan' => 'selectAllKegiatan',
            'clearAllKegiatan' => 'clearAllKegiatan',
        ];
    }

    public function selectAllKegiatan()
    {
        $ids = collect($this->daftarKegiatan)->pluck('id')->map(fn($id) => (string)$id)->unique()->values()->toArray();
        $this->filterKegiatan = $ids;
    }

    public function clearAllKegiatan()
    {
        $this->filterKegiatan = [];
    }

    public function updateLaporanAbsensi()
    {
        $query = Absensi::with(['mahasantri', 'kegiatan']);
        if ($this->semester) {
            $query->whereHas('mahasantri', function($q) {
                $q->where('semester', $this->semester);
            });
        }
        if (!empty($this->filterKegiatan) && count($this->filterKegiatan) > 0) {
            $query->whereIn('kegiatan_id', $this->filterKegiatan);
        }
        if ($this->filter === 'harian') {
            $query->whereDate('tanggal', $this->tanggal);
        } elseif ($this->filter === 'bulanan') {
            $query->whereMonth('tanggal', $this->bulan)
                  ->whereYear('tanggal', $this->tahun);
        } elseif ($this->filter === 'tahunan') {
            $query->whereYear('tanggal', $this->tahun);
        }
        $this->laporanAbsensi = $query->orderBy('tanggal', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.dashboard-kegiatan-dosen', [
            'jumlahMahasantri' => $this->jumlahMahasantri,
            'laporanAbsensi' => $this->laporanAbsensi,
            'filter' => $this->filter,
            'filterKegiatan' => $this->filterKegiatan,
            'daftarKegiatan' => $this->daftarKegiatan,
            'daftarSemester' => $this->daftarSemester,
        ]);
    }
}
