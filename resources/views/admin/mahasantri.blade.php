<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Mahasantri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="section-body">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10 col-lg-8">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h4 class="mb-0">Tambah Mahasantri</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('admin.mahasantri.store') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="nim">NIM <span class="text-danger">*</span></label>
                                                    <input type="text" name="nim" id="nim" required class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}">
                                                    @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
                                                    <input type="text" name="full_name" id="full_name" required class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}">
                                                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" id="email" required class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="date_of_birth">Tanggal Lahir</label>
                                                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
                                                    @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="phone_number">Kontak</label>
                                                    <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}">
                                                    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="address">Alamat</label>
                                                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="guardian_name">Nama Wali</label>
                                                    <input type="text" name="guardian_name" id="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror" value="{{ old('guardian_name') }}">
                                                    @error('guardian_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="guardian_contact">Kontak Wali</label>
                                                    <input type="text" name="guardian_contact" id="guardian_contact" class="form-control @error('guardian_contact') is-invalid @enderror" value="{{ old('guardian_contact') }}">
                                                    @error('guardian_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <button type="submit" class="btn btn-primary btn-lg btn-block">Simpan Mahasantri</button>
                                                <div class="form-text text-muted mt-2">Password default akan sama dengan NIM.</div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-8 text-lg font-medium text-gray-900">Daftar Mahasantri</h3>
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Contoh baris data, ini akan diisi secara dinamis dari database -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">2023001</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Ahmad Fulan</td>
                                    <td class="px-6 py-4 whitespace-nowrap">ahmad.fulan@example.com</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <a href="#" class="ml-4 text-red-600 hover:text-red-900">Hapus</a>
                                    </td>
                                </tr>
                                <!-- Tambahkan baris lain sesuai kebutuhan -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>