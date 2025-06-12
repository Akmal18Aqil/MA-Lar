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
            'periode' => 'required|string',
        ]);
        // Jika jumlah 1500000, set status otomatis lunas
        if ($validated['jumlah'] == 1500000) {
            $validated['status'] = 'lunas';
        }
        UktPayment::create([
            'mahasantri_id' => $validated['mahasantri_id'],
            'jumlah' => $validated['jumlah'],
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'status' => $validated['status'],
            'periode' => $validated['periode'],
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
            'periode' => 'required|string',
        ]);
        $ukt->update([
            'mahasantri_id' => $validated['mahasantri_id'],
            'jumlah' => $validated['jumlah'],
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'status' => $validated['status'],
            'periode' => $validated['periode'],
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
