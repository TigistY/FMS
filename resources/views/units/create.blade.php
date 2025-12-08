@extends('layouts.app')

@section('title', 'Create New Unit')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card shadow-lg border-0 rounded-4">
                
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <h1 class="h3 fw-bold mb-1">
                        <i class="fas fa-sitemap me-2"></i> New Unit Registration
                    </h1>
                    <p class="mb-0 small opacity-75">
                        Please provide the required details for the new department or unit.
                    </p>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('units.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="row g-4">
                            <div class="col-12">
                                <label for="name_am" class="form-label fw-bold text-dark">
                                    የክፍሉ ስም (Amharic) <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name_am" id="name_am" required 
                                        class="form-control form-control-lg @error('name_am') is-invalid @enderror"
                                        value="{{ old('name_am') }}"
                                        >
                                @error('name_am')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="name_en" class="form-label fw-bold text-dark">
                                    Unit Name (English) <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name_en" id="name_en" required 
                                        class="form-control form-control-lg @error('name_en') is-invalid @enderror"
                                        value="{{ old('name_en') }}"
                                       >
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="code" class="form-label fw-bold text-dark">
                                    Code (Short Identifier) <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="code" id="code" required maxlength="10"
                                        class="form-control form-control-lg @error('code') is-invalid @enderror"
                                        value="{{ old('code') }}"
                                        >
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold text-dark">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" id="email" required 
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" 
                                    class="btn btn-success btn-lg fw-bold shadow-lg py-3 rounded-pill">
                                <i class="fas fa-plus-circle me-2"></i> Register New Unit
                            </button>
                        </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection