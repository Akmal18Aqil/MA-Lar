<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Absensi') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="container-fluid px-0" style="max-width:100vw;">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-9">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Tambah Absensi (Bulk)</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @php
                                // Cek libur untuk kegiatan dan tanggal yang dipilih
                                $isLibur = false;
                                $selectedKegiatan = old('kegiatan_id') ?? request('kegiatan_id');
                                $selectedTanggal = old('tanggal') ?? request('tanggal') ?? date('Y-m-d');
                                if (isset($liburKegiatan) && $selectedKegiatan && is_array($liburKegiatan) && in_array($selectedKegiatan, $liburKegiatan)) {
                                    $isLibur = true;
                                }
                            @endphp
                            <form method="POST" action="{{ route('admin.absensi.store') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="kegiatan_id">Kegiatan</label>
                                    <select name="kegiatan_id" id="kegiatan_id" class="form-control" required onchange="this.form.submit()" @if($isLibur) disabled @endif>
                                        <option value="">Pilih Kegiatan</option>
                                        @foreach($kegiatan as $k)
                                            <option value="{{ $k->id }}" {{ $selectedKegiatan == $k->id ? 'selected' : '' }}>{{ $k->nama_kegiatan }} ({{ $k->jenis }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $selectedTanggal }}" required onchange="this.form.submit()" @if($isLibur) disabled @endif />
                                </div>
                                @if($isLibur)
                                    <div class="alert alert-danger">
                                        Kegiatan ini sedang <b>Libur</b> pada tanggal {{ $selectedTanggal }}. Tidak dapat menambah absensi.
                                    </div>
                                @else
                                    <div class="form-group mb-3">
                                        <label>Daftar Mahasantri</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkAll"></th>
                                                        <th>NIM</th>
                                                        <th>Nama Lengkap</th>
                                                        <th>Status</th>
                                                        <th>Keterangan</th>
                                                        @if($selectedKegiatan && $kegiatan->where('id', $selectedKegiatan)->first() && in_array($kegiatan->where('id', $selectedKegiatan)->first()->jenis, ['pengajian','sholat_jamaah']))
                                                            <th>Terlambat?</th>
                                                        @endif
                                                        @if($selectedKegiatan && $kegiatan->where('id', $selectedKegiatan)->first() && $kegiatan->where('id', $selectedKegiatan)->first()->jenis == 'sholat_jamaah')
                                                            <th>Tidak Shaf 1?</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($mahasantris as $m)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="mahasantri_ids[]" value="{{ $m->id }}" class="mahasantri-checkbox">
                                                        </td>
                                                        <td>{{ $m->nim }}</td>
                                                        <td>{{ $m->nama_lengkap }}</td>
                                                        <td>
                                                            <select name="status[{{ $m->id }}]" class="form-control form-control-sm">
                                                                <option value="hadir">Hadir</option>
                                                                <option value="izin">Izin</option>
                                                                <option value="sakit">Sakit</option>
                                                                <option value="alfa">Alfa</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="keterangan[{{ $m->id }}]" class="form-control form-control-sm">
                                                        </td>
                                                        @if($selectedKegiatan && $kegiatan->where('id', $selectedKegiatan)->first() && in_array($kegiatan->where('id', $selectedKegiatan)->first()->jenis, ['pengajian','sholat_jamaah']))
                                                            <td>
                                                                <input type="checkbox" name="is_late[{{ $m->id }}]" value="1">
                                                            </td>
                                                        @endif
                                                        @if($selectedKegiatan && $kegiatan->where('id', $selectedKegiatan)->first() && $kegiatan->where('id', $selectedKegiatan)->first()->jenis == 'sholat_jamaah')
                                                            <td>
                                                                <input type="checkbox" name="is_shaf_pertama[{{ $m->id }}]" value="1">
                                                                <small class="text-muted">Centang jika <b>TIDAK</b> shaf pertama</small>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Simpan</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('checkAll').addEventListener('change', function() {
                let checkboxes = document.querySelectorAll('.mahasantri-checkbox');
                for (let cb of checkboxes) {
                    cb.checked = this.checked;
                }
            });
        });
    </script>
</x-app-layout>
