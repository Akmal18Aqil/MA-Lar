<x-app-layout>
    <x-slot name="header">
        Detail Absen & UKT Mahasantri
    </x-slot>
    <div class="container py-4">
        <h3 class="mb-4">Controling Data Absen & UKT Mahasantri</h3>
        <!-- Form Filter Absensi dengan filter kegiatan multiple -->
        <form method="GET" class="form-inline flex-wrap gap-2 mb-4" id="filter-form">
            <label for="filter_type" class="mr-2 font-semibold">Filter Laporan:</label>
            <select name="filter_type" id="filter_type" class="form-control mr-2 mb-2 mb-md-0">
                <option value="harian" {{ request('filter_type', 'harian') == 'harian' ? 'selected' : '' }}>Harian</option>
                <option value="bulanan" {{ request('filter_type') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                <option value="tahunan" {{ request('filter_type') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
            </select>
            @if(request('filter_type', 'harian') == 'harian')
                <input type="date" name="tanggal" class="form-control mr-2 mb-2 mb-md-0" value="{{ request('tanggal', now()->format('Y-m-d')) }}" />
            @elseif(request('filter_type') == 'bulanan')
                <select name="bulan" class="form-control mr-2 mb-2 mb-md-0">
                    @for($i=1;$i<=12;$i++)
                        <option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}" @if(request('bulan', now()->format('m'))==str_pad($i,2,'0',STR_PAD_LEFT)) selected @endif>{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                    @endfor
                </select>
                <input type="number" name="tahun" class="form-control mr-2 mb-2 mb-md-0" min="2000" max="2100" style="width:100px;" value="{{ request('tahun', now()->format('Y')) }}" />
            @elseif(request('filter_type') == 'tahunan')
                <input type="number" name="tahun" class="form-control mr-2 mb-2 mb-md-0" min="2000" max="2100" style="width:100px;" value="{{ request('tahun', now()->format('Y')) }}" />
            @endif
            <label class="mr-2 font-semibold">Kegiatan:</label>
            <div class="dropdown d-inline-block mb-2">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownKegiatan" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @php
                        $daftarKegiatan = \App\Models\Kegiatan::orderBy('nama_kegiatan')->get();
                        $filterKegiatan = (array)request('filter_kegiatan', []);
                    @endphp
                    @if(count($filterKegiatan) > 0)
                        {{ $daftarKegiatan->whereIn('id', $filterKegiatan)->pluck('nama_kegiatan')->join(', ') }}
                    @else
                        Pilih Kegiatan
                    @endif
                </button>
                <div class="dropdown-menu p-3" aria-labelledby="dropdownKegiatan" style="min-width: 320px; max-height: 350px; overflow-y: auto;">
                    <div class="mb-2 d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-link p-0" onclick="selectAllKegiatan()">Pilih Semua</button>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="clearAllKegiatan()">Hapus Semua</button>
                    </div>
                    <div style="max-height: 250px; overflow-y: auto;">
                        @foreach($daftarKegiatan as $k)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="kegiatan_{{ $k->id }}" name="filter_kegiatan[]" value="{{ $k->id }}" {{ in_array($k->id, $filterKegiatan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="kegiatan_{{ $k->id }}">
                                    {{ $k->nama_kegiatan }} ({{ $k->jenis_kegiatan ?? $k->jenis }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-2">Filter</button>
        </form>
        <script>
        function selectAllKegiatan() {
            document.querySelectorAll('input[name="filter_kegiatan[]"]').forEach(cb => cb.checked = true);
        }
        function clearAllKegiatan() {
            document.querySelectorAll('input[name="filter_kegiatan[]"]').forEach(cb => cb.checked = false);
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown tidak tertutup saat klik dalam menu
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });
        });
        </script>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold">Data Absen Mahasantri</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:120px">Tanggal</th>
                                        <th>Nama Mahasantri</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $absensi = \App\Models\Absensi::with(['mahasantri','kegiatan'])
                                            ->when(request('filter_type', 'harian') === 'bulanan', function($q) {
                                                $bulan = request('bulan', now()->format('m'));
                                                $tahun = request('tahun', now()->format('Y'));
                                                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                                            })
                                            ->when(request('filter_type') === 'tahunan', function($q) {
                                                $tahun = request('tahun', now()->format('Y'));
                                                $q->whereYear('tanggal', $tahun);
                                            })
                                            ->when(request('filter_type', 'harian') === 'harian', function($q) {
                                                $tanggal = request('tanggal', now()->format('Y-m-d'));
                                                $q->whereDate('tanggal', $tanggal);
                                            })
                                            ->when(count($filterKegiatan) > 0, function($q) use ($filterKegiatan) {
                                                $q->whereIn('kegiatan_id', $filterKegiatan);
                                            })
                                            ->orderByDesc('tanggal')->get();
                                    @endphp
                                    @forelse($absensi as $absen)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ $absen->mahasantri->nama_lengkap ?? $absen->mahasantri->nama ?? '-' }}</td>
                                        <td>{{ $absen->kegiatan->nama_kegiatan ?? $absen->kegiatan->nama ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center flex-wrap" style="gap:2px;">
                                                @php
                                                    $jenis = $absen->kegiatan->jenis_kegiatan ?? $absen->kegiatan->jenis ?? null;
                                                @endphp
                                                <span class="badge badge-{{ strtolower($absen->status) == 'hadir' ? 'success' : (strtolower($absen->status) == 'alfa' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($absen->status) }}
                                                </span>
                                                @if($jenis == 'pengajian' && !empty($absen->is_late))
                                                    <span class="badge badge-warning ml-1">Terlambat</span>
                                                @endif
                                                @if($jenis == 'sholat_jamaah')
                                                    @if(strtolower($absen->status) == 'hadir')
                                                        <span class="badge badge-success ml-1">Jama'ah</span>
                                                    @endif
                                                    @if(!empty($absen->is_late))
                                                        <span class="badge badge-warning ml-1">Terlambat Sholat</span>
                                                    @endif
                                                    @if(isset($absen->is_shaf_pertama) && ($absen->is_shaf_pertama == 1 || $absen->is_shaf_pertama === true || $absen->is_shaf_pertama === 'on'))
                                                        <span class="badge badge-info ml-1" title="Tidak Shaf Pertama">T Shaf</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $absen->keterangan ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Tidak ada data absensi.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white font-weight-bold">Data Pembayaran UKT Mahasantri</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $ukt = \App\Models\UktPayment::with('mahasantri')
                                            ->when(request('filter_type', 'harian') === 'bulanan', function($q) {
                                                $bulan = request('bulan', now()->format('m'));
                                                $tahun = request('tahun', now()->format('Y'));
                                                $q->whereMonth('tanggal_bayar', $bulan)->whereYear('tanggal_bayar', $tahun);
                                            })
                                            ->when(request('filter_type', 'harian') === 'harian', function($q) {
                                                $tanggal = request('tanggal', now()->format('Y-m-d'));
                                                $q->whereDate('tanggal_bayar', $tanggal);
                                            })
                                            ->orderByDesc('tanggal_bayar')->limit(20)->get();
                                    @endphp
                                    @foreach($ukt as $u)
                                    <tr>
                                        <td>{{ $u->mahasantri->nama ?? '-' }}</td>
                                        <td>{{ $u->mahasantri->nim ?? '-' }}</td>
                                        <td>{{ $u->tanggal_bayar ? \Carbon\Carbon::parse($u->tanggal_bayar)->format('d-m-Y') : '-' }}</td>
                                        <td>Rp {{ number_format($u->jumlah,0,',','.') }}</td>
                                        <td>
                                            @php $status = strtolower($u->status); @endphp
                                            @if($status === 'lunas')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif($status === 'pending')
                                                <span class="badge badge-warning text-white">Pending</span>
                                            @else
                                                <span class="badge badge-danger">{{ ucfirst($u->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
