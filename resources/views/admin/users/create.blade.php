<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create New User</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                     @error('name')
                                         <div class="invalid-feedback">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div class="form-group">
                                     <label for="email">Email</label>
                                     <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                     @error('email')
                                         <div class="invalid-feedback">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div class="form-group">
                                     <label for="password">Password</label>
                                     <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                     @error('password')
                                         <div class="invalid-feedback">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div class="form-group">
                                     <label for="role">Role</label>
                                     <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="admin">Admin</option>
                                        <option value="mahasantri">Mahasantri</option>
                                        <option value="dosen">Dosen</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>