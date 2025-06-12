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

    public function __construct($semester)
    {
        $this->semester = $semester;
    }

    public function view(): View
    {
        // Ambil semua mahasantri
        $mahasantris = Mahasantri::with(['uktPayments' => function($q) {
            $q->where('periode', $this->semester);
        }, 'user'])->get();
        // Buat array untuk laporan lengkap
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
                'periode' => $ukt ? $ukt->periode : $this->semester,
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
