<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function absensi()
    {
        return view('admin.absensi');
    }

    public function mahasantri()
    {
        return view('admin.mahasantri');
    }
}
