<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Mahasantri') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Data Mahasantri</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.mahasantri.update', $mahasantri->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nim">NIM <span class="text-danger">*</span></label>
                                    <input type="text" name="nim" id="nim" required class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $mahasantri->nim) }}">
                                    @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" id="full_name" required class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $mahasantri->nama_lengkap) }}">
                                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" required class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $mahasantri->user->email) }}">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date_of_birth">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" required class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $mahasantri->tanggal_lahir->format('Y-m-d')) }}">
                                    @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="phone_number">Nomor HP <span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" id="phone_number" required class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $mahasantri->no_hp) }}">
                                    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="address" id="address" required class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $mahasantri->alamat) }}</textarea>
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="guardian_name">Nama Wali <span class="text-danger">*</span></label>
                                    <input type="text" name="guardian_name" id="guardian_name" required class="form-control @error('guardian_name') is-invalid @enderror" value="{{ old('guardian_name', $mahasantri->nama_wali) }}">
                                    @error('guardian_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="guardian_contact">Kontak Wali <span class="text-danger">*</span></label>
                                    <input type="text" name="guardian_contact" id="guardian_contact" required class="form-control @error('guardian_contact') is-invalid @enderror" value="{{ old('guardian_contact', $mahasantri->kontak_wali) }}">
                                    @error('guardian_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Update Mahasantri</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
