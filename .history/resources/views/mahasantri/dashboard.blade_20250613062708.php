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
                <!-- Modal Ganti Password -->
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
                <!-- End Modal Ganti Password -->
            </div>
            <!-- Data Terkait Mahasantri -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white font-weight-bold">Data Absensi</div>
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
                                @foreach(Auth::user()->mahasantri->absensi->sortByDesc('tanggal')->take(10) as $absen)
                                <tr>
                                    <td>{{ $absen->tanggal->format('d-m-Y') }}</td>
                                    <td>{{ $absen->kegiatan->nama_kegiatan ?? '-' }}</td>
                                    <td>{{ ucfirst($absen->status) }}</td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white font-weight-bold">Data Pembayaran UKT</div>
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
                                @foreach(Auth::user()->mahasantri->uktPayments->sortByDesc('tanggal_bayar')->take(10) as $ukt)
                                <tr>
                                    <td>{{ $ukt->tanggal_bayar ? $ukt->tanggal_bayar->format('d-m-Y') : '-' }}</td>
                                    <td>Rp {{ number_format($ukt->jumlah,0,',','.') }}</td>
                                    <td>{{ ucfirst($ukt->status) }}</td>
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
</x-app-layout>