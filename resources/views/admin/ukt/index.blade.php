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
                            @foreach($uktPayments as $ukt)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ukt->mahasantri->nama_lengkap ?? '-' }}</td>
                                <td>Rp {{ number_format($ukt->jumlah,0,',','.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($ukt->tanggal_bayar)->format('d-m-Y') }}</td>
                                <td><span class="badge badge-{{ $ukt->status == 'lunas' ? 'success' : ($ukt->status == 'tunggakan' ? 'danger' : 'warning') }}">{{ ucfirst(str_replace('_',' ',$ukt->status)) }}</span></td>
                                <td>{{ $ukt->periode }}</td>
                                <td>
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
