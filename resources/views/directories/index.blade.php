@extends('layouts.app')

@section('content')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
<script>
$(document).ready(function() {
    let table = new DataTable('#directories', {
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
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-folder-open me-2"></i> Directorate Management</h2>
    <button type="button" class="btn btn-success" onclick="openAddDirectoryModal()">
        <i class="fas fa-plus"></i> Add New Directorate
    </button>
</div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0" id="directories">
                <thead>
                    <tr>
                        <th class="ps-3">Code</th>
                        <th>Name (EN)</th>
                        <th>Manager</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($directories as $directory)
                        <tr>
                            <td class="ps-3"><span class="badge bg-secondary">{{ $directory->code }}</span></td>
                            <td>
                                <strong>{{ $directory->name_en }}</strong><br>
                                <small class="text-muted">{{ $directory->name_am }}</small>
                            </td>
                            <td>{{ $directory->manager_name ?? 'Not Assigned' }}</td>
                            <td class="text-center">
                       <div class="dropdown">
                           <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                               <i class="fas fa-cog"></i> Action
                           </button>
                           <ul class="dropdown-menu shadow">

                               <li>
                                   <button class="dropdown-item text-info" onclick="openViewDirectoryModal({{ json_encode($directory) }})">
                                       <i class="fas fa-eye me-2"></i> View
                                   </button>
                               </li>
        
                               <li>
                                   <button class="dropdown-item text-primary" onclick="openEditDirectoryModal({{ json_encode($directory) }})">
                                       <i class="fas fa-edit me-2"></i> Edit
                                  </button>
                              </li>
                              <li><hr class="dropdown-divider"></li>
        
                              <li>
                                  <form action="{{ route('directories.destroy', $directory) }}" method="POST" onsubmit="return confirm('Delete this directory?');">
                                      @csrf @method('DELETE')
                                      <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                                  </form>
                              </li>
                          </ul>
                      </div>
                  </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No directorate found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('partial.modal_directorate')
@endsection