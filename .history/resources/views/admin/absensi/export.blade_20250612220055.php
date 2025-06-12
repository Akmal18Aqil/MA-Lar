@php
    $namaPeriode = $filter === 'bulanan' ? 'Bulan ' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . ' Tahun ' . $tahun : 'Tahun ' . $tahun;
    // Ambil data libur kegiatan
    $liburKegiatan = [];
    if (isset($tanggal)) {
        $liburKegiatan = \App\Models\LiburKegiatan::where('tanggal', $tanggal)->pluck('kegiatan_id')->toArray();
    } elseif (isset($bulan) && isset($tahun) && $filter === 'bulanan') {
        $liburKegiatan = \App\Models\LiburKegiatan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
    } elseif (isset($tahun) && $filter === 'tahunan') {
        $liburKegiatan = \App\Models\LiburKegiatan::whereYear('tanggal', $tahun)->get();
    }
@endphp
<table border="1">
    <thead>
        <tr>
            <th colspan="{{ 2 + count($kegiatan)*5 }}" style="text-align:center; font-weight:bold; font-size:16px;">Rekap Absensi {{ ucfirst($filter) }} - {{ $namaPeriode }}</th>
        </tr>
        <tr>
            <th rowspan="2">NIM</th>
            <th rowspan="2">Nama Mahasantri</th>
            @foreach($kegiatan as $k)
                <th colspan="5" style="text-align:center">
                    {{ $k->nama_kegiatan }} ({{ $k->jenis }})
                    @if($filter === 'harian' && isset($liburKegiatan) && is_array($liburKegiatan) && in_array($k->id, $liburKegiatan))
                        <span style="color:red;">Libur</span>
                    @elseif(($filter === 'bulanan' || $filter === 'tahunan') && isset($liburKegiatan) && $liburKegiatan->where('kegiatan_id', $k->id)->count() > 0)
                        <span style="color:red;">Libur {{ $liburKegiatan->where('kegiatan_id', $k->id)->count() }}x</span>
                    @endif
                </th>
            @endforeach
        </tr>
        <tr>
            @foreach($kegiatan as $k)
                <th>H</th>
                <th>I</th>
                <th>S</th>
                <th>A</th>
                <th>Terlambat</th>
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
                    $r = $rekap[$m->id][$k->id] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0,'terlambat'=>0];
                    $liburCount = 0;
                    if ($filter === 'harian' && isset($liburKegiatan) && is_array($liburKegiatan) && in_array($k->id, $liburKegiatan)) {
                        $liburCount = 1;
                    } elseif (($filter === 'bulanan' || $filter === 'tahunan') && isset($liburKegiatan) && $liburKegiatan->where('kegiatan_id', $k->id)->count() > 0) {
                        $liburCount = $liburKegiatan->where('kegiatan_id', $k->id)->count();
                    }
                @endphp
                <td>{{ $r['hadir'] }}</td>
                <td>{{ $r['izin'] }}</td>
                <td>{{ $r['sakit'] }}</td>
                <td>{{ $r['alfa'] }}</td>
                <td>{{ $r['terlambat'] }}</td>
            @endforeach
        </tr>
        @endforeach
        @if($filter === 'bulanan' || $filter === 'tahunan')
        <tr>
            <td colspan="2" style="font-weight:bold; text-align:right;">Jumlah Libur</td>
            @foreach($kegiatan as $k)
                @php
                    $liburCount = isset($liburKegiatan) ? $liburKegiatan->where('kegiatan_id', $k->id)->count() : 0;
                @endphp
                <td colspan="5" style="text-align:center; color:red; font-weight:bold;">{{ $liburCount > 0 ? $liburCount . 'x Libur' : '' }}</td>
            @endforeach
        </tr>
        @endif
    </tbody>
</table>
