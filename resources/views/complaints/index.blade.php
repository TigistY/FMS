@extends('layouts.app')

@section('content')
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
<script>
$(document).ready(function() {
    let table = new DataTable('#complaints', {
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
                pageLength: {}, // for drowpdown to page
                info: {}        // for Showing
            },
            bottomEnd: 'paging' 
        }
    });
});
</script>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-list-ul me-2 text-primary"></i> Complaints List</h2>
        @if(request()->has('unit_id') || request()->has('unit_type') || request()->has('search'))
        <div>
            <a href="{{ route('admin.reports.units') }}" class="btn btn-outline-primary shadow-sm fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Back 
            </a>
        </div>
    @endif
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="complaints">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">No.</th>
                            <th>Subject</th>
                            <th>Recipient Unit</th>
                            <th>Sender</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($complaints as $key => $complaint)
                            <tr>
                                <td class="ps-4 text-muted">{{ $complaints->firstItem() + $key }}</td>
                                <td>
                                    <span class="fw-bold d-block">{{ $complaint->subject }}</span>
                                    @if($complaint->forward_note)
                                        <small class="badge bg-light text-warning border border-warning mb-1" style="font-size: 0.7rem;">
                                            <i class="fas fa-share"></i> Forwarded
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-normal">{{ $complaint->recipient_type }}</span><br>
                                    <small class="text-muted">{{ $complaint->recipient->name_en ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    @if($complaint->is_anonymous)
                                        <span class="text-muted italic"><i class="fas fa-user-secret me-1"></i> Anonymous</span>
                                    @else
                                        <span class="text-primary">{{ $complaint->user->name ?? $complaint->guest->name ?? 'Unknown' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $color = match($complaint->status) {
                                            'Resolved'    => 'success',
                                            'Pending'     => 'warning text-dark',
                                            'In Progress' => 'info text-white',
                                            'Closed'      => 'secondary',
                                            'Forwarded'   => 'warning', 
                                            'Viewed'      => 'primary',  
                                            default       => 'dark'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $color }} shadow-sm px-3 py-2">
                                        {{ $complaint->status }}
                                    </span>
                                </td>
                                <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
    <div class="dropdown">
        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cog me-1"></i> Action
        </button>
        <ul class="dropdown-menu shadow border-0">
            <li>
                <a class="dropdown-item text-primary" href="{{ route('show', $complaint->id) }}" target="_blank">
                    <i class="fas fa-eye me-2"></i> View 
                </a>
            </li>

            @if(Auth::user()->hasRole('System Administrator'))
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No complaints found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>

<style>
    .pagination .page-item:not(.active):not(:first-child):not(:last-child) { display: none !important; }
    .pagination .page-link { padding: 5px 15px !important; font-size: 14px !important; }
</style>
@endsection