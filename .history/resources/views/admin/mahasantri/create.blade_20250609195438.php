<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Mahasantri') }}
        </h2>
    </x-slot>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Tambah Mahasantri</h4>
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
                                    <label for="date_of_birth">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" required class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
                                    @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="phone_number">Nomor HP <span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" id="phone_number" required class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}">
                                    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="address" id="address" required class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="guardian_name">Nama Wali <span class="text-danger">*</span></label>
                                    <input type="text" name="guardian_name" id="guardian_name" required class="form-control @error('guardian_name') is-invalid @enderror" value="{{ old('guardian_name') }}">
                                    @error('guardian_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="guardian_contact">Kontak Wali <span class="text-danger">*</span></label>
                                    <input type="text" name="guardian_contact" id="guardian_contact" required class="form-control @error('guardian_contact') is-invalid @enderror" value="{{ old('guardian_contact') }}">
                                    @error('guardian_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="semester">Semester <span class="text-danger">*</span></label>
                                    <input type="text" name="semester" id="semester" required class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester') }}">
                                    @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status_lulus">Status Lulus <span class="text-danger">*</span></label>
                                    <select name="status_lulus" id="status_lulus" class="form-control @error('status_lulus') is-invalid @enderror">
                                        <option value="belum" selected>Belum Lulus</option>
                                        <option value="lulus">Lulus</option>
                                    </select>
                                    @error('status_lulus')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row" id="tahunLulusRow" style="display:none;">
                                <div class="form-group col-md-6">
                                    <label for="tahun_lulus">Tahun Lulus</label>
                                    <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control @error('tahun_lulus') is-invalid @enderror" value="{{ old('tahun_lulus') }}" min="2000" max="{{ date('Y') }}">
                                    @error('tahun_lulus')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const statusLulus = document.getElementById('status_lulus');
                                    const tahunLulusRow = document.getElementById('tahunLulusRow');
                                    statusLulus.addEventListener('change', function() {
                                        if (this.value === 'lulus') {
                                            tahunLulusRow.style.display = '';
                                        } else {
                                            tahunLulusRow.style.display = 'none';
                                            document.getElementById('tahun_lulus').value = '';
                                        }
                                    });
                                    if (statusLulus.value === 'lulus') tahunLulusRow.style.display = '';
                                });
                            </script>
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
</x-app-layout>
