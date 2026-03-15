@extends('layouts.app')

@section('content')
<div class="container py-5">
    @if(Auth::user()->hasRole('General User'))
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i> Submission Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 border-end">
                                <h6 class="fw-bold text-danger border-bottom pb-2">Your Original Report</h6>
                                <div class="p-3 bg-light rounded" style="min-height: 150px;">
                                    <p class="small"><strong>Subject:</strong> {{ $complaint->subject }}</p>
                                    <p class="small text-muted">{{ $complaint->body }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Unit Response</h6>
                                <div class="p-3 rounded" style="background-color: #f0f7ff; min-height: 150px;">
                                    @forelse($complaint->responses as $response)
                                        <div class="mb-3 border-bottom pb-2">
                                            <p class="small mb-1 font-italic">"{{ $response->response_text }}"</p>
                                           <small class="text-muted d-block text-end fw-bold">
                                              - by
                                              @php
                                                  $responder = $response->responder;
                                                  $unitName = '';

                                                  if ($responder->department) {
                                                      $unitName = $responder->department->name_en;
                                                  } elseif ($responder->college) {
                                                      $unitName = $responder->college->name_en;
                                                  } elseif ($responder->directory) {
                                                      $unitName = $responder->directory->name_en;
                                                  } else {
                                                      $unitName = $responder->name;
                                                  }
                                              @endphp
    
                                              {{ $unitName }} ({{ $response->created_at->diffForHumans() }})
                                          </small>
                                        </div>
                                    @empty
                                        <p class="text-muted small text-center mt-4">No response from the unit yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($complaint->responses->count() > 0)
                    <div class="alert alert-warning border-0 shadow-sm d-flex justify-content-between align-items-center">
                        <div class="text-dark">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Not satisfied?</strong> You can forward this to a higher office.
                        </div>
                        <button class="btn btn-warning btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#userForwardModal">
                            <i class="fas fa-share-alt me-1"></i> Forward Case
                        </button>
                    </div>
                @endif
                
                <div class="text-center mt-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-link text-secondary text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Back 
                    </a>
                </div>
            </div>
        </div>

    @else
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Complaint Details</h5>
                    <span class="badge 
    {{ $complaint->status == 'Forwarded' ? 'bg-warning text-dark' : 
       ($complaint->status == 'Viewed' ? 'bg-info' : 
       ($complaint->status == 'Pending' ? 'bg-success' : 'bg-primary')) }} 
    px-3">
    {{ $complaint->status }}
</span>
                </div>
                <div class="card-body">
                    <h3 class="fw-bold mb-3">{{ $complaint->subject }}</h3>
                    <div class="bg-light p-4 rounded mb-4" style="min-height: 120px; white-space: pre-wrap;">{{ $complaint->body }}</div>
                    
    @if($complaint->forward_note)
    <div class="alert alert-warning border-0 shadow-sm mb-4">
        <h6 class="fw-bold text-dark"><i class="fas fa-share me-2"></i> Forwarding Note:</h6>
        <p class="mb-2 text-dark" style="font-style: italic;">"{{ $complaint->forward_note }}"</p>
        <hr class="my-2">
        <small class="text-muted">
            <strong>Forwarded by:</strong> {{ $complaint->forwarder->name ?? 'System' }} 
            <span class="mx-2">|</span>
            <strong>On:</strong> {{ $complaint->updated_at->format('M d, Y H:i') }}
        </small>
    </div>
@endif
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
                            <span class="fw-bold text-primary">
                    @php
                        $responder = $response->responder;
                        $unitName = '';

                        if ($responder->department) {
                            $unitName = $responder->department->name_en;
                        } elseif ($responder->college) {
                            $unitName = $responder->college->name_en;
                        } elseif ($responder->directory) {
                            $unitName = $responder->directory->name_en;
                        } else {
                            $unitName = $responder->name;
                        }
                    @endphp
                    <i class="fas fa-reply me-1 small"></i> {{ $unitName }}
                </span>
                            <small class="text-muted">{{ $response->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 text-dark">{{ $response->response_text }}</p>
                        <span class="badge bg-light text-dark border fw-normal small">Status: {{ $response->status_at_response }}</span>
                    </div>
                </div>
            @empty
                <div class="alert alert-light border text-center text-muted">No responses yet.</div>
            @endforelse

            @if(Auth::user()->hasRole('System Administrator') || Auth::user()->hasRole('Unit Responder'))
                <div class="card shadow-sm border-0 mt-5 border-top border-primary border-4">
                    <div class="card-body">
                        <form action="{{ route('processResponse', $complaint->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Official Response Message</label>
                                <textarea name="response_body" rows="4" class="form-control" placeholder="Provide details..." required></textarea>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Update Status</label>
                                    <select name="status" class="form-select">
                                        <option value="In Progress" {{ $complaint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Resolved" {{ $complaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="Closed" {{ $complaint->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Priority</label>
                                    <select name="priority" class="form-select">
                                        <option value="Neutral" {{ $complaint->priority == 'Neutral' ? 'selected' : '' }}>Neutral</option>
                                        <option value="Low" {{ $complaint->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Medium" {{ $complaint->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="High" {{ $complaint->priority == 'High' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 text-end">
                                    <button type="submit" class="btn btn-primary w-100 mb-2"><i class="fas fa-paper-plane me-2"></i> Submit Response</button>
                                    <button type="button" class="btn btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#forwardModal">
                                        <i class="fas fa-share me-1"></i> Forward Case
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div> <div class="col-lg-4">
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
                    
                    <h6 class="text-muted small fw-bold text-uppercase border-bottom pb-2 mt-4 mb-3">Urgency</h6>
                     <div class="mb-4">
                         @if($complaint->priority == 'High')
                             <span class="badge bg-danger px-3 py-2 w-100"><i class="fas fa-exclamation-triangle me-2">                     </i> High</span>
                         @elseif($complaint->priority == 'Medium')
                             <span class="badge bg-warning text-dark px-3 py-2 w-100"><i class="fas fa-clock me-2"></i> Medium</span>
                         @elseif($complaint->priority == 'Neutral')
                             <span class="badge bg-secondary px-3 py-2 w-100"><i class="fas fa-dot-circle me-2"></i> Neutral</span>
                         @else
                             <span class="badge bg-info px-3 py-2 w-100"><i class="fas fa-info-circle me-2"></i> Low</span>
                         @endif
                     </div>

                    <a href="{{ route('index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>
        </div> 
    </div> 
    @endif
</div> 

@if(Auth::user()->hasRole('General User'))
    @include('partial.user_forward_modal') 
@else
    @include('partial.forward_modal') 
@endif

<script>
    //for user
    async function handleUserTypeChange() {
    const type = document.getElementById('user_recipient_type').value;
    const collegeFilter = document.getElementById('user_college_filter');
    const idSelect = document.getElementById('user_recipient_id');
    const collegeSelect = document.getElementById('user_filter_college');

    idSelect.innerHTML = '<option value="">Select Unit</option>';
    idSelect.disabled = true;
    collegeFilter.classList.add('d-none');

    if (type === 'College') {
        fillUserUnits('{{ route('api.colleges.list') }}');
    } else if (type === 'Directory') {
        fillUserUnits('{{ route('api.directories.list') }}');
    } else if (type === 'Department') {
        collegeFilter.classList.remove('d-none');
        const resp = await fetch('{{ route('api.colleges.list') }}');
        const colleges = await resp.json();
        collegeSelect.innerHTML = '<option value=""> Choose College</option>';
        colleges.forEach(c => collegeSelect.innerHTML += `<option value="${c.id}">${c.name_en}</option>`);
    }
}

async function loadUserDepartments(collegeId) {
    if (!collegeId) return;
    fillUserUnits(`{{ url('/api/colleges') }}/${collegeId}/departments`);
}

async function fillUserUnits(url) {
    const idSelect = document.getElementById('user_recipient_id');
    idSelect.disabled = true;
    try {
        const response = await fetch(url);
        const data = await response.json();
        idSelect.innerHTML = '<option value="">Select Unit</option>';
        data.forEach(item => idSelect.innerHTML += `<option value="${item.id}">${item.name_en}</option>`);
        idSelect.disabled = false;
    } catch (e) { console.error(e); }
}

// for admin and unit responder
async function handleForwardTypeChange() {
    const type = document.getElementById('forward_recipient_type').value;
    const collegeFilter = document.getElementById('forward_college_filter_container');
    const idSelect = document.getElementById('forward_recipient_id');
    const collegeSelect = document.getElementById('forward_filter_college_id');

    idSelect.innerHTML = '<option value="">Select Unit</option>';
    idSelect.disabled = true;
    collegeFilter.classList.add('d-none');

    if (type === 'College') {
        fillForwardUnits('{{ route('api.colleges.list') }}');
    } else if (type === 'Directory') {
        fillForwardUnits('{{ route('api.directories.list') }}');
    } else if (type === 'Department') {
        collegeFilter.classList.remove('d-none');
        const resp = await fetch('{{ route('api.colleges.list') }}');
        const colleges = await resp.json();
        collegeSelect.innerHTML = '<option value=""> Choose College </option>';
        colleges.forEach(c => {
            collegeSelect.innerHTML += `<option value="${c.id}">${c.name_en}</option>`;
        });
    }
}

async function loadForwardDepartments(collegeId) {
    if (!collegeId) return;
    fillForwardUnits(`{{ url('/api/colleges') }}/${collegeId}/departments`);
}

async function fillForwardUnits(url) {
    const idSelect = document.getElementById('forward_recipient_id');
    const loader = document.getElementById('forward_loading');
    idSelect.disabled = true;
    loader.classList.remove('d-none');
    try {
        const response = await fetch(url);
        const data = await response.json();
        idSelect.innerHTML = '<option value="">Select Unit</option>';
        data.forEach(item => {
            idSelect.innerHTML += `<option value="${item.id}">${item.name_en}</option>`;
        });
        idSelect.disabled = false;
    } catch (e) { console.error(e); }
    loader.classList.add('d-none');
}
</script>
@endsection