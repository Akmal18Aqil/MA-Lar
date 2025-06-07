<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasantriController extends Controller
{
    public function index()
    {
        return view('mahasantri.index');
    }

    public function create()
    {
        return view('mahasantri.create');
    }
}
