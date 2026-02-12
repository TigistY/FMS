@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="text-center mb-5 fw-bold text-primary">Role and Permission Management</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <!-- Form: To send changes to RolesController@updatePermissions -->
        <form action="{{ route('roles.update-permissions') }}" method="POST">
            @csrf
            @method('PUT') <!-- Use PUT method for updates -->

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">Link Roles with Permissions</span>
                <button type="submit" class="btn btn-warning fw-bold">
                    <i class="fas fa-save me-1"></i> Save Permissions
                </button>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th style="width: 15%;" class="text-center">Role</th>
                                <!-- Display permissions in the TableHeader based on Groups -->
                                {{-- Correction: The categorized variable is now used --}}
                                @foreach ($permissionsByGroup as $group => $permissionList) 
                                    <th class="text-center text-capitalize">{{ str_replace(['-', '_'], ' ', $group) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach ($roles as $role)
                                <tr>
                                    
                                    <td class="fw-bold text-center">
                                        {{ $role->name }}
                                        <input type="hidden" name="roles[{{ $role->id }}][id]" value="{{ $role->id }}">
                                    </td>
                                    
                                    
                                    @foreach ($permissionsByGroup as $group => $permissionList) 
                                        <td class="p-2">
                                            <div class="d-flex flex-column gap-1">
                                                @foreach ($permissionList as $permission)
                                                    <div class="form-check form-switch mb-0">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="checkbox" 
                                                            role="switch" 
                                                            id="perm_{{ $role->id }}_{{ $permission->id }}" 
                                                            name="permissions[{{ $role->id }}][{{ $permission->id }}]" 
                                                            {{ in_array($permission->id, $role->current_permission_ids) ? 'checked' : '' }}
                                                            value="1" 
                                                            >
                                                        <label class="form-check-label small" for="perm_{{ $role->id }}_{{ $permission->id }}">
                                                            <!-- Display only the permission name part after the group name -->
                                                            {{ str_replace($group . '-', '', $permission->name) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary fw-bold">
                    <i class="fas fa-check-circle me-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Give width to role and permission columns to create uniformity */
.table-bordered > :not(caption) > * > * {
    border-width: 1px 1px 0 0;
}
.table-bordered > :not(caption) > :last-child > * {
    border-bottom-width: 1px;
}
/* Make the TableHeader sticky and give it clarity */
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

    $('.form-check-input').on('change', function() {
        let checkbox = $(this);
        
        let idParts = checkbox.attr('id').split('_');
        let roleId = idParts[1];
        let permissionId = idParts[2];
        let isChecked = checkbox.is(':checked') ? 1 : 0;

        checkbox.prop('disabled', true);

        $.ajax({
            url: "{{ route('roles.update-single-permission') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                role_id: roleId,
                permission_id: permissionId,
                status: isChecked
            },
            success: function(response) {
                checkbox.prop('disabled', false);
                
                
                location.reload(); 
            },
            error: function(xhr) {
                checkbox.prop('disabled', false);
                checkbox.prop('checked', !isChecked); 
                
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'error happne';
                alert('error happen፡ ' + errorMsg);
            }
        });
    });
});
</script>
@endsection