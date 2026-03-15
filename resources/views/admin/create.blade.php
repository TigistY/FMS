@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <h5 class="mb-0">Add New User</h5>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-light">Back to List</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr>
                        <h6>Assign Unit</h6>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted small">College</label>
                                <select name="college_id" class="form-select">
                                    <option value="">Select College</option>
                                    @foreach($colleges as $college)
                                        <option value="{{ $college->id }}">{{ $college->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted small">Department</label>
                                <select name="department_id" class="form-select">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted small">Directory</label>
                                <select name="directory_id" class="form-select">
                                    <option value="">Select Directory</option>
                                    @foreach($directories as $dir)
                                        <option value="{{ $dir->id }}">{{ $dir->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="mb-3">
                            <label class="form-label d-block">Assign Roles</label>
                            <div class="border p-3 rounded bg-light">
                                @foreach($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}">
                                        <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success">Create User Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection