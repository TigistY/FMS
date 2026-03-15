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
                                    <p class="small"><strong>Subject:</strong> {{ $feedback->subject }}</p>
                                    <p class="small text-muted">{{ $feedback->body }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Unit Response</h6>
                                <div class="p-3 rounded" style="background-color: #f0f7ff; min-height: 150px;">
                                    @forelse($feedback->responses as $response)
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
                
               <div class="text-center mt-3">
    <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-link text-secondary text-decoration-none">
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
                    <h5 class="mb-0 fw-bold text-dark">Feedback Details</h5>
                    <span class="badge 
                       {{ $feedback->status == 'Forwarded' ? 'bg-warning text-dark' : 
                        ($feedback->status == 'Viewed' ? 'bg-info' : 
                        ($feedback->status == 'New' ? 'bg-success' : 'bg-primary')) }} 
                           px-3">
                           {{ $feedback->status }}
                               </span>
                </div>
                <div class="card-body">
                    <h3 class="fw-bold mb-3">{{ $feedback->subject }}</h3>
                    <div class="bg-light p-4 rounded mb-4" style="min-height: 120px; white-space: pre-wrap;">{{ $feedback->body }}</div>
@if($feedback->forward_note)
    <div class="alert alert-warning border-0 shadow-sm mb-4">
        <h6 class="fw-bold text-dark"><i class="fas fa-share me-2"></i> Forwarding Note:</h6>
        <p class="mb-2 text-dark" style="font-style: italic;">"{{ $feedback->forward_note }}"</p>
        <hr class="my-2">
        <small class="text-muted">
            <strong>Forwarded by:</strong> {{ $feedback->forwarder->name ?? 'System' }} 
            <span class="mx-2">|</span>
            <strong>On:</strong> {{ $feedback->updated_at->format('M d, Y H:i') }}
        </small>
    </div>
@endif

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
                            $unitName = $responder->name; // ምንም ክፍል ካልተመደበ ስሙን ያሳያል
                        }
                    @endphp
                    <i class="fas fa-reply me-1 small"></i> {{ $unitName }}
                </span>
                            <small class="text-muted">{{ $response->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 text-dark">{{ $response->response_text }}</p>
                    </div>
                </div>
            @empty
                <div class="alert alert-light border text-center text-muted">No responses given yet.</div>
            @endforelse

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
                                <textarea name="response_body" rows="4" class="form-control @error('response_body') is-invalid @enderror" placeholder="Enter your response here..." required>{{ old('response_body') }}</textarea>
                                @error('response_body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-2">
                                    <button type="submit" class="btn btn-info text-white w-100 shadow-sm">
                                        <i class="fas fa-paper-plane me-2"></i> Submit Response
                                    </button>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-outline-warning w-100 shadow-sm" data-bs-toggle="modal" data-bs-target="#forwardModal">
                                        <i class="fas fa-share me-2"></i> Forward Feedback
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

                    <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-outline-secondary w-100">
    <i class="fas fa-arrow-left me-2"></i> Back to Feedback List
</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{--for  Forward Modal --}}
<div class="modal fade" id="forwardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('feedback.forward', $feedback->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold"><i class="fas fa-share me-2"></i> Forward Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Recipient Type</label>
                        <select id="forward_recipient_type" name="recipient_type" class="form-select" onchange="handleForwardTypeChange()" required>
                            <option value="">Select Type</option>
                            <option value="College">College</option>
                            <option value="Department">Department</option>
                            <option value="Directory">Directory</option>
                        </select>
                    </div>

                    <div id="forward_college_filter_container" class="mb-3 d-none">
                        <label class="form-label fw-bold text-primary">Select College First</label>
                        <select id="forward_filter_college_id" class="form-select border-primary" onchange="loadForwardDepartments(this.value)">
                            <option value=""> Choose College </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Unit</label>
                        <select id="forward_recipient_id" name="recipient_id" class="form-select" required disabled>
                            <option value="">Select Unit</option>
                        </select>
                        <small id="forward_loading" class="text-muted d-none"><i class="fas fa-spinner fa-spin me-1"></i></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Forwarding Message</label>
                        <textarea name="forward_note" class="form-control" rows="3" placeholder="Reason for forwarding this feedback..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning px-4 fw-bold">Confirm Forward</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
<script>
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
        collegeSelect.innerHTML = '<option value="">-- Choose College --</option>';
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