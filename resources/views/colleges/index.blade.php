@extends('layouts.app')

@section('content')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
<script>
$(document).ready(function() {
    let table = new DataTable('#colleges', {
        lengthMenu: [[3, 5, 10, 25, 50, -1], [3, 5, 10, 25, 50, "All"]],
        pagingType: "full_numbers",
        
        layout: {    

            topStart: {
                buttons: [
                    { extend: 'pdf', className: 'btn btn-danger btn-sm', text: '<i class="fas fa-file-pdf"></i> PDF' },
                    { extend: 'print', className: 'btn btn-info btn-sm', text: '<i class="fas fa-print"></i> Print' }
                ]
            },
            topEnd: 'search',

            bottomStart: {
                pageLength: {}, 
                info: {}        
            },
            bottomEnd: 'paging' 
        }
    });
});
</script>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-building me-2"></i> College And Departemnt Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-primary" onclick="openAddCollegeModal()">
    <i class="fas fa-plus me-1"></i> Add New College
</button>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0 align-items-left">
            <button type="button" class="btn btn-sm btn-primary" onclick="openGlobalAddDepartmentModal()">
        <i class="fas fa-plus me-1"></i> Add New Department
    </button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover" id="colleges">
            <thead>
                <tr>
                    <th>#</th>
                    <th>College Name</th>
                    <th>Code</th>
                    <th>Dean Name</th>
                    <th>Departments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colleges as $college)
    <tr>
        <td>{{ $colleges->firstItem() + $loop->index }}</td>
        <td>
            <strong>{{ $college->name_en }}</strong><br>
            <small class="text-muted">{{ $college->name_am }}</small>
        </td>
        <td>{{ $college->code }}</td>
        <td>{{ $college->dean_name ?? 'N/A' }}</td>
        
        <td>
             <button class="btn btn-sm btn-outline-primary shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#deptCollapse{{ $college->id }}">
                 <i class="fas fa-list me-1"></i> {{ $college->departments->count() }} Departments
             </button>
    
             <div class="collapse mt-2" id="deptCollapse{{ $college->id }}">
                 <div class="card card-body p-2 bg-light shadow-sm border-0">
                     <ul class="list-unstyled mb-0" style="font-size: 0.85rem;">
                         @forelse($college->departments as $dept)
                    <li class="border-bottom py-2 d-flex justify-content-between align-items-center">
                        <span class="text-dark">
                            <i class="fas fa-chevron-right text-primary small me-1" style="font-size: 0.7rem;"></i>
                            {{ $dept->name_en }}
                        </span>
                        
                        {{--  for departemnt Action Buttons --}}
                        <div class="btn-group">
                            <button type="button" class="btn btn-link btn-sm p-0 me-2" 
                               onclick="openEditDepartmentModal(
                                   '{{ $dept->id }}', 
                                   '{{ addslashes($dept->name_en) }}', 
                                   '{{ addslashes($dept->name_am) }}', 
                                   '{{ $college->id }}', 
                                   '{{ addslashes($dept->head_name) }}'
                               )">
                               <i class="fas fa-edit text-warning"></i>
                           </button>

                            <form action="{{ route('departments.destroy', $dept->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this department?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm p-0 text-decoration-none" title="Delete Department">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="text-muted small p-2 text-center">No departments registered.</li>
                @endforelse
            </ul>
            <button class="btn btn-sm btn-link text-primary mt-2 p-0 text-start" onclick="openAddDepartmentModal({{ $college->id }})">
                <i class="fas fa-plus-circle me-1"></i> Quick Add Dept
            </button>
        </div>
    </div>
</td>
            {{-- for college action buuton --}}
        <td>
            <div class="dropdown">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-cog"></i> Action
                </button>
                <ul class="dropdown-menu">
                    <li><button type="button" class="dropdown-item text-primary" 
                    onclick="openEditCollegeModal(
                        '{{ $college->id }}', 
                        '{{ addslashes($college->name_en) }}', 
                        '{{ addslashes($college->name_am) }}', 
                        '{{ $college->code }}', 
                        '{{ addslashes($college->dean_name) }}'
                    )">
                    <i class="fas fa-edit me-2"></i> Edit
                </button>
            </li>
                    <li>
                        <form action="{{ route('colleges.destroy', $college) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                        </form>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $colleges->links() }}
    </div>

    {{-- for deparetment and college modale paret --}}
 @include('partial.modal_dep_college')


@endsection