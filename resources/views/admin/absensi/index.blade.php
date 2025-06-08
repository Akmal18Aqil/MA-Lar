<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absensi Harian, Bulanan, Tahunan') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="container-fluid px-0" style="max-width:100vw;">
            <div class="bg-white rounded shadow-sm p-0" style="border:1px solid #ececec;">
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-2">
                    <h4 class="mb-0 font-weight-bold" style="color:#6c63ff">Absensi</h4>
                    <a href="{{ route('admin.absensi.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Absensi</a>
                </div>
                <div class="px-4 pb-2">
                    <form method="GET" class="form-inline mb-2">
                        <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" class="form-control mr-2 mb-2" />
                        <select name="filter" class="form-control mr-2 mb-2">
                            <option value="harian" {{ ($filter ?? '') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="bulanan" {{ ($filter ?? '') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahunan" {{ ($filter ?? '') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                        <input type="number" name="bulan" min="1" max="12" value="{{ $bulan ?? '' }}" class="form-control mr-2 mb-2" placeholder="Bulan" />
                        <input type="number" name="tahun" min="2020" value="{{ $tahun ?? '' }}" class="form-control mr-2 mb-2" placeholder="Tahun" />
                        <button type="submit" class="btn btn-primary mb-2 mr-2"><i class="fas fa-filter"></i> Filter</button>
                        @if($filter === 'bulanan' || $filter === 'tahunan')
                        <a href="{{ route('admin.absensi.export', array_merge(request()->all(), ['filter'=>$filter,'bulan'=>$bulan,'tahun'=>$tahun])) }}" class="btn btn-success mb-2 ml-2">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        @endif
                        <a href="?libur=1&tanggal={{ $tanggal ?? '' }}" class="btn btn-danger mb-2"><i class="fas fa-calendar-times"></i> Tandai Hari Libur</a>
                    </form>
                </div>
                <div class="table-responsive px-4 pb-4">
                    @if($filter === 'bulanan' || $filter === 'tahunan')
                        <table class="table table-bordered table-striped table-hover w-100" style="min-width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:40px" rowspan="2">NIM</th>
                                    <th rowspan="2">Nama Mahasantri</th>
                                    @foreach($kegiatan as $k)
                                        <th colspan="4" class="text-center">{{ $k->nama_kegiatan }}<br><span class="text-xs">({{ $k->jenis }})</span></th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($kegiatan as $k)
                                        <th class="text-center">H</th>
                                        <th class="text-center">I</th>
                                        <th class="text-center">S</th>
                                        <th class="text-center">A</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mahasantris as $m)
                                <tr>
                                    <td>{{ $m->nim }}</td>
                                    <td>{{ $m->nama_lengkap }}</td>
                                    @foreach($kegiatan as $k)
                                        @php
                                            $rekap = ($filter === 'bulanan' ? ($rekapBulanan[$m->id][$k->id] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0]) : ($rekapTahunan[$m->id][$k->id] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0]));
                                        @endphp
                                        <td class="text-center">{{ $rekap['hadir'] }}</td>
                                        <td class="text-center">{{ $rekap['izin'] }}</td>
                                        <td class="text-center">{{ $rekap['sakit'] }}</td>
                                        <td class="text-center">{{ $rekap['alfa'] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <table class="table table-striped table-hover w-100" style="min-width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:40px">NIM</th>
                                    <th>Nama Mahasantri</th>
                                    @foreach($kegiatan as $k)
                                        <th>{{ $k->nama_kegiatan }}<br><span class="text-xs">({{ $k->jenis }})</span></th>
                                    @endforeach
                                    <th style="width:150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mahasantris as $m)
                                <tr>
                                    <td>{{ $m->nim }}</td>
                                    <td>{{ $m->nama_lengkap }}</td>
                                    @foreach($kegiatan as $k)
                                        @php
                                            $absen = $absensi->first(fn($a) => $a->mahasantri_id == $m->id && $a->kegiatan_id == $k->id);
                                        @endphp
                                        <td>
                                            @if($absen)
                                                <span class="badge badge-{{ $absen->status == 'hadir' ? 'success' : ($absen->status == 'alfa' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($absen->status) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        @foreach($kegiatan as $k)
                                            @php
                                                $absen = $absensi->first(fn($a) => $a->mahasantri_id == $m->id && $a->kegiatan_id == $k->id);
                                            @endphp
                                            @if($absen)
                                                <a href="{{ route('admin.absensi.edit', $absen->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                                                <form action="{{ route('admin.absensi.destroy', $absen->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin hapus absensi?')">Delete</button>
                                                </form>
                                            @endif
                                        @endforeach
                                    </td>
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