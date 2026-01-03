@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-list-ul me-2 text-primary"></i> Complaints List</h2>
        
            @if(Auth::user()->hasRole('System Administrator'))
                <span class="badge bg-danger">Admin View: All complaints</span>
            @else
                <span class="badge bg-info">Unit: {{ Auth::user()->college->name_en ?? Auth::user()->department->name_en ?? Auth::user()->directory->name_en ?? 'Your Unit' }}</span>
            @endif
        </div>
    </div>
@if(Auth::user()->hasRole('System Administrator'))
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body bg-light">
        <form action="{{ route('index') }}" method="GET" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Search by unit name or subject..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>
@endif

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
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
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('show', $complaint->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i> View
                                        </a>

                                        @if(Auth::user()->hasRole('System Administrator'))
                                            <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
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
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $complaints->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .pagination .page-item:not(.active):not(:first-child):not(:last-child) { display: none !important; }
    .pagination .page-link { padding: 5px 15px !important; font-size: 14px !important; }
</style>

<script>
$(document).ready(function() {
    $('#unit_type_select').on('change', function() {
        let type = $(this).val();
        $('#main_unit_div, #dept_unit_div').addClass('d-none');
        $('#main_unit_list, #dept_unit_list').empty().append('<option value="">-- ምረጥ --</option>');
        $('#target_unit_id').val('');

        if (type === 'College' || type === 'Department') {
            $.get("{{ route('api.colleges.list') }}", function(data) {
                $.each(data, function(key, value) {
                    $('#main_unit_list').append('<option value="' + value.id + '">' + value.name_en + '</option>');
                });
                $('#main_unit_div').removeClass('d-none');
            });
        } else if (type === 'Directory') {
            $.get("{{ route('api.directories.list') }}", function(data) {
                $.each(data, function(key, value) {
                    $('#main_unit_list').append('<option value="' + value.id + '">' + value.name_en + '</option>');
                });
                $('#main_unit_div').removeClass('d-none');
            });
        }
    });

    $('#main_unit_list').on('change', function() {
        let id = $(this).val();
        let type = $('#unit_type_select').val();
        if (type === 'Department' && id) {
            $.get("/api/colleges/" + id + "/departments", function(data) {
                $('#dept_unit_list').empty().append('<option value="">-- ዲፓርትመንት ምረጥ --</option>');
                $.each(data, function(key, value) {
                    $('#dept_unit_list').append('<option value="' + value.id + '">' + value.name_en + '</option>');
                });
                $('#dept_unit_div').removeClass('d-none');
            });
        } else {
            $('#target_unit_id').val(id);
        }
    });

    $('#dept_unit_list').on('change', function() {
        $('#target_unit_id').val($(this).val());
    });
});
</script>
@endsection