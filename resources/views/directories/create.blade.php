@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Register New Directory</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('directories.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Directory Code (e.g., HRD) <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name (English) <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>
                                @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name (Amharic)</label>
                                <input type="text" name="name_am" class="form-control" value="{{ old('name_am') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Manager Name</label>
                            <input type="text" name="manager_name" class="form-control" value="{{ old('manager_name') }}" placeholder="Enter manager full name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('directories.index') }}" class="btn btn-secondary">Back to List</a>
                            <button type="submit" class="btn btn-success px-4">Save Directory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection