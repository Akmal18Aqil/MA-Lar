<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pembayaran UKT') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="container-fluid px-0" style="max-width:100vw;">
            <div class="bg-white rounded shadow-sm p-0" style="border:1px solid #ececec;">
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-2">
                    <h4 class="mb-0 font-weight-bold" style="color:#6c63ff">Daftar Pembayaran UKT</h4>
                    <a href="{{ route('admin.ukt.create') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Pembayaran</a>
                </div>
                @if(session('success'))
                    <div class="alert alert-success mx-4">{{ session('success') }}</div>
                @endif
                <form method="GET" action="" class="d-flex flex-wrap align-items-center gap-2 px-4 pb-2">
                    <input type="text" name="semester" class="form-control form-control-sm mr-2 mb-2" placeholder="Semester" value="{{ request('semester') }}" style="max-width:150px;">
                    <button type="submit" class="btn btn-primary btn-sm mb-2"><i class="fa fa-filter"></i> Filter</button>
                    <a href="{{ route('admin.ukt.export', ['semester' => request('semester')]) }}" class="btn btn-success btn-sm mb-2 {{ !request('semester') ? 'disabled' : '' }}" @if(!request('semester')) onclick="return false;" @endif>
                        <i class="fas fa-file-excel"></i> Export Rekap UKT Semester
                    </a>
                </form>
                <div class="table-responsive px-4 pb-4">
                    <table class="table table-striped table-hover w-100" style="min-width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:40px">#</th>
                                <th>Nama Mahasantri</th>
                                <th>Jumlah</th>
                                <th>Tanggal Bayar</th>
                                <th>Status</th>
                                <th>Periode</th>
                                <th style="width:150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $allMahasantri = \App\Models\Mahasantri::with(['uktPayments' => function($q){ $q->where('periode', request('semester')); }])->get(); @endphp
                            @foreach($allMahasantri as $i => $m)
                                @php $ukt = $m->uktPayments->first(); @endphp
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $m->nama_lengkap }}</td>
                                    <td>{{ $ukt ? 'Rp '.number_format($ukt->jumlah,0,',','.') : '-' }}</td>
                                    <td>{{ $ukt ? \Carbon\Carbon::parse($ukt->tanggal_bayar)->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        @if($ukt && $ukt->status === 'lunas')
                                            <span class="badge badge-success">Lunas</span>
                                        @elseif($ukt && $ukt->status === 'tunggakan')
                                            <span class="badge badge-danger">Tunggakan</span>
                                        @elseif($ukt && $ukt->status === 'belum_lunas')
                                            <span class="badge badge-warning">Belum Lunas</span>
                                        @else
                                            <span class="badge badge-secondary">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>{{ $ukt ? $ukt->periode : request('semester') }}</td>
                                    <td>
                                        @if($ukt)
                                            <a href="{{ route('admin.ukt.edit', $ukt->id) }}" class="btn btn-warning btn-icon btn-sm mr-1" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.ukt.destroy', $ukt->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-icon btn-sm" title="Delete" onclick="return confirm('Yakin hapus data?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2 d-flex justify-content-end">
                        {{ $uktPayments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
