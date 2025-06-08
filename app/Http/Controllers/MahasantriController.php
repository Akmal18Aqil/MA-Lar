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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:mahasantri,nim',
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required',
            'address' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable',
            'guardian_name' => 'nullable',
            'guardian_contact' => 'nullable',
        ]);

        // Create user with default password = nim
        $user = \App\Models\User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['nim']),
            'role' => 'mahasantri',
        ]);

        // Create Mahasantri
        \App\Models\Mahasantri::create([
            'user_id' => $user->id,
            'nim' => $validated['nim'],
            'nama_lengkap' => $validated['full_name'],
            'alamat' => $validated['address'] ?? null,
            'tanggal_lahir' => $validated['date_of_birth'] ?? null,
            'no_hp' => $validated['phone_number'] ?? null,
            'nama_wali' => $validated['guardian_name'] ?? null,
            'kontak_wali' => $validated['guardian_contact'] ?? null,
        ]);

        return redirect()->route('admin.mahasantri')->with('success', 'Mahasantri berhasil ditambahkan!');
    }
}
