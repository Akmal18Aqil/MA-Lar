<div>
    <!-- Card Statistik Jumlah Mahasantri -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-3"
                        style="width:56px;height:56px;">
                        <i class="fas fa-users fa-2x text-white"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Jumlah Mahasantri</div>
                        <div class="h3 mb-0 font-weight-bold">{{ $jumlahMahasantri }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- 
    <!-- Filter Laporan Absensi (Livewire) -->
    <div class="card mb-4 shadow border-0">
        <div class="card-body">
            <form class="form-inline flex-wrap gap-2" wire:submit.prevent="applyKegiatanFilter">
                <label for="filter" class="mr-2 font-semibold">Filter Laporan:</label>
                <select wire:model.live="filter" id="filter" class="form-control mr-2 mb-2 mb-md-0">
                    <option value="harian">Harian</option>
                    <option value="bulanan">Bulanan</option>
                    <option value="tahunan">Tahunan</option>
                </select>
                @if($filter === 'harian')
                    <input type="date" wire:model.live="tanggal" class="form-control mr-2 mb-2 mb-md-0" />
                @elseif($filter === 'bulanan')
                    <select wire:model.live="bulan" class="form-control mr-2 mb-2 mb-md-0">
                        @for($i=1;$i<=12;$i++)
                            <option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}" @if($bulan==str_pad($i,2,'0',STR_PAD_LEFT)) selected @endif>{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                        @endfor
                    </select>
                    <input type="number" wire:model.live="tahun" class="form-control mr-2 mb-2 mb-md-0" min="2000" max="2100" style="width:100px;" />
                @elseif($filter === 'tahunan')
                    <input type="number" wire:model.live="tahun" class="form-control mr-2 mb-2 mb-md-0" min="2000" max="2100" style="width:100px;" />
                @endif
                <label class="mr-2 font-semibold">Kegiatan:</label>
                <div class="dropdown d-inline-block mb-2">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownKegiatan" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(count($filterKegiatan) > 0)
                            {{ collect($daftarKegiatan)->whereIn('id', $filterKegiatan)->pluck('nama_kegiatan')->join(', ') }}
                        @else
                            Pilih Kegiatan
                        @endif
                    </button>
                    <div class="dropdown-menu p-3" aria-labelledby="dropdownKegiatan" style="min-width: 320px; max-height: 350px; overflow-y: auto;">
                        <div class="mb-2 d-flex justify-content-between">
                            <button type="button" class="btn btn-sm btn-link p-0" wire:click="selectAllKegiatan" wire:loading.attr="disabled">Pilih Semua</button>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0" wire:click="clearAllKegiatan" wire:loading.attr="disabled">Hapus Semua</button>
                        </div>
                        <div style="max-height: 250px; overflow-y: auto;">
                            @foreach($daftarKegiatan as $k)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="kegiatan_{{ $k->id }}" value="{{ $k->id }}" wire:model="filterKegiatan">
                                    <label class="form-check-label" for="kegiatan_{{ $k->id }}">
                                        {{ $k->nama_kegiatan }} ({{ $k->jenis_kegiatan ?? $k->jenis }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-2">Filter</button>
                <span wire:loading wire:target="filter,tanggal,bulan,tahun" class="text-primary ml-2"><i class="fas fa-spinner fa-spin"></i> Memuat...</span>
            </form>
            
        </div>
    </div>

    <!-- Tabel Laporan Absensi Mahasantri -->
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-calendar-check mr-2"></i>
            <h4 class="mb-0">Laporan Absensi Mahasantri ({{ ucfirst($filter) }})</h4>
        </div>
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
                        @forelse($laporanAbsensi as $absen)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $absen->mahasantri->nama_lengkap ?? '-' }}</td>
                                <td>{{ $absen->kegiatan->nama_kegiatan ?? '-' }}</td>
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
    </div> --}}

    @push('scripts')
    {{-- 1. Muat jQuery (diperlukan oleh Bootstrap 4) --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>

    {{-- 2. Muat Bootstrap JS Bundle (sudah termasuk Popper.js) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('livewire:navigated', () => {
            // Inisialisasi ulang script setelah navigasi Livewire
            initDropdownListener();
        });

        function initDropdownListener() {
            // Gunakan event listener dari JQuery yang lebih andal
            // Script ini akan mencegah dropdown tertutup saat area di dalamnya di-klik
            $('.dropdown-menu').on('click', function(event) {
                // Hentikan event agar tidak "naik" ke parent dan menutup dropdown
                event.stopPropagation();
            });
        }
        
        // Panggil fungsi inisialisasi saat halaman pertama kali dimuat
        initDropdownListener();

    </script>
    @endpush
</div>
