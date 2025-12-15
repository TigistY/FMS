@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-edit me-2"></i> Edit College: {{ $college->name_en }}</h1>
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
            {{-- PATCH method is used for updates in Laravel RESTful resources --}}
            <form action="{{ route('colleges.update', $college) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="row">
                    {{-- College Name in English --}}
                    <div class="col-md-6 mb-3">
                        <label for="name_en" class="form-label">College Name (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_en" name="name_en" 
                               value="{{ old('name_en', $college->name_en) }}" required>
                    </div>
                    
                    {{-- College Name in Amharic --}}
                    <div class="col-md-6 mb-3">
                        <label for="name_am" class="form-label">የኮሌጁ ስም (አማርኛ) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_am" name="name_am" 
                               style="font-family: 'Noto Sans Ethiopic', sans-serif;" 
                               value="{{ old('name_am', $college->name_am) }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="code" class="form-label">College Code (E.g., CSEE) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="code" name="code" 
                           value="{{ old('code', $college->code) }}" required>
                </div>

                <div class="mb-3">
                    <label for="dean_name" class="form-label">Dean Name</label>
                    <input type="text" class="form-control" id="dean_name" name="dean_name" 
                           value="{{ old('dean_name', $college->dean_name) }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $college->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('colleges.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-sync me-1"></i> Update College</button>
                </div>
            </form>
        </div>
    </div>
@endsection