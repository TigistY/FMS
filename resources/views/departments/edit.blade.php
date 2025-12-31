@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Department: {{ $department->name_en }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('departments.update', $department) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Parent College</label>
                            <select name="college_id" class="form-select" required>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}" {{ $department->college_id == $college->id ? 'selected' : '' }}>{{ $college->name_en }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department Name</label>
                                <input type="text" name="name_en" class="form-control" value="{{ $department->name_en }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ዲፓርትመንት ስም </label>
                                <input type="text" name="name_am" class="form-control" value="{{ $department->name_am }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department Head</label>
                            <input type="text" name="head_name" class="form-control" value="{{ $department->head_name }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $department->description }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Update Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection