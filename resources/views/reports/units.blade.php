@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <h5 class="mb-3 fw-bold text-dark"><i class="fas fa-chart-line me-2 text-primary small"></i>Unit-based Overview</h5>

    <div class="row g-3">
      
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-2 px-3 d-flex justify-content-between align-items-center">
            <span class="fw-bold small">Colleges and Departments Detail Analysis</span>
            <div class="d-flex gap-4 small fw-bold">
                <span title="Sentiment Feedback Analysis"><i class="fas fa-comments me-1"></i> Feedback</span>
                <span title="Total Complaints"><i class="fas fa-exclamation-circle me-1"></i> Complains</span>
            </div>
        </div>
                <div class="card-body p-2">
                    <div class="accordion" id="collegeAccordion">
                        @foreach($collegeData as $college)
                        <div class="accordion-item mb-1 border rounded">
                            <h2 class="accordion-header d-flex align-items-center bg-white px-2">
                                <div class="flex-grow-1 py-2 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapse{{$college['id']}}" style="cursor: pointer; font-size: 0.85rem;">
                                    <i class="fas fa-chevron-right me-1 small text-muted" style="font-size: 0.7rem;"></i>
                                    <span class="fw-bold text-dark">{{ $college['name'] }}</span> 
                                </div>
                                
                                <div class="d-flex gap-1 align-items-center">
                                    <a href="{{ route('feedback.index', ['unit_type' => 'College', 'unit_id' => $college['id'], 'feedback_type' => 'Positive']) }}" class="badge bg-success text-decoration-none rounded-pill p-1 px-2" title="View Positive Feedbacks" style="font-size: 0.7rem;">
                                        <i class="fas fa-smile"></i> {{ $college['sentiment']['Positive'] }}
                                    </a>
                                    <a href="{{ route('feedback.index', ['unit_type' => 'College', 'unit_id' => $college['id'], 'feedback_type' => 'Neutral']) }}" class="badge bg-warning text-dark text-decoration-none rounded-pill p-1 px-2" title="View Neutral Feedbacks" style="font-size: 0.7rem;">
                                        <i class="fas fa-meh"></i> {{ $college['sentiment']['Neutral'] }}
                                    </a>
                                    <a href="{{ route('feedback.index', ['unit_type' => 'College', 'unit_id' => $college['id'], 'feedback_type' => 'Negative']) }}" class="badge bg-danger text-decoration-none rounded-pill p-1 px-2" title="View Negative Feedbacks" style="font-size: 0.7rem;">
                                        <i class="fas fa-frown"></i> {{ $college['sentiment']['Negative'] }}
                                    </a>
                                    <a href="{{ route('index', ['unit_type' => 'College', 'unit_id' => $college['id']]) }}" class="badge bg-light text-dark border ms-1 text-decoration-none shadow-xs" title="View Complaints" style="font-size: 0.65rem;">
                                        {{ $college['complaints_count'] }} <small>Comp.</small>
                                    </a>
                                </div>
                            </h2>

                            <div id="collapse{{$college['id']}}" class="accordion-collapse collapse" data-bs-parent="#collegeAccordion">
                                <div class="accordion-body p-0 border-top">
                                    <table class="table table-hover mb-0" style="font-size: 0.75rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-3 py-1">Department Name</th>
                                                <th class="text-center py-1">Sentiment Details</th>
                                                <th class="text-center py-1">Complaints</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($college['departments'] as $dept)
                                            <tr>
                                                <td class="ps-3 py-1 fw-bold">{{ $dept['name'] }}</td>
                                                <td class="text-center py-1">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('feedback.index', ['unit_type' => 'Department', 'unit_id' => $dept['id'], 'feedback_type' => 'Positive']) }}" class="text-success text-decoration-none fw-bold" title="View Positive Feedbacks">
                                                            <i class="fas fa-smile"></i> {{ $dept['sentiment']['Positive'] }}
                                                        </a>
                                                        <a href="{{ route('feedback.index', ['unit_type' => 'Department', 'unit_id' => $dept['id'], 'feedback_type' => 'Neutral']) }}" class="text-warning text-decoration-none fw-bold" title="View Neutral Feedbacks">
                                                            <i class="fas fa-meh"></i> {{ $dept['sentiment']['Neutral'] }}
                                                        </a>
                                                        <a href="{{ route('feedback.index', ['unit_type' => 'Department', 'unit_id' => $dept['id'], 'feedback_type' => 'Negative']) }}" class="text-danger text-decoration-none fw-bold" title="View Negative Feedbacks">
                                                            <i class="fas fa-frown"></i> {{ $dept['sentiment']['Negative'] }}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="text-center py-1">
                                                    <a href="{{ route('index', ['unit_type' => 'Department', 'unit_id' => $dept['id']]) }}" class="badge bg-danger text-decoration-none shadow-xs" style="font-size: 0.65rem;">
                                                        {{ $dept['complaints_count'] }}
                                                    </a>
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
                <div class="card-header bg-dark text-white py-2 px-3 fw-bold small">Directorate Overview</div>
                <div class="list-group list-group-flush shadow-xs">
                    @foreach($directoryData as $dir)
                    <div class="list-group-item py-2 px-3">
                        <div class="fw-bold text-dark mb-1" style="font-size: 0.8rem;">{{ $dir['name'] }}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <a href="{{ route('feedback.index', ['unit_type' => 'Directory', 'unit_id' => $dir['id'], 'feedback_type' => 'Positive']) }}" class="text-success text-decoration-none fw-bold small" title="View Positive Feedbacks">
                                    <i class="fas fa-smile"></i> {{ $dir['sentiment']['Positive'] }}
                                </a>
                                <a href="{{ route('feedback.index', ['unit_type' => 'Directory', 'unit_id' => $dir['id'], 'feedback_type' => 'Neutral']) }}" class="text-warning text-decoration-none fw-bold small text-dark" title="View Neutral Feedbacks">
                                    <i class="fas fa-meh"></i> {{ $dir['sentiment']['Neutral'] }}
                                </a>
                                <a href="{{ route('feedback.index', ['unit_type' => 'Directory', 'unit_id' => $dir['id'], 'feedback_type' => 'Negative']) }}" class="text-danger text-decoration-none fw-bold small" title="View Negative Feedbacks">
                                    <i class="fas fa-frown"></i> {{ $dir['sentiment']['Negative'] }}
                                </a>
                            </div>
                            <a href="{{ route('index', ['unit_type' => 'Directory', 'unit_id' => $dir['id']]) }}" class="badge bg-danger text-decoration-none shadow-xs" title="View Complaints" style="font-size: 0.65rem;">
                                {{ $dir['complaints_count'] }} Comp.
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
    .cursor-pointer:hover { background-color: #fbfbfb; }
    .accordion-header .badge:hover { transform: scale(1.05); transition: 0.2s; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.03); }
    .table-hover tbody tr:hover { background-color: #fafafa; }
</style>
@endsection