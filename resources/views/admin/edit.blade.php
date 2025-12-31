@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark d-flex justify-content-between">
                    <h5 class="mb-0">Edit User: {{ $user->name }}</h5>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-dark">Back to List</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <hr>
                        <h6>Update Unit Allocation</h6>
                        <div class="row text-muted small mb-2">
                            <div class="col">College</div>
                            <div class="col">Department</div>
                            <div class="col">Directory</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <select name="college_id" class="form-select">
                                    <option value="">-- None --</option>
                                    @foreach($colleges as $college)
                                        <option value="{{ $college->id }}" {{ $user->college_id == $college->id ? 'selected' : '' }}>
                                            {{ $college->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <select name="department_id" class="form-select">
                                    <option value="">-- None --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ $user->department_id == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <select name="directory_id" class="form-select">
                                    <option value="">-- None --</option>
                                    @foreach($directories as $dir)
                                        <option value="{{ $dir->id }}" {{ $user->directory_id == $dir->id ? 'selected' : '' }}>
                                            {{ $dir->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="mb-3">
                            <label class="form-label d-block">User Roles</label>
                            <div class="border p-3 rounded bg-light">
                                @foreach($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                            id="role_{{ $role->id }}"
                                            {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 border p-2 rounded bg-info bg-opacity-10">
                            <label class="form-label">New Password (Leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control" placeholder="Optional">
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Update User Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection