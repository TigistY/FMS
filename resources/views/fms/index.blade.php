@extends('layouts.app')

@section('content')
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
<script>
$(document).ready(function() {
    let table = new DataTable('#feedbacks', {
        lengthMenu: [[3, 5, 10, 25, 50, -1], [3, 5, 10, 25, 50, "All"]],
        pagingType: "full_numbers",
        
        layout: {    //for button,search,paging position

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
        <h2 class="fw-bold"><i class="fas fa-list-alt text-primary me-2"></i> Feedback List</h2>
        
@if(request()->has('unit_id') || request()->has('unit_type') || request()->has('search'))
        <div>
            <a href="{{ route('admin.reports.units') }}" class="btn btn-outline-primary shadow-sm fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Back 
            </a>
        </div>
    @endif
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-start border-success border-5 card-hover-effect">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-success fw-bold">Positive</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['Positive'] }}</h3>
                    </div>
                    <i class="fas fa-smile-beam fa-2x text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-start border-info border-5 card-hover-effect">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-info fw-bold">Neutral</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['Neutral'] }}</h3>
                    </div>
                    <i class="fas fa-meh fa-2x text-info opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm border-start border-danger border-5 card-hover-effect">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-danger fw-bold">Negative</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['Negative'] }}</h3>
                    </div>
                    <i class="fas fa-frown fa-2x text-danger opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div> 

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="feedbacks">
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

@endsection