@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-list-alt text-primary me-2"></i> Feedback List</h2>
        @if(Auth::user()->hasRole('System Administrator'))
            <span class="badge bg-danger">Admin View: All Feedbacks</span>
        @else
            <span class="badge bg-info">Unit: {{ Auth::user()->college->name_en ?? Auth::user()->department->name_en ?? Auth::user()->directory->name_en ?? 'Your Unit' }}</span>
        @endif
    </div>
@if(Auth::user()->hasRole('System Administrator'))
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body bg-light">
        <form action="{{ route('feedback.index') }}" method="GET" class="row g-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Search by unit name..." 
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
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Subject</th>
                            <th>Recipient Unit</th>
                            <th>Sender</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $key => $feedback)
                        <tr>
                            <td class="ps-4 text-muted">{{ $feedbacks->firstItem() + $key }}</td>
                            <td>
                            <span class="fw-bold text-dark d-block">{{ $feedback->subject }}</span>
                                @if($feedback->status == 'Forwarded' || $feedback->forward_note)
                        <small class="badge bg-light text-warning border border-warning mt-1" style="font-size: 0.7rem;">
                          <i class="fas fa-share"></i> Forwarded
                          </small>
                            @endif
                         </td>
                            <td>
                                <small class="badge bg-secondary-subtle text-dark border">
                                    {{ $feedback->recipient_type }}: {{ $feedback->recipient->name_en ?? 'N/A' }}
                                </small>
                            </td>
                            <td>
                                @if($feedback->is_anonymous)
                                    <span class="text-muted italic"><i class="fas fa-user-secret me-1"></i> Anonymous</span>
                                @else
                                    <span class="text-primary">{{ $feedback->user->name ?? $feedback->guest->name ?? 'Unknown' }}</span>
                                @endif
                            </td>
                            <td>
    @php
        $statusColor = match($feedback->status) {
            'New'        => 'danger',             
            'Forwarded'  => 'warning text-dark',  
            'Viewed'     => 'info text-white',    
            'Responded'  => 'success',          
            default      => 'secondary'
        };
    @endphp
    <span class="badge bg-{{ $statusColor }} shadow-sm px-2 py-1">
        {{ $feedback->status }}
    </span>
</td>
                            <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('feedback.show', $feedback->id) }}" class="btn btn-sm btn-outline-primary shadow-sm">
                                    <i class="fas fa-eye me-1"></i> View
                                </a>
                                @if(Auth::user()->hasRole('System Administrator'))
                                            <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this complaint?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No feedback found for your unit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4 d-flex justify-content-center">
    {{ $feedbacks->links() }}
</div>
</div>
<style>
    
    .pagination .page-link {
        padding: 6px 16px !important;
        font-size: 14px !important;
        color: #0d6efd;
        border-radius: 4px !important;
        margin: 0 4px;
    }
</style>
<script>
    $('#search_unit_type').on('change', function() {
    let type = $(this).val();
    $('#main_search_div').addClass('d-none');
    $('#dept_search_div').addClass('d-none');
    
    if(type === 'College' || type === 'Department') {
        $('#main_label').text('ኮሌጅ ምረጥ');
        loadColleges();
        $('#main_search_div').removeClass('d-none');
    } else if(type === 'Directory') {
        $('#main_label').text('ዳይሬክቶሬት ምረጥ');
        loadDirectories();
        $('#main_search_div').removeClass('d-none');
    }
});

function loadColleges() {
    // እዚህ ጋር ኮሌጆችን በ AJAX ወይም ቀድሞ በመጣ ዳታ መሙላት ትችላለህ
}
</script>
@endsection