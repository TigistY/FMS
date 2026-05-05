@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Directorate Information</h5>
                    <span class="badge bg-light text-dark">CODE: {{ $directory->code }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light" style="width: 35%;">English Name</th>
                            <td>{{ $directory->name_en }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Amharic Name</th>
                            <td>{{ $directory->name_am ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Manager</th>
                            <td><i class="fas fa-user-tie me-2 text-secondary"></i>{{ $directory->manager_name ?? 'Not Specified' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Description</th>
                            <td>{{ $directory->description ?? 'No description provided.' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">System ID</th>
                            <td>#{{ $directory->id }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <a href="{{ route('directories.index') }}" class="btn btn-secondary">Back to List</a>
                    <div>
                        <a href="{{ route('directories.edit', $directory) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('directories.destroy', $directory) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection