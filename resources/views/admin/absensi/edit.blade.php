<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Absensi') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Edit Absensi</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.absensi.update', $absensi->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label>Mahasantri</label>
                                <input type="text" class="form-control" value="{{ $absensi->mahasantri->nim }} - {{ $absensi->mahasantri->nama_lengkap }}" disabled />
                            </div>
                            <div class="form-group mb-3">
                                <label>Kegiatan</label>
                                <input type="text" class="form-control" value="{{ $absensi->kegiatan->nama_kegiatan }} ({{ $absensi->kegiatan->jenis }})" disabled />
                            </div>
                            <div class="form-group mb-3">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" value="{{ $absensi->tanggal->format('Y-m-d') }}" disabled />
                            </div>
                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="hadir" @selected($absensi->status=='hadir')>Hadir</option>
                                    <option value="izin" @selected($absensi->status=='izin')>Izin</option>
                                    <option value="sakit" @selected($absensi->status=='sakit')>Sakit</option>
                                    <option value="alfa" @selected($absensi->status=='alfa')>Alfa</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Keterangan</label>
                                <textarea name="keterangan" class="form-control">{{ $absensi->keterangan }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
