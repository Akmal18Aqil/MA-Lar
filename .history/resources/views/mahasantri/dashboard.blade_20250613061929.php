<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mahasantri Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card KTM -->
                <div class="bg-white shadow rounded-lg p-6 flex flex-col items-center border border-gray-200">
                    <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-4 border-indigo-400">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->mahasantri->nama_lengkap ?? Auth::user()->name) }}&background=6c63ff&color=fff&size=256" alt="Foto KTM" class="object-cover w-full h-full">
                    </div>
                    <h3 class="text-lg font-bold mb-1">{{ Auth::user()->mahasantri->nama_lengkap ?? '-' }}</h3>
                    <p class="text-sm text-gray-600 mb-1">NIM: <b>{{ Auth::user()->mahasantri->nim ?? '-' }}</b></p>
                    <p class="text-sm text-gray-600 mb-1">Semester: {{ Auth::user()->mahasantri->semester ?? '-' }}</p>
                    <p class="text-sm text-gray-600 mb-1">Status: {{ Auth::user()->mahasantri->status_lulus == 'lulus' ? 'Lulus' : 'Belum Lulus' }}</p>
                    <p class="text-sm text-gray-600 mb-1">Tahun Lulus: {{ Auth::user()->mahasantri->tahun_lulus ?? '-' }}</p>
                    <p class="text-sm text-gray-600 mb-1">No. HP: {{ Auth::user()->mahasantri->no_hp ?? '-' }}</p>
                    <p class="text-sm text-gray-600 mb-1">Alamat: {{ Auth::user()->mahasantri->alamat ?? '-' }}</p>
                    <p class="text-sm text-gray-600 mb-1">Tanggal Lahir: {{ Auth::user()->mahasantri->tanggal_lahir ? Auth::user()->mahasantri->tanggal_lahir->format('d-m-Y') : '-' }}</p>
                    <p class="text-sm text-gray-600 mb-1">Nama Wali: {{ Auth::user()->mahasantri->nama_wali ?? '-' }}</p>
                    <p class="text-sm text-gray-600 mb-1">Kontak Wali: {{ Auth::user()->mahasantri->kontak_wali ?? '-' }}</p>
                </div>
                <!-- Card Ganti Password -->
                <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Ganti Password</h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <!-- Data Terkait Mahasantri -->
            <div class="mt-8 bg-white shadow rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-bold mb-4">Data Absensi</h3>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1">Tanggal</th>
                                <th class="px-2 py-1">Kegiatan</th>
                                <th class="px-2 py-1">Status</th>
                                <th class="px-2 py-1">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->mahasantri->absensi->sortByDesc('tanggal')->take(10) as $absen)
                            <tr>
                                <td class="px-2 py-1">{{ $absen->tanggal->format('d-m-Y') }}</td>
                                <td class="px-2 py-1">{{ $absen->kegiatan->nama_kegiatan ?? '-' }}</td>
                                <td class="px-2 py-1">{{ ucfirst($absen->status) }}</td>
                                <td class="px-2 py-1">{{ $absen->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <h3 class="text-lg font-bold mt-8 mb-4">Data Pembayaran UKT</h3>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1">Tanggal Bayar</th>
                                <th class="px-2 py-1">Jumlah</th>
                                <th class="px-2 py-1">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->mahasantri->uktPayments->sortByDesc('tanggal_bayar')->take(10) as $ukt)
                            <tr>
                                <td class="px-2 py-1">{{ $ukt->tanggal_bayar ? $ukt->tanggal_bayar->format('d-m-Y') : '-' }}</td>
                                <td class="px-2 py-1">Rp {{ number_format($ukt->jumlah,0,',','.') }}</td>
                                <td class="px-2 py-1">{{ ucfirst($ukt->status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                            @foreach(Auth::user()->mahasantri->hukuman->sortByDesc('tanggal_mulai')->take(10) as $hukuman)
                            <tr>
                                <td class="px-2 py-1">{{ $hukuman->jenis_hukuman }}</td>
                                <td class="px-2 py-1">{{ $hukuman->tanggal_mulai ? $hukuman->tanggal_mulai->format('d-m-Y') : '-' }}</td>
                                <td class="px-2 py-1">{{ $hukuman->tanggal_selesai ? $hukuman->tanggal_selesai->format('d-m-Y') : '-' }}</td>
                                <td class="px-2 py-1">{{ $hukuman->deskripsi ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>