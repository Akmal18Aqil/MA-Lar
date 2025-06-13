<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasantri;
use App\Models\Kegiatan;
use Carbon\Carbon;

class DosenController extends Controller
{
    public function dashboard(Request $request)
    {
        $filter = $request->get('filter', 'harian');
        $today = Carbon::today();
        $query = Kegiatan::query();

        if ($filter === 'bulanan') {
            $query->whereMonth('created_at', $today->month)
                  ->whereYear('created_at', $today->year);
        } elseif ($filter === 'tahunan') {
            $query->whereYear('created_at', $today->year);
        } else { // harian
            $query->whereDate('created_at', $today);
        }

        $jumlahMahasantri = Mahasantri::count();
        $laporanKegiatan = $query->get();

        return view('dosen.dashboard', [
            'jumlahMahasantri' => $jumlahMahasantri,
            'laporanKegiatan' => $laporanKegiatan,
            'filter' => $filter,
        ]);
    }
}
