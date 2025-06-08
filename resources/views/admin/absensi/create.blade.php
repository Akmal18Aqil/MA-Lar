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
                            <form method="POST" action="{{ route('admin.absensi.store') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="kegiatan_id">Kegiatan</label>
                                    <select name="kegiatan_id" id="kegiatan_id" class="form-control" required>
                                        <option value="">Pilih Kegiatan</option>
                                        @foreach($kegiatan as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kegiatan }} ({{ $k->jenis }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required />
                                </div>
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
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Simpan</button>
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
