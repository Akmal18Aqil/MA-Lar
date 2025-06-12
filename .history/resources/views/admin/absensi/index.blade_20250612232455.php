<x-app-layout>
@php
    // Pastikan $liburKegiatan selalu terdefinisi di seluruh view
    $liburKegiatan = $liburKegiatan ?? [];
@endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absensi Harian, Bulanan, Tahunan') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="container-fluid px-0" style="max-width:100vw;">
            <div class="bg-white rounded shadow-sm p-0" style="border:1px solid #ececec;">
                <div class="d-flex flex-wrap flex-column flex-md-row justify-content-between align-items-center px-3 px-md-4 pt-4 pb-2 gap-2">
                    <h4 class="mb-2 mb-md-0 font-weight-bold" style="color:#6c63ff">Absensi</h4>
                    <a href="{{ route('admin.absensi.create') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Absensi</a>
                </div>
                <div class="px-3 px-md-4 pb-2">
                    <form method="GET" class="form-inline flex-wrap gap-2 mb-2 d-flex align-items-end">
                        <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="form-control mr-2 mb-2 flex-grow-1" />
                        <select name="filter" class="form-control mr-2 mb-2 flex-grow-1">
                            <option value="harian" {{ ($filter ?? '') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="bulanan" {{ ($filter ?? '') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahunan" {{ ($filter ?? '') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                        <input type="number" name="bulan" min="1" max="12" value="{{ $bulan ?? '' }}" class="form-control mr-2 mb-2 flex-grow-1" placeholder="Bulan" />
                        <input type="number" name="tahun" min="2020" value="{{ $tahun ?? '' }}" class="form-control mr-2 mb-2 flex-grow-1" placeholder="Tahun" />
                        <div class="form-group mb-2 mr-2 flex-grow-1">
                            <label for="filter_semester" class="mb-0 d-block">Semester</label>
                            <input type="text" name="semester" id="filter_semester" class="form-control form-control-sm w-100" value="{{ request('semester') }}" placeholder="Semester">
                        </div>
                        <div class="form-group mb-2 mr-2 flex-grow-1">
                            <label for="filter_status_lulus" class="mb-0 d-block">Status Lulus</label>
                            <select name="status_lulus" id="filter_status_lulus" class="form-control form-control-sm w-100">
                                <option value="">Semua</option>
                                <option value="belum" {{ request('status_lulus') == 'belum' ? 'selected' : '' }}>Belum Lulus</option>
                                <option value="lulus" {{ request('status_lulus') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            </select>
                        </div>
                        @if(request()->has('filter') || request()->has('export_fields'))
                        <div class="form-group mb-2 mr-2 flex-grow-1">
                            <label for="export_fields" class="mb-0 d-block">Kolom Export</label>
                            <div class="input-group">
                                <select name="export_fields[]" id="export_fields" class="form-control form-control-sm" multiple style="min-height:110px">
                                    <option value="hadir" {{ in_array('hadir', (array)request('export_fields', [])) ? 'selected' : '' }}>Hadir</option>
                                    <option value="izin" {{ in_array('izin', (array)request('export_fields', [])) ? 'selected' : '' }}>Izin</option>
                                    <option value="sakit" {{ in_array('sakit', (array)request('export_fields', [])) ? 'selected' : '' }}>Sakit</option>
                                    <option value="alfa" {{ in_array('alfa', (array)request('export_fields', [])) ? 'selected' : '' }}>Alfa</option>
                                    <option value="terlambat" {{ in_array('terlambat', (array)request('export_fields', [])) ? 'selected' : '' }}>Terlambat</option>
                                </select>
                            </div>
                            <small class="text-muted d-block mt-1">Tekan <b>Ctrl</b> (atau <b>Cmd</b>) untuk memilih lebih dari satu kolom</small>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary mb-2 mr-2 flex-shrink-0"><i class="fa fa-filter"></i> Filter</button>
                        @if($filter === 'bulanan' || $filter === 'tahunan')
                        <a href="{{ route('admin.absensi.export', request()->all()) }}" class="btn btn-success mb-2 ml-2 flex-shrink-0">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        @endif
                        <div class="d-flex flex-wrap align-items-center mb-2 w-100 gap-2">
                            <select name="kegiatan_id" class="form-control mr-2 mb-2" style="min-width:180px">
                                <option value="">Pilih Kegiatan</option>
                                @php
                                    $liburKegiatan = $liburKegiatan ?? [];
                                @endphp
                                @foreach($kegiatan as $k)
                                    <option value="{{ $k->id }}" @if(is_array($liburKegiatan) && in_array($k->id, $liburKegiatan)) disabled @endif>
                                        {{ $k->nama_kegiatan }} ({{ $k->jenis }})
                                        @if(is_array($liburKegiatan) && in_array($k->id, $liburKegiatan)) - Libur @endif
                                    </option>
                                @endforeach
                            </select>
                            <a href="#" onclick="tandaiKegiatanLibur(event)" class="btn btn-danger mb-2 flex-shrink-0"><i class="fas fa-calendar-times"></i> Tandai Kegiatan Libur</a>
                            @if(is_array($liburKegiatan) && count($liburKegiatan) > 0)
                                <div class="ml-2 mb-2">
                                    @foreach($kegiatan as $k)
                                        @if(in_array($k->id, $liburKegiatan))
                                            <button type="button" class="btn btn-outline-secondary btn-sm mb-1 hapus-libur-btn" data-kegiatan="{{ $k->id }}">
                                                <i class="fas fa-trash"></i> Hapus Libur {{ $k->nama_kegiatan }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="table-responsive px-2 px-md-4 pb-4">
                    @if($filter === 'bulanan' || $filter === 'tahunan')
                        @php
                            $exportFields = request('export_fields', ['hadir','izin','sakit','alfa','terlambat']);
                            // Filter kegiatan agar unik berdasarkan kombinasi nama_kegiatan dan jenis
                            $uniqueKegiatan = collect($kegiatan);
                            if(request('filter_kegiatan')) {
                                $uniqueKegiatan = $uniqueKegiatan->whereIn('id', (array)request('filter_kegiatan'));
                            }
                            $uniqueKegiatan = $uniqueKegiatan->unique(function($item) {
                                return $item->nama_kegiatan . '-' . $item->jenis;
                            });
                        @endphp
                        <table class="table table-bordered table-striped table-hover w-100 text-center align-middle" style="min-width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:40px" rowspan="2">NIM</th>
                                    <th rowspan="2">Nama Mahasantri</th>
                                    @foreach($uniqueKegiatan as $k)
                                        <th colspan="{{ count($exportFields) }}" class="text-center align-middle">
                                            {{ $k->nama_kegiatan }}<br><span class="text-xs">({{ $k->jenis }})</span>
                                            @if(is_array($liburKegiatan) && in_array($k->id, $liburKegiatan))
                                                <span class="badge badge-danger ml-1">Libur</span>
                                            @endif
                                        </th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($uniqueKegiatan as $k)
                                        @foreach($exportFields as $field)
                                            <th class="text-center">{{ strtoupper(substr($field,0,1)) }}</th>
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mahasantris as $m)
                                <tr>
                                    <td>{{ $m->nim }}</td>
                                    <td class="text-left">{{ $m->nama_lengkap }}</td>
                                    @foreach($uniqueKegiatan as $k)
                                        @php
                                            $isLibur = is_array($liburKegiatan) && in_array($k->id, $liburKegiatan);
                                            $rekap = ($filter === 'bulanan' ? ($rekapBulanan[$m->id][$k->id] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0,'terlambat'=>0,'sholat_subuh'=>0,'sholat_dzuhur'=>0,'sholat_ashar'=>0,'sholat_maghrib'=>0,'sholat_isya'=>0,'terlambat_sholat'=>0]) : ($rekapTahunan[$m->id][$k->id] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0,'terlambat'=>0,'sholat_subuh'=>0,'sholat_dzuhur'=>0,'sholat_ashar'=>0,'sholat_maghrib'=>0,'sholat_isya'=>0,'terlambat_sholat'=>0]));
                                        @endphp
                                        @if($isLibur)
                                            <td colspan="{{ count($exportFields) }}" class="text-center align-middle"><span class="badge badge-danger">Libur</span></td>
                                        @else
                                            @foreach($exportFields as $field)
                                                @if($k->jenis == 'sholat_jamaah' && $field == 'terlambat')
                                                    <td>{{ $rekap['terlambat_sholat'] ?? 0 }}</td>
                                                @else
                                                    <td>{{ $rekap[$field] ?? 0 }}</td>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table table-bordered table-striped table-hover w-100 mt-0" style="min-width:100%; margin-top: -1px;">
                            <tr>
                                <td colspan="2" style="font-weight:bold; text-align:right;">Jumlah Libur</td>
                                @foreach($uniqueKegiatan as $k)
                                    @php
                                        $liburCount = 0;
                                        if(isset($liburKegiatanCount) && isset($liburKegiatanCount[$k->id])) {
                                            $liburCount = $liburKegiatanCount[$k->id];
                                        }
                                    @endphp
                                    <td colspan="{{ count($exportFields) }}" style="text-align:center; color:red; font-weight:bold;">{{ $liburCount > 0 ? $liburCount . 'x Libur' : '' }}</td>
                                @endforeach
                            </tr>
                        </table>
                    @else
                        @php
                            // Filter kegiatan agar unik berdasarkan kombinasi nama_kegiatan dan jenis
                            $uniqueKegiatan = collect($kegiatan)->unique(function($item) {
                                return $item->nama_kegiatan . '-' . $item->jenis;
                            });
                        @endphp
                        <table class="table table-striped table-hover w-100" style="min-width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:40px">NIM</th>
                                    <th>Nama Mahasantri</th>
                                    @foreach($uniqueKegiatan as $k)
                                        <th>{{ $k->nama_kegiatan }}<br><span class="text-xs">({{ $k->jenis }})</span></th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mahasantris as $m)
                                <tr>
                                    <td>{{ $m->nim }}</td>
                                    <td>{{ $m->nama_lengkap }}</td>
                                    @foreach($uniqueKegiatan as $k)
                                        @php
                                            $isLibur = is_array($liburKegiatan) && collect($kegiatan)->first(function($kg) use ($k, $liburKegiatan) {
                                                return $kg->nama_kegiatan == $k->nama_kegiatan && $kg->jenis == $k->jenis && is_array($liburKegiatan) && in_array($kg->id, $liburKegiatan);
                                            });
                                            $absen = $absensi->first(function($a) use ($m, $k, $kegiatan) {
                                                // Cari id kegiatan yang cocok nama dan jenisnya
                                                $keg = collect($kegiatan)->first(function($kg) use ($k) {
                                                    return $kg->nama_kegiatan == $k->nama_kegiatan && $kg->jenis == $k->jenis;
                                                });
                                                return $a->mahasantri_id == $m->id && $keg && $a->kegiatan_id == $keg->id;
                                            });
                                        @endphp
                                        <td>
                                            @if($isLibur)
                                                <span class="badge badge-danger">Libur</span>
                                            @elseif($absen)
                                                <div class="d-flex align-items-center" style="gap:2px;">
                                                    <span class="badge badge-{{ $absen->status == 'hadir' ? 'success' : ($absen->status == 'alfa' ? 'danger' : 'warning') }}">{{ ucfirst($absen->status) }}</span>
                                                    @if($k->jenis == 'pengajian' && !empty($absen->is_late))
                                                        <span class="badge badge-warning ml-1">Terlambat</span>
                                                    @endif
                                                    @if($k->jenis == 'sholat_jamaah')
                                                        @if($absen->status == 'hadir')
                                                            <span class="badge badge-success ml-1">Jama'ah</span>
                                                        @endif
                                                        @if(!empty($absen->is_late))
                                                            <span class="badge badge-warning ml-1">Terlambat Sholat</span>
                                                        @endif
                                                    @endif
                                                    <form action="{{ route('admin.absensi.destroy', $absen->id) }}" method="POST" class="d-inline m-0 p-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="color:#dc3545; margin-left:2px;" title="Hapus" onclick="return confirm('Yakin hapus absensi?')">
                                                            <i class="fa fa-trash fa-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
@media (max-width: 767.98px) {
    .form-inline.d-flex {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    .form-inline .form-group,
    .form-inline .form-control,
    .form-inline .btn,
    .form-inline select {
        width: 100% !important;
        margin-right: 0 !important;
        margin-bottom: 8px !important;
    }
    .table-responsive {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
    .d-flex.flex-wrap.align-items-center.mb-2.w-100.gap-2 {
        flex-direction: column !important;
        align-items: stretch !important;
    }
}
</style>
<script>
function tandaiKegiatanLibur(e) {
    e.preventDefault();
    var tanggal = document.querySelector('input[name="tanggal"]').value;
    var kegiatanId = document.querySelector('select[name="kegiatan_id"]').value;
    if (!tanggal || !kegiatanId) {
        alert('Pilih tanggal dan kegiatan terlebih dahulu!');
        return;
    }
    window.location.href = `?libur=1&tanggal=${tanggal}&kegiatan_id=${kegiatanId}`;
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.hapus-libur-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var tanggal = document.querySelector('input[name="tanggal"]').value;
            var kegiatanId = this.getAttribute('data-kegiatan');
            if (!tanggal || !kegiatanId) {
                alert('Pilih tanggal dan kegiatan yang ingin dihapus liburnya!');
                return;
            }
            if(confirm('Yakin ingin menghapus status libur pada kegiatan ini?')){
                window.location.href = `/admin/absensi/hapus-libur?tanggal=${tanggal}&kegiatan_id=${kegiatanId}`;
            }
        });
    });
});
</script>