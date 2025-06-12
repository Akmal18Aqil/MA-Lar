<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasantri</th>
            <th>Email</th>
            <th>Semester</th>
            <th>Jumlah Bayar</th>
            <th>Tanggal Bayar</th>
            <th>Status</th>
            <th>Periode</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach($laporan as $row)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $row['nim'] }}</td>
            <td>{{ $row['nama_lengkap'] }}</td>
            <td>{{ $row['email'] }}</td>
            <td>{{ $row['semester'] }}</td>
            <td>{{ $row['jumlah'] ? 'Rp '.number_format($row['jumlah'],0,',','.') : '-' }}</td>
            <td>{{ $row['tanggal_bayar'] !== '-' ? \Carbon\Carbon::parse($row['tanggal_bayar'])->format('d-m-Y') : '-' }}</td>
            <td>
                @if($row['status'] === 'lunas')
                    <span class="badge badge-success">Lunas</span>
                @elseif($row['status'] === 'tunggakan')
                    <span class="badge badge-danger">Tunggakan</span>
                @elseif($row['status'] === 'belum_lunas')
                    <span class="badge badge-warning">Belum Lunas</span>
                @else
                    <span class="badge badge-secondary">Belum Bayar</span>
                @endif
            </td>
            <td>{{ $row['periode'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
