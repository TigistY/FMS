@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-plus me-2"></i> Register New College</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('colleges.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    {{-- College Name in English --}}
                    <div class="col-md-6 mb-3">
                        <label for="name_en" class="form-label">College Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') }}" required>
                    </div>
                    
                    {{-- College Name in Amharic --}}
                    <div class="col-md-6 mb-3">
                        <label for="name_am" class="form-label">የኮሌጁ ስም <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_am" name="name_am" value="{{ old('name_am') }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="code" class="form-label">College Code (E.g., CSEE) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
                </div>

                <div class="mb-3">
                    <label for="dean_name" class="form-label">Dean Name</label>
                    <input type="text" class="form-control" id="dean_name" name="dean_name" value="{{ old('dean_name') }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('colleges.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Register College</button>
                </div>
            </form>
        </div>
    </div>
@endsection