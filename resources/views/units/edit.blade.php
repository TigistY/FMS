@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card  border-0">
                <div class="card-header ">
                    <h5 class="mb-0 text-primary"><i class="fas fa-edit me-2"></i> Edit Unit: {{ $unit->name_en }}</h5>
                </div>
                <div class="card-body p-4">
                    <!-- The form targets the units.update resource route -->
                    <form method="POST" action="{{ route('units.update', $unit) }}">
                        @csrf
                        @method('PUT') <!-- Use PUT method for updates -->

                        <!-- Name (Amharic) -->
                        <div class="mb-3">
                            <label for="name_am" class="form-label fw-bolder text-dark">Unit Name (Amharic) - የዩኒት ስም (አማርኛ)</label>
                            <input type="text" 
                                   class="form-control form-control-lg border shadow-sm @error('name_am') is-invalid @enderror" 
                                   id="name_am" 
                                   name="name_am" 
                                   value="{{ old('name_am', $unit->name_am) }}" 
                                   required 
                                   maxlength="255">
                            @error('name_am')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Name (English) -->
                        <div class="mb-3">
                            <label for="name_en" class="form-label fw-bolder text-dark">Unit Name (English)</label>
                            <input type="text" 
                                   class="form-control form-control-lg border shadow-sm @error('name_en') is-invalid @enderror" 
                                   id="name_en" 
                                   name="name_en" 
                                   value="{{ old('name_en', $unit->name_en) }}" 
                                   required 
                                   maxlength="255">
                            @error('name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Code -->
                        <div class="mb-3">
                            <label for="code" class="form-label fw-bolder text-dark">Unit Code (Max 10 chars)</label>
                            <input type="text" 
                                   class="form-control border shadow-sm @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code', $unit->code) }}" 
                                   required 
                                   maxlength="10">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bolder text-dark">Contact Email</label>
                            <input type="email" 
                                   class="form-control border shadow-sm @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $unit->email) }}" 
                                   required 
                                   maxlength="255">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end pt-3">
                            <a href="{{ route('units.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning text-white shadow-sm">
                                <i class="fas fa-save me-1"></i> Update Unit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection