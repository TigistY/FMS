@extends('layouts.app')

@section('content')

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Directorate: {{ $directory->name_en }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('directories.update', $directory) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Directorate Code</label>
                            <input type="text" name="code" class="form-control" value="{{ $directory->code }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name (English)</label>
                                <input type="text" name="name_en" class="form-control" value="{{ $directory->name_en }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name (Amharic)</label>
                                <input type="text" name="name_am" class="form-control" value="{{ $directory->name_am }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Manager Name</label>
                            <input type="text" name="manager_name" class="form-control" value="{{ $directory->manager_name }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $directory->description }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('directories.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Update Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection