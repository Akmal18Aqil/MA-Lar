<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Absensi') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-2xl mx-auto bg-white p-4 rounded shadow">
            <form method="POST" action="{{ route('absensi.store') }}">
                @csrf
                <div class="mb-3">
                    <label>Mahasantri</label>
                    <select name="mahasantri_id" class="form-select" required>
                        <option value="">Pilih Mahasantri</option>
                        @foreach($mahasantris as $m)
                            <option value="{{ $m->id }}">{{ $m->nim }} - {{ $m->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Kegiatan</label>
                    <select name="kegiatan_id" class="form-select" required>
                        <option value="">Pilih Kegiatan</option>
                        @foreach($kegiatan as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kegiatan }} ({{ $k->jenis }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-input" value="{{ date('Y-m-d') }}" required />
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alfa">Alfa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-input"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>
