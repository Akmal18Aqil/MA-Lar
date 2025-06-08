<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasantri;
use Illuminate\Support\Facades\DB;

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
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required',
            'guardian_name' => 'required',
            'guardian_contact' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Create user with default password = nim
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['nim']),
                'role' => User::ROLE_MAHASANTRI,
            ]);

            // Create Mahasantri
            Mahasantri::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'nama_lengkap' => $validated['full_name'],
                'alamat' => $validated['address'],
                'tanggal_lahir' => $validated['date_of_birth'],
                'no_hp' => $validated['phone_number'],
                'nama_wali' => $validated['guardian_name'],
                'kontak_wali' => $validated['guardian_contact'],
            ]);

            DB::commit();
            return redirect()->route('admin.mahasantri')->with('success', 'Mahasantri berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage()]);
        }
    }
}
