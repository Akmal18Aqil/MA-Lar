@php
    $namaPeriode = $filter === 'bulanan' ? 'Bulan ' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . ' Tahun ' . $tahun : 'Tahun ' . $tahun;
@endphp
<table border="1">
    <thead>
        <tr>
            <th colspan="{{ 2 + count($kegiatan)*4 }}" style="text-align:center; font-weight:bold; font-size:16px;">Rekap Absensi {{ ucfirst($filter) }} - {{ $namaPeriode }}</th>
        </tr>
        <tr>
            <th rowspan="2">NIM</th>
            <th rowspan="2">Nama Mahasantri</th>
            @foreach($kegiatan as $k)
                <th colspan="4" style="text-align:center">{{ $k->nama_kegiatan }} ({{ $k->jenis }})</th>
            @endforeach
        </tr>
        <tr>
            @foreach($kegiatan as $k)
                <th>H</th>
                <th>I</th>
                <th>S</th>
                <th>A</th>
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
                    $r = $rekap[$m->id][$k->id] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0];
                @endphp
                <td>{{ $r['hadir'] }}</td>
                <td>{{ $r['izin'] }}</td>
                <td>{{ $r['sakit'] }}</td>
                <td>{{ $r['alfa'] }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
