@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Register New Department</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('departments.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Parent College <span class="text-danger">*</span></label>
                            <select name="college_id" class="form-select @error('college_id') is-invalid @enderror" required>
                                <option value="">-- Select College --</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>{{ $college->name_en }}</option>
                                @endforeach
                            </select>
                            @error('college_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department Name <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>
                                @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ዲፓርትመንት ስም</label>
                                <input type="text" name="name_am" class="form-control" value="{{ old('name_am') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department Head</label>
                            <input type="text" name="head_name" class="form-control" value="{{ old('head_name') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back to List</a>
                            <button type="submit" class="btn btn-success px-4">Save Department</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection