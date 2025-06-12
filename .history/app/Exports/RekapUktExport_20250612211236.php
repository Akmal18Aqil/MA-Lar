<?php

namespace App\Exports;

use App\Models\UktPayment;
use App\Models\Mahasantri;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class RekapUktExport implements FromView, WithTitle
{
    protected $semester;
    protected $bulan;
    protected $tahun;

    public function __construct($semester = null, $bulan = null, $tahun = null)
    {
        $this->semester = $semester;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $mahasantris = Mahasantri::with(['uktPayments' => function($q) {
            if ($this->semester) {
                $q->where('periode', $this->semester);
            }
            if ($this->bulan) {
                $q->whereMonth('tanggal_bayar', $this->bulan);
            }
            if ($this->tahun) {
                $q->whereYear('tanggal_bayar', $this->tahun);
            }
        }, 'user'])
        ->when($this->semester, function($q) {
            $q->where('semester', $this->semester);
        })
        ->get();
        $laporan = $mahasantris->map(function($m) {
            $ukt = $m->uktPayments->first();
            return [
                'nim' => $m->nim,
                'nama_lengkap' => $m->nama_lengkap,
                'email' => $m->user->email ?? '-',
                'semester' => $m->semester,
                'jumlah' => $ukt ? $ukt->jumlah : 0,
                'tanggal_bayar' => $ukt ? $ukt->tanggal_bayar : '-',
                'status' => $ukt ? $ukt->status : 'belum_bayar',
            ];
        });
        return view('exports.rekap_ukt', [
            'laporan' => $laporan,
            'semester' => $this->semester
        ]);
    }

    public function title(): string
    {
        return 'Rekap UKT Semester ' . $this->semester;
    }
}
