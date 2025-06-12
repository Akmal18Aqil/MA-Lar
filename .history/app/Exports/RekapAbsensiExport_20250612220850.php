<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapAbsensiExport implements FromView
{
    protected $mahasantris;
    protected $kegiatan;
    protected $rekap;
    protected $periode;
    protected $filter;
    protected $bulan;
    protected $tahun;
    protected $exportFields;

    public function __construct($mahasantris, $kegiatan, $rekap, $filter, $bulan = null, $tahun = null, $exportFields = null)
    {
        $this->mahasantris = $mahasantris;
        $this->kegiatan = $kegiatan;
        $this->rekap = $rekap;
        $this->filter = $filter;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->exportFields = $exportFields ?? ['hadir','izin','sakit','alfa','terlambat'];
    }

    public function view(): View
    {
        return view('admin.absensi.export', [
            'mahasantris' => $this->mahasantris,
            'kegiatan' => $this->kegiatan,
            'rekap' => $this->rekap,
            'filter' => $this->filter,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'exportFields' => $this->exportFields,
        ]);
    }
}
