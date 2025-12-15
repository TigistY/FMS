@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2><i class="fas fa-file-alt me-2"></i> Complaint Details - #{{ $complaint->id }}</h2>
    <p class="text-muted">Detailed view of the submitted complaint.</p>
    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Complaint Summary</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Subject:</strong> {{ $complaint->subject }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong> <span class="badge bg-{{ $complaint->status == 'Resolved' ? 'success' : ($complaint->status == 'Pending' ? 'warning' : 'info') }}">{{ $complaint->status }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Recipient:</strong> {{ $complaint->recipient_type }} ({{ $complaint->recipient->name_en ?? 'N/A' }})
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Submission Date:</strong> {{ $complaint->created_at->format('Y-m-d H:i') }}
                </div>
                <div class="col-12 mb-3">
                    <strong>Submitted By:</strong>
                    @if ($complaint->is_anonymous)
                        <span class="text-danger">Anonymous</span>
                    @else
                        {{ $complaint->guest_name ?? 'N/A' }} ({{ $complaint->guest_email ?? 'N/A' }}, {{ $complaint->guest_type ?? 'N/A' }})
                    @endif
                </div>
                <div class="col-12">
                    <strong>Detailed Description:</strong>
                    <div class="p-3 border rounded bg-light mt-2">{{ $complaint->body }}</div>
                </div>
            </div>
        </div>
    </div>

    @if ($complaint->response_body)
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Official Response</h4>
        </div>
        <div class="card-body">
            <p><strong>Response Date:</strong> {{ $complaint->response_date ? \Carbon\Carbon::parse($complaint->response_date)->format('Y-m-d H:i') : 'N/A' }}</p>
            <div class="p-3 border rounded bg-light mt-2">{{ $complaint->response_body }}</div>
        </div>
    </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('complaints.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Back to List</a>
        <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-info"><i class="fas fa-edit me-2"></i> Edit/Respond</a>
    </div>
</div>
@endsection