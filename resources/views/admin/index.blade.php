@extends('layouts.app') {{-- የእርስዎን Layout ስም ይጠቀሙ --}}

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>User Management</h4>
            @can('create-users')
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Add New User</a>
            @endcan
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Assigned Unit</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->college)
                                <span class="badge bg-info">College: {{ $user->college->name_en }}</span>
                            @elseif($user->department)
                                <span class="badge bg-secondary">Dept: {{ $user->department->name_en }}</span>
                            @elseif($user->directory)
                                <span class="badge bg-dark">Dir: {{ $user->directory->name_en }}</span>
                            @else
                                <span class="text-muted">Not Assigned</span>
                            @endif
                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @can('edit-users')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @endcan

                            @can('delete-users')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection