<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Absensi') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-2xl mx-auto bg-white p-4 rounded shadow">
            <form method="POST" action="{{ route('absensi.update', $absensi->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Mahasantri</label>
                    <input type="text" class="form-input" value="{{ $absensi->mahasantri->nim }} - {{ $absensi->mahasantri->nama_lengkap }}" disabled />
                </div>
                <div class="mb-3">
                    <label>Kegiatan</label>
                    <input type="text" class="form-input" value="{{ $absensi->kegiatan->nama_kegiatan }} ({{ $absensi->kegiatan->jenis }})" disabled />
                </div>
                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" class="form-input" value="{{ $absensi->tanggal->format('Y-m-d') }}" disabled />
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="hadir" @selected($absensi->status=='hadir')>Hadir</option>
                        <option value="izin" @selected($absensi->status=='izin')>Izin</option>
                        <option value="sakit" @selected($absensi->status=='sakit')>Sakit</option>
                        <option value="alfa" @selected($absensi->status=='alfa')>Alfa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-input">{{ $absensi->keterangan }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
