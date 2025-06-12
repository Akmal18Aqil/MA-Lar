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
        $mahasantris = Mahasantri::with(['uktPayments' => function($q) {
            $q->where('periode', $this->semester);
        }])->get();
        return view('exports.rekap_ukt', [
            'mahasantris' => $mahasantris,
            'semester' => $this->semester
        ]);
    }

    public function title(): string
    {
        return 'Rekap UKT Semester ' . $this->semester;
    }
}
