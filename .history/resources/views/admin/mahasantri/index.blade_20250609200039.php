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
                    <a href="{{ route('admin.mahasantri.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Mahasantri</a>
                </div>
                <form method="GET" class="form-inline mb-3">
                    <div class="form-group mr-2 mb-2">
                        <label for="filter_semester" class="mr-2 mb-0">Semester</label>
                        <input type="text" name="semester" id="filter_semester" class="form-control form-control-sm" value="{{ request('semester') }}" placeholder="Semester">
                    </div>
                    <div class="form-group mr-2 mb-2">
                        <label for="filter_status_lulus" class="mr-2 mb-0">Status Lulus</label>
                        <select name="status_lulus" id="filter_status_lulus" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            <option value="belum" {{ request('status_lulus') == 'belum' ? 'selected' : '' }}>Belum Lulus</option>
                            <option value="lulus" {{ request('status_lulus') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
                </form>
                <div class="table-responsive px-4 pb-4">
                    <table class="table table-striped table-hover w-100" style="min-width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:40px">#</th>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Semester</th>
                                <th>Status Lulus</th>
                                <th>Tahun Lulus</th>
                                <th>Status</th>
                                <th style="width:150px">Action</th>
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
                                <td>{{ $m->semester }}</td>
                                <td>
                                    @if($m->status_lulus === 'lulus')
                                        <span class="badge badge-success">Lulus</span>
                                    @else
                                        <span class="badge badge-warning">Belum Lulus</span>
                                    @endif
                                </td>
                                <td>{{ $m->tahun_lulus }}</td>
                                <td>
                                    @if($m->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Not Active</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.mahasantri.edit', $m->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.mahasantri.destroy', $m->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if(empty($mahasantris) || count($mahasantris) === 0)
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data Mahasantri.</td>
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
