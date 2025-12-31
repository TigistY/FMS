@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Complaint Details</h5>
                    <span class="badge bg-soft-primary text-primary border border-primary px-3">{{ $complaint->status }}</span>
                </div>
                <div class="card-body">
                    <h3 class="fw-bold mb-3">{{ $complaint->subject }}</h3>
                    <div class="bg-light p-4 rounded mb-4" style="min-height: 120px; white-space: pre-wrap;">{{ $complaint->body }}</div>
                    
                    <div class="d-flex text-muted small border-top pt-3">
                        <div class="me-4"><i class="fas fa-calendar-alt me-1"></i> <strong>Submitted:</strong> {{ $complaint->created_at->format('M d, Y H:i') }}</div>
                        <div><i class="fas fa-user me-1"></i> <strong>From:</strong> {{ $complaint->is_anonymous ? 'Anonymous' : ($complaint->user->name ?? $complaint->guest->name ?? 'Guest') }}</div>
                    </div>
                </div>
            </div>

            <h5 class="mb-3 mt-5 fw-bold"><i class="fas fa-history me-2 text-secondary"></i> Response History</h5>
            @forelse($complaint->responses as $response)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold text-primary">{{ $response->responder->name }}</span>
                            <small class="text-muted">{{ $response->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 text-dark">{{ $response->response_text }}</p>
                        <span class="badge bg-light text-dark border fw-normal small">Status updated to: {{ $response->status_at_response }}</span>
                    </div>
                </div>
            @empty
                <div class="alert alert-light border text-center text-muted">No responses yet.</div>
            @endforelse

            @if(Auth::user()->hasRole('System Administrator') || Auth::user()->hasRole('Unit Responder'))
                <div class="card shadow-sm border-0 mt-5 border-top border-primary border-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-reply me-2"></i> Submit Response</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('processResponse', $complaint->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Official Response Message</label>
                                <textarea name="response_body" rows="5" class="form-control @error('response_body') is-invalid @enderror" placeholder="Provide details on action taken..." required>{{ old('response_body') }}</textarea>
                                @error('response_body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Update Case Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="In Progress" {{ $complaint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Resolved" {{ $complaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="Closed" {{ $complaint->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
        <label class="form-label fw-bold">Set Priority Level</label>
        <select name="priority" class="form-select border-warning" required>
            <option value="Low" {{ $complaint->priority == 'Low' ? 'selected' : '' }}>Low Level</option>
            <option value="Medium" {{ $complaint->priority == 'Medium' ? 'selected' : '' }}>Medium Level</option>
            <option value="High" {{ $complaint->priority == 'High' ? 'selected' : '' }}>High - Urgent</option>
        </select>
    </div>
                                <div class="col-md-6 mb-3 text-end">
                                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                        <i class="fas fa-paper-plane me-2"></i> Submit & Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h6 class="text-muted small fw-bold text-uppercase border-bottom pb-2 mb-3">Unit Information</h6>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Recipient Type</label>
                        <span class="fw-bold">{{ $complaint->recipient_type }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Assigned To</label>
                        <span class="fw-bold">{{ $complaint->recipient->name_en ?? 'N/A' }}</span>
                    </div>
                    
                   
                    <h6 class="text-muted small fw-bold text-uppercase border-bottom pb-2 mt-4 mb-3">Urgency | ቅድሚያ የሚሰጠው</h6>
                      <div class="mb-4">
                        @if($complaint->priority == 'High')
                     <span class="badge bg-danger px-3 py-2 w-100"><i class="fas fa-exclamation-triangle me-2"></i> High Priority</span>
                   @elseif($complaint->priority == 'Medium')
                       <span class="badge bg-warning text-dark px-3 py-2 w-100"><i class="fas fa-clock me-2"></i> Medium Priority</span>
                 @else
                    <span class="badge bg-info px-3 py-2 w-100"><i class="fas fa-info-circle me-2"></i> Low Priority</span>
                 @endif
</div>

                    <a href="{{ route('index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i> Back to All Complaints
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection