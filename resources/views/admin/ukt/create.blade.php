<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pembayaran UKT') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Tambah Pembayaran UKT</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.ukt.store') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="mahasantri_id">Mahasantri</label>
                                <select name="mahasantri_id" id="mahasantri_id" class="form-control" required>
                                    <option value="">Pilih Mahasantri</option>
                                    @foreach($mahasantris as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama_lengkap }} ({{ $m->nim }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" required placeholder="Contoh: 1500000 (semester) / 350000 (bulan)">
                                <small class="form-text text-muted">Semester: Rp 1.500.000 | Bulanan: Rp 350.000</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggal_bayar">Tanggal Bayar</label>
                                <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="periode">Periode</label>
                                <input type="text" name="periode" id="periode" class="form-control" required placeholder="Contoh: 2025/2026 Ganjil atau Juni 2025">
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="lunas">Lunas</option>
                                    <option value="belum_lunas">Belum Lunas</option>
                                    <option value="tunggakan">Tunggakan</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                            <a href="{{ route('admin.ukt.index') }}" class="btn btn-secondary btn-block mt-2">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
