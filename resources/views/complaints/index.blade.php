@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
       <h2>
        <i class="fas fa-list-ul me-2 text-primary"></i> 
        Complains Management For
        @if(Auth::user()->hasRole('Unit Responder'))
            <span class="text-secondary small ms-2"></span>
            <span class="text-primary ms-2" style="font-size: 30px;">
                {{ Auth::user()->department->name_en ?? Auth::user()->college->name_en ?? Auth::user()->directory->name_en ?? 'My Unit' }}
            </span>
        @endif
    </h2>
       <div class="text-center mt-3">
    <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-link text-secondary text-decoration-none">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

    </div>

    @if(Auth::user()->hasRole('System Administrator'))
    <div class="card mb-4 border-0 shadow-sm bg-white p-4">
        <form action="{{ route('index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold small">Unit Type</label>
                <select name="unit_type" id="filter_unit_type" class="form-select" onchange="handleTypeChange()">
                    <option value="">Select Type </option>
                    <option value="College" {{ request('unit_type') == 'College' ? 'selected' : '' }}>College</option>
                    <option value="Department" {{ request('unit_type') == 'Department' ? 'selected' : '' }}>Department</option>
                    <option value="Directory" {{ request('unit_type') == 'Directory' ? 'selected' : '' }}>Directorate</option>
                </select>
            </div>

            <div class="col-md-3 {{ request('unit_type') == 'Department' ? '' : 'd-none' }}" id="college_filter_div">
                <label class="form-label fw-bold small">Select College First</label>
                <select id="filter_college_id" class="form-select" onchange="loadDepts(this.value)">
                    <option value="">Choose College </option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}">{{ $college->name_en }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold small">Specific Unit</label>
                <select name="unit_id" id="filter_unit_id" class="form-select" required>
                    <option value="">Select Unit</option>
                    @if(request('unit_id'))
                        <option value="{{ request('unit_id') }}" selected>Selected Unit</option>
                    @endif
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 shadow-sm">
                    <i class="fas fa-search me-1"></i> View Complains
                </button>
            </div>
        </form>
    </div>
    @endif

    @if(request('unit_id') || !Auth::user()->hasRole('System Administrator'))
    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="complaints">
                    <thead class="bg-light">
                        <tr>
                            <th>No.</th>
                            <th>Subject</th>
                            <th>Recipient Unit</th>
                            <th>Sender</th>
                            <th>Status</th>
                            <th>Submited</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($complaints as $complaint)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-bold text-dark d-block">{{ $complaint->subject }}</span>
                                    @if($complaint->status == 'Forwarded')
                                    <small class="badge bg-light text-warning border border-warning" style="font-size: 0.65rem;">Forwarded</small>
                                @endif
                                </td>

                                <td>{{ $complaint->recipient->name_en ?? 'N/A' }}</td>
                                <td>
    @if($complaint->is_anonymous)
        <span class="text-info">Anonymous</span>
    @elseif($complaint->user)
        <span class="fw-bold">{{ $complaint->user->name }}</span> 
        <small class="text-muted">(Registerd)</small>
    @elseif($complaint->guest)
        <span class="fw-bold">{{ $complaint->guest->name }}</span> 
        <small class="text-muted">({{ ucfirst($complaint->guest->guest_type) }})</small>
    @else
        <span >Unknown</span>
    @endif
</td>
                                <td><span class="badge bg-primary">{{ $complaint->status }}</span></td>
                                <td>
                                  <div class="small fw-bold text-dark">{{ $complaint->created_at->format('M d, Y') }}</div>
                                   <div class="text-muted small" style="font-size: 0.75rem;"><i class="far fa-clock me-1"></i>{{ $complaint->created_at->format('h:i A') }}</div>
                                     </td>
                            <td class="text-end">
    @if(auth()->user()->hasRole('System Administrator') || auth()->user()->can('role-management'))
        <div class="dropdown">
            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-cog"></i> Action
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li>
                    <a class="dropdown-item text-primary" href="{{ route('show', $complaint->id) }}">
                        <i class="fas fa-eye me-2"></i> View
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @else
        <a class="btn btn-sm btn-outline-primary" href="{{ route('show', $complaint->id) }}" title="View Details">
            <i class="fas fa-eye"></i> View
        </a>
    @endif
</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5 bg-white shadow-sm rounded border">
        <i class="fas fa-filter fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">Please filter by unit to see complains.</h4>
    </div>
    @endif
</div>

@push('scripts')
<script>
    //for datatable
    $(document).ready(function() {
        if ($('#complaints').length > 0) {
            new DataTable('#complaints', {
                lengthMenu: [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
                select:true,
                ordering:true,
                pagingType: "full_numbers",
                layout: {
                    topStart: {
                        buttons: [
                                   {
                                         extend: 'colvis',
                                         className: 'btn btn-secondary btn-sm',
                                         text: '<i class="fas fa-columns"></i> Columns'
                                     },

                            { 
                                extend: 'pdf', 
                                className: 'btn btn-danger btn-sm', 
                                text: '<i class="fas fa-file-pdf"></i> PDF',
                                exportOptions: { columns: ':visible' }
                            },
                            { 
                                extend: 'print', 
                                className: 'btn btn-info btn-sm', 
                                text: '<i class="fas fa-print"></i> Print',
                                exportOptions: { columns: ':visible' }
                            },
            


                        ]

                    },
                    topEnd: 'search',
                    bottomStart: { pageLength: {}, info: {} },
                    bottomEnd: 'paging'
                }
            });
        }
    });

    // Unit Filter 
    async function handleTypeChange() {
        const type = document.getElementById('filter_unit_type').value;
        const collegeDiv = document.getElementById('college_filter_div');
        const unitSelect = document.getElementById('filter_unit_id');
        
        //unitSelect.innerHTML = '<option value=""> Loading </option>';
        
        if (type === 'Department') {
            collegeDiv.classList.remove('d-none');
            unitSelect.innerHTML = '<option value="">Select College First </option>';
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
            //unitSelect.innerHTML = '<option value="">Choose Unit </option>';
            data.forEach(item => {
                unitSelect.innerHTML += `<option value="${item.id}">${item.name_en}</option>`;
            });
        } catch (e) { console.error("Error:", e); }
    }

    async function loadDepts(collegeId) {
        if(!collegeId) return;
        await fetchUnits(`{{ url('/api/colleges') }}/${collegeId}/departments`);
    }
</script>
@endpush
@endsection