@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-building me-2"></i> Department Management</h2>
        <a href="{{ route('departments.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Department
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Department</th>
                        <th>College</th>
                        <th>Department Head</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $department)
                        <tr>
                            <td class="ps-3">{{ $department->id }}</td>
                            <td>
                                <strong>{{ $department->name_en }}</strong><br>
                                <small class="text-muted">{{ $department->name_am }}</small>
                            </td>
                            <td>{{ $department->college->name_en ?? 'N/A' }}</td>
                            <td>{{ $department->head_name ?? 'Not Assigned' }}</td>
                            <td class="text-center">
                                <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this department?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No departments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection