<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mahasantri Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid px-0" style="max-width:100vw;">
            <div class="row mb-4">
                <!-- Card KTM -->
                <div class="col-md-6 mb-4">
                    <div class="card card-profile shadow h-100 position-relative">
                        <!-- Icon Ganti Password -->
                        <a href="#" class="position-absolute" style="top:18px; right:18px; z-index:2;" title="Ganti Password" data-toggle="modal" data-target="#modalGantiPassword">
                            <i class="fa fa-key fa-lg text-primary"></i>
                        </a>
                        <div class="card-body text-center">
                            <div class="mb-3 d-flex justify-content-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->mahasantri->nama_lengkap ?? Auth::user()->name) }}&background=6c63ff&color=fff&size=256" alt="Foto KTM" class="rounded-circle border border-4 border-primary" style="width:110px;height:110px;object-fit:cover;">
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ Auth::user()->mahasantri->nama_lengkap ?? '-' }}</h4>
                            <div class="mb-2 text-muted">NIM: <b>{{ Auth::user()->mahasantri->nim ?? '-' }}</b></div>
                            <div class="row justify-content-center mb-2">
                                <div class="col-6 text-left"><small>Semester</small></div>
                                <div class="col-6 text-right"><b>{{ Auth::user()->mahasantri->semester ?? '-' }}</b></div>
                                <div class="col-6 text-left"><small>Status</small></div>
                                <div class="col-6 text-right"><b>{{ Auth::user()->mahasantri->status_lulus == 'lulus' ? 'Lulus' : 'Belum Lulus' }}</b></div>
                                <div class="col-6 text-left"><small>Tahun Lulus</small></div>
                                <div class="col-6 text-right"><b>{{ Auth::user()->mahasantri->tahun_lulus ?? '-' }}</b></div>
                                <div class="col-6 text-left"><small>No. HP</small></div>
                                <div class="col-6 text-right"><b>{{ Auth::user()->mahasantri->no_hp ?? '-' }}</b></div>
                                <div class="col-6 text-left"><small>Alamat</small></div>
                                <div class="col-6 text-right"><b>{{ Auth::user()->mahasantri->alamat ?? '-' }}</b></div>
                                <div class="col-6 text-left"><small>Tgl Lahir</small></div>
                                <div class="col-6 text-right"><b>{{ Auth::user()->mahasantri->tanggal_lahir ? Auth::user()->mahasantri->tanggal_lahir->format('d-m-Y') : '-' }}</b></div>
                                <div class="col-6 text-left"><small>Nama Wali</small></div>
                                <div class="col-6 text-right"><b>{{ Auth::user()->mahasantri->nama_wali ?? '-' }}</b></div>
                                <div class="col-6 text-left"><small>Kontak Wali</small></div>
                                <div class="col-6 text-right"><b>{{ Auth::user()->mahasantri->kontak_wali ?? '-' }}</b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Data Terkait Mahasantri -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white font-weight-bold d-flex justify-content-between align-items-center">
                    <span>Data Absensi</span>
                    <form method="GET" class="form-inline d-flex align-items-center" style="gap:8px;">
                        <select name="filter" id="filter-select" class="form-control form-control-sm">
                            <option value="harian" {{ request('filter', 'harian') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                        <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ request('tanggal', now()->format('Y-m-d')) }}" id="input-tanggal">
                        <div id="bulan-tahun-group" style="display:{{ request('filter')=='bulanan'?'inline-flex':'none' }};gap:8px;align-items:center;">
                            <label for="input-bulan" class="mb-0">Bulan</label>
                            <input type="number" name="bulan" min="1" max="12" class="form-control form-control-sm" placeholder="Bulan" value="{{ request('bulan', now()->format('m')) }}" id="input-bulan" style="width:90px;">
                            <label for="input-tahun" class="mb-0">Tahun</label>
                            <input type="number" name="tahun" min="2020" class="form-control form-control-sm" placeholder="Tahun" value="{{ request('tahun', now()->format('Y')) }}" id="input-tahun" style="width:100px;">
                        </div>
                        <button type="submit" class="btn btn-sm btn-light border">Terapkan</button>
                    </form>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var filterSelect = document.getElementById('filter-select');
                        var bulanTahunGroup = document.getElementById('bulan-tahun-group');
                        var inputTanggal = document.getElementById('input-tanggal');
                        filterSelect.addEventListener('change', function() {
                            if(this.value === 'bulanan') {
                                bulanTahunGroup.style.display = 'inline-flex';
                                inputTanggal.style.display = 'none';
                            } else {
                                bulanTahunGroup.style.display = 'none';
                                inputTanggal.style.display = 'inline-block';
                            }
                        });
                        // Inisialisasi tampilan saat reload
                        if(filterSelect.value === 'bulanan') {
                            bulanTahunGroup.style.display = 'inline-flex';
                            inputTanggal.style.display = 'none';
                        } else {
                            bulanTahunGroup.style.display = 'none';
                            inputTanggal.style.display = 'inline-block';
                        }
                    });
                    </script>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $absensi = Auth::user()->mahasantri->absensi;
                                    $filter = request('filter', 'harian');
                                    if($filter === 'bulanan') {
                                        $bulan = request('bulan', now()->format('m'));
                                        $tahun = request('tahun', now()->format('Y'));
                                        $absensi = $absensi->filter(function($a) use ($bulan, $tahun) {
                                            return $a->tanggal->format('m') == $bulan && $a->tanggal->format('Y') == $tahun;
                                        });
                                    } else {
                                        $tanggal = request('tanggal', now()->format('Y-m-d'));
                                        $absensi = $absensi->filter(function($a) use ($tanggal) {
                                            return $a->tanggal->format('Y-m-d') == $tanggal;
                                        });
                                    }
                                @endphp
                                @foreach($absensi->sortByDesc('tanggal')->take(10) as $absen)
                                <tr>
                                    <td>{{ $absen->tanggal->format('d-m-Y') }}</td>
                                    <td>{{ $absen->kegiatan->nama_kegiatan ?? '-' }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($absen->status);
                                        @endphp
                                        @if($status === 'hadir')
                                            <span class="badge badge-success">Hadir</span>
                                            @if(isset($absen->kegiatan->jenis) && $absen->kegiatan->jenis === 'sholat_jamaah')
                                                @if(!empty($absen->is_late))
                                                    <span class="badge badge-warning ml-1">Terlambat Sholat</span>
                                                @endif
                                                @if(isset($absen->is_shaf_pertama) && ($absen->is_shaf_pertama == 1 || $absen->is_shaf_pertama === true || $absen->is_shaf_pertama === 'on'))
                                                    <span class="badge badge-info ml-1" title="Tidak Shaf Pertama">T Shaf</span>
                                                @endif
                                            @endif
                                        @elseif($status === 'izin')
                                            <span class="badge badge-warning text-white">Izin</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucfirst($absen->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white font-weight-bold d-flex justify-content-between align-items-center">
                    <span>Data Pembayaran UKT</span>
                    <form method="GET" class="form-inline d-flex align-items-center" style="gap:8px;">
                        <select name="ukt_filter" id="ukt-filter-select" class="form-control form-control-sm">
                            <option value="harian" {{ request('ukt_filter', 'harian') == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="bulanan" {{ request('ukt_filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                        <input type="date" name="ukt_tanggal" class="form-control form-control-sm" value="{{ request('ukt_tanggal', now()->format('Y-m-d')) }}" id="ukt-input-tanggal">
                        <div id="ukt-bulan-tahun-group" style="display:{{ request('ukt_filter')=='bulanan'?'inline-flex':'none' }};gap:8px;align-items:center;">
                            <label for="ukt-input-bulan" class="mb-0">Bulan</label>
                            <input type="number" name="ukt_bulan" min="1" max="12" class="form-control form-control-sm" placeholder="Bulan" value="{{ request('ukt_bulan', now()->format('m')) }}" id="ukt-input-bulan" style="width:90px;">
                            <label for="ukt-input-tahun" class="mb-0">Tahun</label>
                            <input type="number" name="ukt_tahun" min="2020" class="form-control form-control-sm" placeholder="Tahun" value="{{ request('ukt_tahun', now()->format('Y')) }}" id="ukt-input-tahun" style="width:100px;">
                        </div>
                        <button type="submit" class="btn btn-sm btn-light border">Terapkan</button>
                    </form>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // UKT filter toggle
                        var uktFilterSelect = document.getElementById('ukt-filter-select');
                        var uktBulanTahunGroup = document.getElementById('ukt-bulan-tahun-group');
                        var uktInputTanggal = document.getElementById('ukt-input-tanggal');
                        uktFilterSelect.addEventListener('change', function() {
                            if(this.value === 'bulanan') {
                                uktBulanTahunGroup.style.display = 'inline-flex';
                                uktInputTanggal.style.display = 'none';
                            } else {
                                uktBulanTahunGroup.style.display = 'none';
                                uktInputTanggal.style.display = 'inline-block';
                            }
                        });
                        // Inisialisasi tampilan saat reload
                        if(uktFilterSelect.value === 'bulanan') {
                            uktBulanTahunGroup.style.display = 'inline-flex';
                            uktInputTanggal.style.display = 'none';
                        } else {
                            uktBulanTahunGroup.style.display = 'none';
                            uktInputTanggal.style.display = 'inline-block';
                        }
                    });
                    </script>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal Bayar</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $uktPayments = Auth::user()->mahasantri->uktPayments;
                                    $uktFilter = request('ukt_filter', 'harian');
                                    if($uktFilter === 'bulanan') {
                                        $uktBulan = request('ukt_bulan', now()->format('m'));
                                        $uktTahun = request('ukt_tahun', now()->format('Y'));
                                        $uktPayments = $uktPayments->filter(function($u) use ($uktBulan, $uktTahun) {
                                            return $u->tanggal_bayar && $u->tanggal_bayar->format('m') == $uktBulan && $u->tanggal_bayar->format('Y') == $uktTahun;
                                        });
                                    } else {
                                        $uktTanggal = request('ukt_tanggal', now()->format('Y-m-d'));
                                        $uktPayments = $uktPayments->filter(function($u) use ($uktTanggal) {
                                            return $u->tanggal_bayar && $u->tanggal_bayar->format('Y-m-d') == $uktTanggal;
                                        });
                                    }
                                @endphp
                                @foreach($uktPayments->sortByDesc('tanggal_bayar')->take(10) as $ukt)
                                <tr>
                                    <td>{{ $ukt->tanggal_bayar ? $ukt->tanggal_bayar->format('d-m-Y') : '-' }}</td>
                                    <td>Rp {{ number_format($ukt->jumlah,0,',','.') }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($ukt->status);
                                        @endphp
                                        @if($status === 'lunas')
                                            <span class="badge badge-success">Lunas</span>
                                        @elseif($status === 'pending')
                                            <span class="badge badge-warning text-white">Pending</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucfirst($ukt->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Data Hukuman (Nonaktif) -->
            <!--
            <h3 class="text-lg font-bold mt-8 mb-4">Data Hukuman</h3>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-1">Jenis Hukuman</th>
                            <th class="px-2 py-1">Tanggal Mulai</th>
                            <th class="px-2 py-1">Tanggal Selesai</th>
                            <th class="px-2 py-1">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach(Auth::user()->mahasantri->hukuman->sortByDesc('tanggal_mulai')->take(10) as $hukuman)
                        <tr>
                            <td class="px-2 py-1">{{ $hukuman->jenis_hukuman }}</td>
                            <td class="px-2 py-1">{{ $hukuman->tanggal_mulai ? $hukuman->tanggal_mulai->format('d-m-Y') : '-' }}</td>
                            <td class="px-2 py-1">{{ $hukuman->tanggal_selesai ? $hukuman->tanggal_selesai->format('d-m-Y') : '-' }}</td>
                            <td class="px-2 py-1">{{ $hukuman->deskripsi ?? '-' }}</td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
            -->
        </div>
    </div>
</div>
<!-- Modal Ganti Password harus berada di luar .container/.row agar tidak terpengaruh overflow/z-index -->
<div class="modal fade" id="modalGantiPassword" tabindex="-1" role="dialog" aria-labelledby="modalGantiPasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalGantiPasswordLabel">Ganti Password</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('password.update') }}">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="current_password">Password Lama</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required autocomplete="current-password">
          </div>
          <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
          </div>
          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
          </div>
          <div class="text-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</x-app-layout>