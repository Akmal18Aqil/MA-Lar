<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap flex-column flex-md-row justify-content-between align-items-center gap-2">
                            <h4 class="mb-2 mb-md-0">User List</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if (session('success'))
                                <div class="alert alert-success mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="table-responsive px-2 px-md-4 pb-4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning mb-1 mb-md-0" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger mb-1 mb-md-0" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
@media (max-width: 767.98px) {
    .card-header.d-flex {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 8px !important;
    }
    .table-responsive {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
    .btn {
        width: 100%;
        margin-bottom: 8px;
    }
    .card-header-action {
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }
}
</style>