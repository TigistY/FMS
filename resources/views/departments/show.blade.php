@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Department Information</h5>
                    <span class="badge bg-light text-dark">ID: #{{ $department->id }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light" style="width: 30%;">English Name</th>
                            <td>{{ $department->name_en }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Amharic Name</th>
                            <td>{{ $department->name_am ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Parent College</th>
                            <td><span class="badge bg-primary">{{ $department->college->name_en ?? 'N/A' }}</span></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Department Head</th>
                            <td><i class="fas fa-user-tie me-2 text-secondary"></i>{{ $department->head_name ?? 'Not Assigned' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Description</th>
                            <td>{{ $department->description ?? 'No description provided.' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Created Date</th>
                            <td>{{ $department->created_at->format('M d, Y - h:i A') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back to List</a>
                    <div>
                        <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Confirm Delete?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection