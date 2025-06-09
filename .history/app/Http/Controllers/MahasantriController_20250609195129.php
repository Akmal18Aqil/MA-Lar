<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasantri;
use Illuminate\Support\Facades\DB;

class MahasantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasantri::with('user');
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('status_lulus')) {
            $query->where('status_lulus', $request->status_lulus);
        }
        $mahasantris = $query->paginate(10);
        foreach ($mahasantris as $m) {
            $m->status = 'active'; // Default status, can be modified later
        }
        $mahasantris->withPath(route('admin.mahasantri.index'));
        return view('admin.mahasantri.index', compact('mahasantris'));
    }

    public function create()
    {
        return view('admin.mahasantri.create');
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
                'semester' => $request->semester,
                'status_lulus' => $request->status_lulus ?? 'belum',
                'tahun_lulus' => $request->tahun_lulus,
            ]);

            DB::commit();
            return redirect()->route('admin.mahasantri.index')
                ->with('success', 'Mahasantri berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage()]);
        }
    }

    public function edit(Mahasantri $mahasantri)
    {
        return view('admin.mahasantri.edit', compact('mahasantri'));
    }

    public function update(Request $request, Mahasantri $mahasantri)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:mahasantri,nim,'.$mahasantri->id,
            'email' => 'required|email|unique:users,email,'.$mahasantri->user_id,
            'full_name' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required',
            'guardian_name' => 'required',
            'guardian_contact' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Update user
            $mahasantri->user->update([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
            ]);

            // Update mahasantri
            $mahasantri->update([
                'nim' => $validated['nim'],
                'nama_lengkap' => $validated['full_name'],
                'alamat' => $validated['address'],
                'tanggal_lahir' => $validated['date_of_birth'],
                'no_hp' => $validated['phone_number'],
                'nama_wali' => $validated['guardian_name'],
                'kontak_wali' => $validated['guardian_contact'],
                'semester' => $request->semester,
                'status_lulus' => $request->status_lulus ?? 'belum',
                'tahun_lulus' => $request->tahun_lulus,
            ]);

            DB::commit();
            return redirect()->route('admin.mahasantri.index')
                ->with('success', 'Data Mahasantri berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data. ' . $e->getMessage()]);
        }
    }

    public function destroy(Mahasantri $mahasantri)
    {
        try {
            DB::beginTransaction();

            // Delete user will cascade delete mahasantri due to foreign key constraint
            $mahasantri->user->delete();

            DB::commit();
            return redirect()->route('admin.mahasantri.index')
                ->with('success', 'Data Mahasantri berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus data. ' . $e->getMessage()]);
        }
    }
}
