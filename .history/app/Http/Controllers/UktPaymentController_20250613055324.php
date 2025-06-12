<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UktPayment;
use App\Models\Mahasantri;
use App\Exports\RekapUktExport;
use Maatwebsite\Excel\Facades\Excel;

class UktPaymentController extends Controller
{
    public function index()
    {
        $uktPayments = UktPayment::with('mahasantri')->orderByDesc('tanggal_bayar')->paginate(10);
        return view('admin.ukt.index', compact('uktPayments'));
    }

    public function create()
    {
        $mahasantris = Mahasantri::orderBy('nama_lengkap')->get();
        return view('admin.ukt.create', compact('mahasantris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasantri_id' => 'required|exists:mahasantri,id',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,belum_lunas,tunggakan',
        ]);
        // Jika jumlah 1500000, buat pembayaran lunas untuk seluruh bulan di semester (asumsi 6 bulan)
        if ($validated['jumlah'] == 1500000) {
            $tanggalBayar = $validated['tanggal_bayar'];
            $start = \Carbon\Carbon::parse($tanggalBayar)->startOfMonth();
            for ($i = 0; $i < 6; $i++) {
                $bulanBayar = $start->copy()->addMonths($i);
                \App\Models\UktPayment::create([
                    'mahasantri_id' => $validated['mahasantri_id'],
                    'jumlah' => 350000, // per bulan 350rb, total 2.100.000 jika 6 bulan
                    'tanggal_bayar' => $bulanBayar->format('Y-m-d'),
                    'status' => 'lunas',
                ]);
            }
            return redirect()->route('admin.ukt.index')->with('success', 'Pembayaran UKT semester lunas untuk 6 bulan!');
        }
        \App\Models\UktPayment::create([
            'mahasantri_id' => $validated['mahasantri_id'],
            'jumlah' => $validated['jumlah'],
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'status' => $validated['status'],
        ]);
        return redirect()->route('admin.ukt.index')->with('success', 'Pembayaran UKT berhasil ditambahkan!');
    }

    public function edit(UktPayment $ukt)
    {
        $mahasantris = Mahasantri::orderBy('nama_lengkap')->get();
        return view('admin.ukt.edit', compact('ukt', 'mahasantris'));
    }

    public function update(Request $request, UktPayment $ukt)
    {
        $validated = $request->validate([
            'mahasantri_id' => 'required|exists:mahasantri,id',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'status' => 'required|in:lunas,belum_lunas,tunggakan',
        ]);
        $ukt->update([
            'mahasantri_id' => $validated['mahasantri_id'],
            'jumlah' => $validated['jumlah'],
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'status' => $validated['status'],
        ]);
        return redirect()->route('admin.ukt.index')->with('success', 'Pembayaran UKT berhasil diupdate!');
    }

    public function destroy(UktPayment $ukt)
    {
        $ukt->delete();
        return redirect()->route('admin.ukt.index')->with('success', 'Pembayaran UKT berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $semester = $request->input('semester');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\RekapUktExport($semester, $bulan, $tahun), 'Rekap_UKT.xlsx');
    }
}
