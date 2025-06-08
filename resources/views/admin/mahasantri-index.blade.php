<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Mahasantri') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="container-fluid px-0" style="max-width:100vw;">
            <div class="bg-white rounded shadow-sm p-0" style="border:1px solid #ececec;">
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-2">
                    <h4 class="mb-0 font-weight-bold" style="color:#6c63ff">Daftar Mahasantri</h4>
                    <a href="{{ route('admin.mahasantri') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Mahasantri</a>
                </div>
                <div class="table-responsive px-4 pb-4">
                    <table class="table table-striped table-hover w-100" style="min-width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:40px">#</th>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th style="width:120px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = ($mahasantris->currentPage() - 1) * $mahasantris->perPage() + 1; @endphp
                            @foreach($mahasantris ?? [] as $m)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $m->nim }}</td>
                                <td>{{ $m->nama_lengkap }}</td>
                                <td>{{ $m->user->email }}</td>
                                <td>
                                    @if($m->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Not Active</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                            @if(empty($mahasantris) || count($mahasantris) === 0)
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data Mahasantri.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="px-4 pb-4">
                    <div class="mt-2 d-flex justify-content-end">
                        {{ $mahasantris->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
