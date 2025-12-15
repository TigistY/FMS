@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2>✏️ ዲፓርትመንት አስተካክል: {{ $department->name_en }}</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('departments.update', $department) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="college_id" class="form-label">ኮሌጅ ይምረጡ</label>
                    <select class="form-select @error('college_id') is-invalid @enderror" id="college_id" name="college_id" required>
                        <option value="">ኮሌጅ ይምረጡ</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}" {{ old('college_id', $department->college_id) == $college->id ? 'selected' : '' }}>{{ $college->name_en }}</option>
                        @endforeach
                    </select>
                    @error('college_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="name_en" class="form-label">የዲፓርትመንት ስም (እንግሊዝኛ)</label>
                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en', $department->name_en) }}" required>
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">ማስተካከያ አስቀምጥ</button>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">ተመለስ</a>
            </form>
        </div>
    </div>
</div>
@endsection