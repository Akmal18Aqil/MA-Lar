<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pembayaran UKT') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">Form Edit Pembayaran UKT</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.ukt.update', $ukt->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="mahasantri_id">Mahasantri</label>
                                <select name="mahasantri_id" id="mahasantri_id" class="form-control" required>
                                    <option value="">Pilih Mahasantri</option>
                                    @foreach($mahasantris as $m)
                                        <option value="{{ $m->id }}" {{ $ukt->mahasantri_id == $m->id ? 'selected' : '' }}>{{ $m->nama_lengkap }} ({{ $m->nim }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" required value="{{ $ukt->jumlah }}">
                                <small class="form-text text-muted">Semester: Rp 1.500.000 | Bulanan: Rp 350.000</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggal_bayar">Tanggal Bayar</label>
                                <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control" required value="{{ $ukt->tanggal_bayar->format('Y-m-d') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="periode">Periode</label>
                                <input type="text" name="periode" id="periode" class="form-control" required value="{{ $ukt->periode }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="lunas" {{ $ukt->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="belum_lunas" {{ $ukt->status == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                    <option value="tunggakan" {{ $ukt->status == 'tunggakan' ? 'selected' : '' }}>Tunggakan</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block">Update</button>
                            <a href="{{ route('admin.ukt.index') }}" class="btn btn-secondary btn-block mt-2">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
