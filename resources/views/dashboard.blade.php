@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Top Stats Section (Welcome & Badges) --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-8 text-center text-md-start">
            <h3 class="fw-bold text-dark mb-1">{{ __('messages.Welcome') }}, {{ Auth::user()->name }}!</h3>
            <div class="d-flex flex-wrap justify-content-center justify-content-md-start align-items-center gap-2">
                <span class="text-secondary small">{{ __('messages.Your Role') }}:</span>
                @foreach(Auth::user()->roles as $role)
                    <span class="badge rounded-pill bg-info text-dark px-3 shadow-sm">
                        <i class="fas fa-user-tag me-1 small"></i> {{ $role->name }}
                    </span>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
            <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> Date: {{ date('M d, Y') }}</span>
        </div>
    </div>

    
    @include('partial.dashbord') {{-- Assuming you keep your logic here --}}

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <a href="{{ route('create') }}" class="text-decoration-none h-100">
                <div class="card h-100 border-0 shadow-sm p-4 text-center card-hover">
                    <i class="fas fa-edit text-danger fa-3x mb-3"></i>
                    <h5 class="fw-bold text-dark">{{ __('messages.Submit Complain') }}</h5>
                    <p class="text-muted small mb-0">Report any issues or concerns here.</p>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('feedback.link') }}" class="text-decoration-none h-100">
                <div class="card h-100 border-0 shadow-sm p-4 text-center card-hover">
                    <i class="fas fa-comment-dots text-success fa-3x mb-3"></i>
                    <h5 class="fw-bold text-dark">{{ __('messages.Submit Feedback') }}</h5>
                    <p class="text-muted small mb-0">Share your thoughts about our services.</p>
                </div>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    @endif
    @if(Auth::user()->hasRole('General User'))
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white py-3"><h5 class="fw-bold mb-0">My Submissions & Responses</h5></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Type</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allSubmissions as $item)
                        <tr>
                            <td class="ps-4">
                                @if($item instanceof \App\Models\Complaint)
                                    <span class="badge bg-danger-soft text-danger border border-danger">Complaint</span>
                                @else
                                    <span class="badge bg-success-soft text-success border border-success">Feedback</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($item->subject, 50) }}</td>
                            <td><span class="badge rounded-pill bg-info text-dark">{{ $item->status }}</span></td>
                            <td class="text-center">
                                @if($item->responses->count() > 0)
                                    <button class="btn btn-sm btn-primary shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modal{{ $item->id }}">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </button>

                                    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg text-start">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title">Submission Details</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="row">
                                                        <div class="col-md-6 border-end">
                                                            <h6 class="fw-bold text-danger border-bottom pb-2">Your Original Report</h6>
                                                            <div class="p-3 bg-light rounded" style="min-height: 120px;">
                                                                <p class="small"><strong>Subject:</strong> {{ $item->subject }}</p>
                                                                <p class="small text-muted">{{ $item->body }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="fw-bold text-primary border-bottom pb-2">Unit Response</h6>
                                                            <div class="p-3 rounded" style="background-color: #f0f7ff; min-height: 120px;">
                                                                @foreach($item->responses as $response)
                                                                    <p class="small mb-1 font-italic">"{{ $response->response_text }}"</p>
                                                                    <small class="text-muted d-block text-end fw-bold">
                                                                     - by {{ $response->unit_name }}
                                                                      </small>
                                                                    <hr>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                            
                                                    @if($item instanceof \App\Models\Complaint)
                                                    <div class="mt-4 border-top pt-3">
                                                        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#forwardArea{{ $item->id }}">
                                                            <i class="fas fa-share me-1"></i> Forward to higher/other unit
                                                        </button>
                                                        
                                                        <div class="collapse mt-3" id="forwardArea{{ $item->id }}">
                                                            <form action="{{ route('complaints.forward', $item->id) }}" method="POST" class="bg-light p-3 rounded border">
                                                                @csrf
                                                                <div class="row g-2">
                                                                    <div class="col-md-6">
                                                                        <label class="small fw-bold">Receiver Type</label>
                                                                        <select name="recipient_type" class="form-select form-select-sm" onchange="handleTypeChange(this, {{ $item->id }})" required>
                                                                            <option value="">Select...</option>
                                                                            <option value="College">College</option>
                                                                            <option value="Department">Department</option>
                                                                            <option value="Directory">Directorate</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6 d-none" id="div_college_{{ $item->id }}">
                                                                        <label class="small fw-bold">College</label>
                                                                        <select class="form-select form-select-sm" onchange="loadDepartments(this.value, {{ $item->id }})">
                                                                            <option value="">Choose College</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="small fw-bold">Select Unit</label>
                                                                        <select name="recipient_id" id="unit_select_{{ $item->id }}" class="form-select form-select-sm" required>
                                                                            <option value="">Select Unit</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="small fw-bold">Reason</label>
                                                                        <textarea name="forward_note" class="form-control form-control-sm" rows="2" placeholder="Tell them why you are forwarding this..." required></textarea>
                                                                    </div>
                                                                    <div class="col-12 mt-2 text-end">
                                                                        <button type="submit" class="btn btn-danger btn-sm px-4">Forward Now</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted small fst-italic">Awaiting Response...</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-5 text-muted">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    //  Type Selection
    function handleTypeChange(select, itemId) {
        const type = select.value;
        const colDiv = document.getElementById(`div_college_${itemId}`);
        const unitSelect = document.getElementById(`unit_select_${itemId}`);
        
        unitSelect.innerHTML = '<option value="">Select Unit</option>';
        colDiv.classList.add('d-none');

        if (type === 'College') {
            fillData('{{ route("api.colleges.list") }}', unitSelect);
        } else if (type === 'Directory') {
            fillData('{{ route("api.directories.list") }}', unitSelect);
        } else if (type === 'Department') {
            colDiv.classList.remove('d-none');
            fillColleges(colDiv.querySelector('select'));
        }
    }

    // Load Colleges for filtering departments
    async function fillColleges(target) {
        const res = await fetch('{{ route("api.colleges.list") }}');
        const data = await res.json();
        target.innerHTML = '<option value="">Choose College</option>';
        data.forEach(c => target.innerHTML += `<option value="${c.id}">${c.name_en}</option>`);
    }

    // Load Departments based on college
    function loadDepartments(colId, itemId) {
        const unitSelect = document.getElementById(`unit_select_${itemId}`);
        fillData(`{{ url('/api/colleges') }}/${colId}/departments`, unitSelect);
    }

    // Helper to fetch and fill select
    async function fillData(url, target) {
        const res = await fetch(url);
        const data = await res.json();
        target.innerHTML = '<option value="">Select Unit</option>';
        data.forEach(d => target.innerHTML += `<option value="${d.id}">${d.name_en || d.name}</option>`);
    }
</script>

<style>
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.08); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.08); }
    .card-hover:hover { transform: translateY(-5px); transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endsection