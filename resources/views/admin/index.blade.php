@extends('layouts.app')

@section('content')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
<script>
$(document).ready(function() {
     if ($('#users').length > 0) {
            new DataTable('#users', {
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
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-users-cog me-2"></i> User Management</h5>
    @can('create-users')
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-user-plus me-1"></i> Add New User
        </a>
    @endcan
</div>
        <div class="card-body">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-hover border" id="users">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Assigned Unit</th>
                <th>Roles</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->college)
                        <span class="badge bg-info text-dark">
                             {{ $user->college->name_en }}</span>
                    @elseif($user->department)
                        <span class="badge bg-secondary"> {{ $user->department->name_en }}</span>
                    @elseif($user->directory)
                        <span class="badge bg-dark"> {{ $user->directory->name_en }}</span>
                    @else
                        <span class="text-muted italic">Not Assigned</span>
                    @endif
                </td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge rounded-pill bg-primary">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Action
                        </button>
                        <ul class="dropdown-menu shadow border-0">
                            <li><a class="dropdown-item text-info" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit text-warning me-2"></i>change</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete user?')"><i class="fas fa-trash me-2"></i> Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-muted">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
</div>
    </div>
</div>

@endsection
