@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="text-center mb-5 fw-bold text-primary">የሚና እና ፈቃድ አስተዳደር (Role & Permission Management)</h1>

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
        <!-- ፎርም: ለውጦቹን ወደ RolesController@updatePermissions ለመላክ -->
        <form action="{{ route('roles.update-permissions') }}" method="POST">
            @csrf
            @method('PUT') <!-- ለዝመና (Update) PUT ዘዴን እንጠቀማለን -->

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">ሚናዎችን ከፈቃዶች ጋር አገናኝ</span>
                <button type="submit" class="btn btn-warning fw-bold">
                    <i class="fas fa-save me-1"></i> ፈቃዶችን አስቀምጥ
                </button>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th style="width: 15%;" class="text-center">ሚና (Role)</th>
                                <!-- ፈቃዶችን በGroups መሠረት በTableHeader ውስጥ እናሳያለን -->
                                {{-- ✅ ማስተካከያ: አሁን የተከፋፈለው ተለዋዋጭ ጥቅም ላይ ውሏል --}}
                                @foreach ($permissionsByGroup as $group => $permissionList) 
                                    <th class="text-center text-capitalize">{{ str_replace(['-', '_'], ' ', $group) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ለእያንዳንዱ ሚና (Role) አንድ ረድፍ (Row) እንፈጥራለን -->
                            @foreach ($roles as $role)
                                <tr>
                                    <!-- ሚና ስም -->
                                    <td class="fw-bold text-center">
                                        {{ $role->name }}
                                        <!-- የሚናውን ID በ Hidden input ውስጥ እናስቀምጣለን -->
                                        <input type="hidden" name="roles[{{ $role->id }}][id]" value="{{ $role->id }}">
                                    </td>
                                    
                                    <!-- ለእያንዳንዱ ፈቃድ (Permission) ቡድን Checkbox እንፈጥራለን -->
                                    {{-- ✅ ማስተካከያ: አሁን የተከፋፈለው ተለዋዋጭ ጥቅም ላይ ውሏል --}}
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
                                                            <!-- የፈቃዱን ስም ከቡድኑ ስም በኃላ ያለውን ክፍል ብቻ እናሳያለን -->
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
                    <i class="fas fa-check-circle me-1"></i> ለውጦችን አስቀምጥ
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* ዩኒፎርም ለመፍጠር ለሚና እና ፈቃድ አምዶች ስፋት እንስጥ */
.table-bordered > :not(caption) > * > * {
    border-width: 1px 1px 0 0;
}
.table-bordered > :not(caption) > :last-child > * {
    border-bottom-width: 1px;
}
/* የTableHeader ቋሚ (sticky) እንዲሆን እና ግልጽነት እንዲሰጠው */
.table-dark {
    background-color: #212529 !important;
}
.sticky-top {
    position: sticky;
    top: 0;
    z-index: 10;
}
</style>
@endsection