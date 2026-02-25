@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-list-ul me-2 text-primary"></i> Complaints Management</h2>
       <div class="text-center mt-3">
    <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-link text-secondary text-decoration-none">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

    </div>

    {{-- this for Filter Form  --}}
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
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($complaints as $complaint)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $complaint->subject }}</strong></td>
                                <td>{{ $complaint->recipient->name_en ?? 'N/A' }}</td>
                                <td>{{ $complaint->is_anonymous ? 'Anonymous' : ($complaint->user->name ?? 'Guest') }}</td>
                                <td><span class="badge bg-primary">{{ $complaint->status }}</span></td>
                                <td class="text-end">
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
                                 @if(auth()->user()->hasRole('System Administrator') || auth()->user()->can('role-management'))
                               <li><hr class="dropdown-divider"></li>
                                <li>
                                <form action="{{ route('destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5 bg-white shadow-sm rounded border">
        <i class="fas fa-filter fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">Please filter by unit to see complaints.</h4>
    </div>
    @endif
</div>

@push('scripts')
<script>
    //for datatable
    $(document).ready(function() {
        if ($('#complaints').length > 0) {
            new DataTable('#complaints', {
                lengthMenu: [[3, 5, 10, 25, 50, -1], [3, 5, 10, 25, 50, "All"]],
                pagingType: "full_numbers",
                layout: {
                    topStart: {
                        buttons: [
                            { extend: 'pdf', className: 'btn btn-danger btn-sm', text: '<i class="fas fa-file-pdf"></i> PDF' },
                            { extend: 'print', className: 'btn btn-info btn-sm', text: '<i class="fas fa-print"></i> Print' }
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