@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2><i class="fas fa-file-alt me-2"></i> Feedback Details - #{{ $feedback->id }}</h2>
    <p class="text-muted">Detailed view of the submitted feedback.</p>
    <hr>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Feedback Summary</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Subject:</strong> {{ $feedback->subject }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Recipient:</strong> {{ $feedback->recipient_type }} ({{ $feedback->recipient->name_en ?? 'N/A' }})
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Submission Date:</strong> {{ $feedback->created_at->format('Y-m-d H:i') }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Submitted By:</strong>
                    @if ($feedback->is_anonymous)
                        <span class="text-danger">Anonymous</span>
                    @else
                        {{ $feedback->guest_name ?? 'N/A' }} ({{ $feedback->guest_email ?? 'N/A' }}, {{ $feedback->guest_type ?? 'N/A' }})
                    @endif
                </div>
                <div class="col-12">
                    <strong>Detailed Description:</strong>
                    <div class="p-3 border rounded bg-light mt-2">{{ $feedback->body }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('feedback.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Back to List</a>
    </div>
</div>
@endsection