@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Feedback Details</h5>
                    <span class="badge bg-soft-info text-info border border-info px-3">Received</span>
                </div>
                <div class="card-body">
                    <h3 class="fw-bold mb-3">{{ $feedback->subject }}</h3>
                    <div class="bg-light p-4 rounded mb-4" style="min-height: 120px; white-space: pre-wrap;">{{ $feedback->body }}</div>
                    
                    <div class="d-flex text-muted small border-top pt-3">
                        <div class="me-4"><i class="fas fa-calendar-alt me-1"></i> <strong>Submitted:</strong> {{ $feedback->created_at->format('M d, Y H:i') }}</div>
                        <div><i class="fas fa-user me-1"></i> <strong>From:</strong> {{ $feedback->is_anonymous ? 'Anonymous' : ($feedback->user->name ?? $feedback->guest->name ?? 'Guest') }}</div>
                    </div>
                </div>
            </div>

            <h5 class="mb-3 mt-5 fw-bold"><i class="fas fa-history me-2 text-secondary"></i> Response History</h5>
            @forelse($feedback->responses as $response)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold text-primary">{{ $response->responder->name }}</span>
                            <small class="text-muted">{{ $response->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 text-dark">{{ $response->response_text }}</p>
                    </div>
                </div>
            @empty
                <div class="alert alert-light border text-center text-muted">No responses given to this feedback yet.</div>
            @endforelse

            {{-- Response Form: ለ Admin ወይም ለሚመለከተው Unit Responder ብቻ --}}
            @if(Auth::user()->hasRole('System Administrator') || Auth::user()->hasRole('Unit Responder'))
                <div class="card shadow-sm border-0 mt-5 border-top border-info border-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-info fw-bold"><i class="fas fa-reply me-2"></i> Post a Response</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('feedback.processResponse', $feedback->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Response Message</label>
                                <textarea name="response_body" rows="5" class="form-control @error('response_body') is-invalid @enderror" placeholder="Enter your response here..." required>{{ old('response_body') }}</textarea>
                                @error('response_body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-info text-white px-5 shadow-sm">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Response
                                </button>
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
                        <label class="small text-muted d-block">Target Unit Type</label>
                        <span class="fw-bold">{{ $feedback->recipient_type }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Assigned To</label>
                        <span class="fw-bold text-primary">{{ $feedback->recipient->name_en ?? 'N/A' }}</span>
                    </div>
                    
                    <h6 class="text-muted small fw-bold text-uppercase border-bottom pb-2 mt-4 mb-3">Feedback Meta</h6>
                    <div class="mb-4">
                         <div class="small"><strong>ID:</strong> #FB-{{ $feedback->id }}</div>
                         <div class="small"><strong>Type:</strong> Feedback/Suggestion</div>
                    </div>

                    <a href="{{ route('feedback.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i> Back to Feedback List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection