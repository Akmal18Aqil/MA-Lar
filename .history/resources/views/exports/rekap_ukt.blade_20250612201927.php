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
        @foreach($mahasantris as $m)
            @foreach($m->uktPayments as $ukt)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $m->nim }}</td>
                <td>{{ $m->nama_lengkap }}</td>
                <td>{{ $m->user->email ?? '-' }}</td>
                <td>{{ $m->semester }}</td>
                <td>{{ $ukt->jumlah }}</td>
                <td>{{ $ukt->tanggal_bayar }}</td>
                <td>{{ ucfirst($ukt->status) }}</td>
                <td>{{ $ukt->periode }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
