@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-list-alt text-primary me-2"></i> Feedbacks Management</h2>
        
       <div class="text-center mt-3">
    <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-link text-secondary text-decoration-none">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>
    </div>

    {{--for  Filter Form --}}
    @if(Auth::user()->hasRole('System Administrator'))
    <div class="card mb-4 border-0 shadow-sm bg-white p-4">
        <form action="{{ route('feedback.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold small">Unit Type</label>
                <select name="unit_type" id="filter_unit_type" class="form-select" onchange="handleTypeChange()">
                    <option value="">Select Type </option>
                    <option value="College" {{ request('unit_type') == 'College' ? 'selected' : '' }}>College</option>
                    <option value="Department" {{ request('unit_type') == 'Department' ? 'selected' : '' }}>Department</option>
                    <option value="Directory" {{ request('unit_type') == 'Directory' ? 'selected' : '' }}>Directorate</option>
                </select>
            </div>

            <div class="col-md-3 d-none" id="college_filter_div">
                <label class="form-label fw-bold small">Select College First</label>
                <select id="filter_college_id" class="form-select" onchange="loadDepts(this.value)">
                    <option value="">Choose College</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}">{{ $college->name_en }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold small">Specific Unit</label>
                <select name="unit_id" id="filter_unit_id" class="form-select" required>
                    <option value="">Select Unit</option>
                    @if(request('unit_id'))
                        <option value="{{ request('unit_id') }}" selected>Currently Selected</option>
                    @endif
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold small">Feedback Type</label>
                <select name="feedback_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="Positive" {{ request('feedback_type') == 'Positive' ? 'selected' : '' }}>Positive</option>
                    <option value="Negative" {{ request('feedback_type') == 'Negative' ? 'selected' : '' }}>Negative</option>
                    <option value="Neutral" {{ request('feedback_type') == 'Neutral' ? 'selected' : '' }}>Neutral</option>
                </select>
            </div>

            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100 p-2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-success border-5">
                <div class="card-body">
                    <h6 class="text-success fw-bold small">Positive</h6>
                    <h3 class="fw-bold mb-0 text-success">{{ $stats['Positive'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-info border-5">
                <div class="card-body">
                    <h6 class="text-info fw-bold small">Neutral</h6>
                    <h3 class="fw-bold mb-0 text-info">{{ $stats['Neutral'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-danger border-5">
                <div class="card-body">
                    <h6 class="text-danger fw-bold small">Negative</h6>
                    <h3 class="fw-bold mb-0 text-danger">{{ $stats['Negative'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    @if(request('unit_id') || !Auth::user()->hasRole('System Administrator'))
    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <table class="table table-hover mb-0" id="feedbacks">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Recipient</th>
                        <th>Sender</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-bold d-block">{{ $feedback->subject }}</span>
                            <small class="badge bg-light text-muted border" style="font-size: 0.7rem;">{{ $feedback->feedback_type }}</small>
                        </td>
                        <td>{{ $feedback->recipient->name_en ?? 'N/A' }}</td>
                        <td>{{ $feedback->is_anonymous ? 'Anonymous' : ($feedback->user->name ?? 'Guest') }}</td>
                        <td><span class="badge bg-primary">{{ $feedback->status }}</span></td>
                        <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
    <div class="dropdown">
        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cog"></i> Action
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            {{-- ሁሉም ሰው ማየት ይችላል --}}
            <li>
                <a class="dropdown-item text-primary" href="{{ route('feedback.show', $feedback->id) }}">
                    <i class="fas fa-eye me-2"></i> View
                </a>
            </li>

            {{-- Admin ብቻ እንዲያየው - በፐርሚሽን ወይም በሮል --}}
            @if(auth()->user()->hasRole('System Administrator') || auth()->user()->can('role-management'))
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
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
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#feedbacks').length > 0) {
            let table = new DataTable('#feedbacks', {
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                pagingType: "full_numbers",
                responsive: true,
                language: {
                    emptyTable: "No feedback found matching your search."
                },
                layout: {
                    topStart: {
                        buttons: [
                            { extend: 'pdf', className: 'btn btn-danger btn-sm', text: '<i class="fas fa-file-pdf"></i> PDF' },
                            { extend: 'print', className: 'btn btn-info btn-sm', text: '<i class="fas fa-print"></i> Print' }
                        ]
                    },
                    topEnd: 'search',
                    bottomStart: {
                        pageLength: {}, 
                        info: {}        
                    },
                    bottomEnd: 'paging' 
                }
            });
        }
    });

    // Filtering Logic
    async function handleTypeChange() {
        const type = document.getElementById('filter_unit_type').value;
        const collegeDiv = document.getElementById('college_filter_div');
        const unitSelect = document.getElementById('filter_unit_id');
        
        //unitSelect.innerHTML = '<option value="">Loading...</option>';
        if (type === 'Department') {
            collegeDiv.classList.remove('d-none');
            unitSelect.innerHTML = '<option value="">Select College First</option>';
        } else {
            collegeDiv.classList.add('d-none');
            const url = type === 'College' ? '{{ route("api.colleges.list") }}' : '{{ route("api.directories.list") }}';
            await fetchUnits(url);
        }
    }

    async function fetchUnits(url) {
        try {
            const response = await fetch(url);
            const data = await response.json();
            const unitSelect = document.getElementById('filter_unit_id');
            unitSelect.innerHTML = '<option value="">Choose Unit</option>';
            data.forEach(item => {
                unitSelect.innerHTML += `<option value="${item.id}">${item.name_en}</option>`;
            });
        } catch (e) { console.error("Fetch Error:", e); }
    }

    async function loadDepts(collegeId) {
        if(!collegeId) return;
        await fetchUnits(`{{ url('/api/colleges') }}/${collegeId}/departments`);
    }
</script>
@endpush
@endsection