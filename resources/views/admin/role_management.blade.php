@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Role and Permission Management</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRoleModal">Create New Role</button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
            <i class="fas fa-key"></i> Create New Permission
        </button>
    </div>

    <div class="card shadow-lg">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Role Name</th>
                        <th>Actions</th>
                        <th>Permissions Management</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td class="fw-bold">{{ $role->name }}</td>
                            <td class="text-center">
    <div class="dropdown">
        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-cog"></i> Action
        </button>
        <ul class="dropdown-menu">
            <li>
                <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $role->id }}">
                    <i class="fas fa-edit me-2"></i> Edit
                </button>
            </li>
            
            <li>
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('are you shur?');">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-trash me-2"></i> Delete
                    </button>
                </form>
            </li>
        </ul>
    </div>
</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#perms_{{ $role->id }}">Manage Permissions</button>
                                <div class="collapse mt-2" id="perms_{{ $role->id }}">
                                    <div class="row">
                                        @foreach ($permissionsByGroup as $group => $list)
                                            <div class="col-md-4 mb-2">
                                                <h6 class="text-capitalize border-bottom fw-bold">{{ $group }}</h6>
                                                <input type="checkbox" class="select-all-group" data-role-id="{{ $role->id }}" data-group="{{ $group }}"> <small>All {{ $group }}</small>
                                                @foreach ($list as $perm)
                                                    <div class="form-check">
                                                        <input class="form-check-input perm-check" type="checkbox" 
                                                            data-role-id="{{ $role->id }}" 
                                                            data-perm-id="{{ $perm->id }}" 
                                                            data-group="{{ $group }}"
                                                            {{ in_array($perm->id, $role->current_permission_ids) ? 'checked' : '' }}>
                                                        <label class="form-check-label">{{ str_replace($group . '-', '', $perm->name) }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                     @include('partial.modal_addrole')
                     @include('partial.modal_addpermission')
                        <div class="modal fade" id="editModal{{ $role->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header"><h5 class="modal-title">Edit Role: {{ $role->name }}</h5></div>
                                        <div class="modal-body">
                                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                                        </div>
                                        <div class="modal-footer"><button type="submit" class="btn btn-primary">Update</button></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>

.table-bordered > :not(caption) > * > * {
    border-width: 1px 1px 0 0;
}
.table-bordered > :not(caption) > :last-child > * {
    border-bottom-width: 1px;
}
.table-dark {
    background-color: #212529 !important;
}
.sticky-top {
    position: sticky;
    top: 0;
    z-index: 10;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.perm-check').on('change', function() {
        let checkbox = $(this);
        let isChecked = checkbox.is(':checked'); 

        $.ajax({
            url: "{{ route('roles.update-single-permission') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                role_id: checkbox.data('role-id'),
                permission_id: checkbox.data('perm-id'),
                status: isChecked ? 1 : 0
            },
           
            success: function(response) {
    checkbox.prop('disabled', false);
    $('.sidebar').load(location.href + ' .sidebar'); 
},
            error: function(xhr) {
                checkbox.prop('checked', !isChecked);
                alert('error');
            }
        });
    });

    // Select All
    $('.select-all-group').on('change', function() {
        let isChecked = $(this).is(':checked');
        let rId = $(this).data('role-id');
        let grp = $(this).data('group');
        
        $(`.perm-check[data-role-id="${rId}"][data-group="${grp}"]`)
            .prop('checked', isChecked)
            .trigger('change'); 
    });
});
</script>
@endsection

