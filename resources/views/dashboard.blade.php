@extends('layouts.app')

@section('content')
<div class="container-fluid">
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

    
    @include('partial.dashbord')

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
                            <th>#</th>
                            <th class="ps-4">Type</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allSubmissions as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="ps-4">
                                @if($item instanceof \App\Models\Complaint)
                                    <span class="badge bg-danger-soft text-danger border border-danger">Complaint</span>
                                @else
                                    <span class="badge bg-success-soft text-success border border-success">Feedback</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($item->subject, 50) }}</td>
                            <td><span class="badge rounded-pill bg-info text-dark">{{ $item->status }}</span></td>
                                                <td>
                             <div class="small fw-bold text-dark">{{ $item->created_at->format('M d, Y') }}</div>
                              <div class="text-muted small" style="font-size: 0.75rem;"><i class="far fa-clock me-1"></i>{{ $item->created_at->format('h:i A') }}</div>
                              </td>
                          <td class="text-center">
                                  @php
                                   $route = $item instanceof \App\Models\Complaint ? route('show', $item->id) : route('feedback.show', $item->id);
                                      @endphp
                                 <a href="{{ $route }}" class="btn btn-sm btn-primary shadow-sm px-3">
                                    <i class="fas fa-eye me-1"></i> View Details
                                    </a>
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