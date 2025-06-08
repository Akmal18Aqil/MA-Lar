<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasantri;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalMahasantri = User::where('role', 'mahasantri')->count();
        $totalDosen = User::where('role', 'dosen')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalMahasantri', 'totalDosen'));
    }

    public function absensi()
    {
        return view('admin.absensi');
    }

    public function mahasantri()
    {
        return view('admin.mahasantri');
    }

    public function mahasantriIndex()
    {
        // Ambil data Mahasantri beserta user (email) dan status dummy, gunakan pagination
        $mahasantris = \App\Models\Mahasantri::with('user')->paginate(10);
        foreach ($mahasantris as $m) {
            $m->status = 'active'; // Atur status dummy, ganti sesuai kebutuhan
        }
        return view('admin.mahasantri.index', compact('mahasantris'));
    }
}
