@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4 fw-bold text-dark"><i class="fas fa-chart-line me-2 text-primary"></i>Unit-based Overview</h4>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">Colleges and Departments</div>
                <div class="card-body p-3">
                    <div class="accordion" id="collegeAccordion">
                        @foreach($collegeData as $college)
                        <div class="accordion-item mb-2 border rounded">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$college['id']}}">
                                    <div class="d-flex justify-content-between w-100 me-3 align-items-center">
                                        <span class="fw-bold text-dark">{{ $college['name'] }}</span> 
                                        <div>
                                            <span class="badge bg-danger ms-2">{{ $college['complaints_count'] }} Complaints</span>
                                            <span class="badge bg-success ms-1">{{ $college['feedback_count'] }} Feedback</span>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{$college['id']}}" class="accordion-collapse collapse" data-bs-parent="#collegeAccordion">
                                <div class="accordion-body p-0">
                                    <table class="table table-hover mb-0 small">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-3">Department Name</th>
                                                <th class="text-center">Complaints</th>
                                                <th class="text-center">Feedback</th>
                                                <th class="text-end pe-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($college['departments'] as $dept)
                                            <tr>
                                                <td class="ps-3 fw-bold">{{ $dept['name'] }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('index', ['unit_type' => 'Department', 'unit_id' => $dept['id']]) }}" class="text-decoration-none">
                                                        <span class="badge bg-danger shadow-sm px-2">{{ $dept['complaints_count'] }}</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('feedback.index', ['unit_type' => 'Department', 'unit_id' => $dept['id']]) }}" class="text-decoration-none">
                                                        <span class="badge bg-success shadow-sm px-2">{{ $dept['feedback_count'] }}</span>
                                                    </a>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <small class="text-muted italic" style="font-size: 0.7rem;">Click numbers to view</small>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold">Directories Overview</div>
                <div class="list-group list-group-flush">
                    @foreach($directoryData as $dir)
                    <div class="list-group-item py-3 border-bottom">
                        <div class="fw-bold text-dark mb-2">{{ $dir['name'] }}</div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('index', ['unit_type' => 'Directory', 'unit_id' => $dir['id']]) }}" class="flex-fill text-decoration-none transition-hover">
                                <div class="bg-light p-2 rounded text-center border-start border-danger border-4 shadow-sm h-100">
                                    <div class="small text-muted" style="font-size: 0.7rem;">Complaints</div>
                                    <div class="fw-bold text-danger">{{ $dir['complaints_count'] }}</div>
                                </div>
                            </a>
                            
                            <a href="{{ route('feedback.index', ['unit_type' => 'Directory', 'unit_id' => $dir['id']]) }}" class="flex-fill text-decoration-none transition-hover">
                                <div class="bg-light p-2 rounded text-center border-start border-success border-4 shadow-sm h-100">
                                    <div class="small text-muted" style="font-size: 0.7rem;">Feedback</div>
                                    <div class="fw-bold text-success">{{ $dir['feedback_count'] }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover:hover .bg-light {
        background-color: #f0f0f0 !important;
        transform: translateY(-2px);
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection