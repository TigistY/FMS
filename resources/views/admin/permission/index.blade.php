@extends('layouts.app')
@section('content')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
<script>
$(document).ready(function() {
    if ($('#permissions').length > 0) {
            new DataTable('#permissions', {
                lengthMenu: [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
                select:true,
                ordering:true,
                pagingType: "full_numbers",
                layout: {
                    topStart: {
                        buttons: [
                            {
                                         extend: 'colvis',
                                         className: 'btn btn-secondary btn-sm',
                                         text: '<i class="fas fa-columns"></i> Columns'
                                     },
                            { 
                                extend: 'pdf', 
                                className: 'btn btn-danger btn-sm', 
                                text: '<i class="fas fa-file-pdf"></i> PDF',
                               exportOptions: { columns: ':visible' }
                            },
                            { 
                                extend: 'print', 
                                className: 'btn btn-info btn-sm', 
                                text: '<i class="fas fa-print"></i> Print',
                                exportOptions: { columns: ':visible' }
                            }
                        ]
                    },
                    topEnd: 'search',
                    bottomStart: { pageLength: {}, info: {} },
                    bottomEnd: 'paging'
                }
            });
        }
    });
</script>

<div class="container-fluid">
    <h2 class="mb-4">Permission Management</h2>
    @include('partial.modal_addpermission')
    

    <table class="table table-bordered" id="permissions">
    <thead>
        <tr>
            <th>Group</th>
            <th>Permission Name</th>
            <th>Display Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($groupedPermissions as $group => $perms)
            @foreach($perms as $perm)
            <tr>
                <td><span class="badge bg-primary">{{ $group ?? 'General' }}</span></td>
                <td>{{ $perm->name }}</td>
                <td>{{ $perm->display_name }}</td>
                <td>
                    @include('partial.modal_permissionupdate')
                    <div class="dropdown">
    <button class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">Action</button>
    <ul class="dropdown-menu">
        <li>
            <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#editPermissionModal{{ $perm->id }}">
                <i class="fas fa-edit me-2"></i> Edit
            </button>
        </li>
        <li>
            <form action="{{ route('permissions.destroy', $perm->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash me-2"></i> Delete
                </button>
            </form>
        </li>
    </ul>
</div>
                </td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
</div>
@endsection