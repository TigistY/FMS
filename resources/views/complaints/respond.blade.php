@extends('layouts.app') {{-- Assumed layout --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white">
                    <h2 class="mb-0">
                        <i class="fas fa-reply me-2"></i> Response & Status Adjustment
                    </h2>
                </div>
                <div class="card-body">

                    <div class="alert alert-info border-0 mb-4">
                        <h4 class="alert-heading">Complaint ID: #{{ $complaint->id }}</h4>
                        <p class="mb-1">Subject: <strong>{{ $complaint->subject }}</strong></p>
                        <p class="mb-1">Submitted by: <strong>{{ $complaint->is_anonymous ? 'Anonymous User' : ($complaint->guest_name ?? 'Guest User') }}</strong></p>
                        <p class="mb-0">Current Status: <span class="badge bg-warning">{{ $complaint->status }}</span></p>
                    </div>

                    <h4 class="border-bottom pb-2 mb-3 mt-4">Complaint Body</h4>
                    <div class="p-3 mb-4 border rounded bg-light">
                        {{ $complaint->body }}
                    </div>

                    {{-- Form for Response and Status Update --}}
                    <form action="{{ route('complaints.update_response', $complaint->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h4 class="border-bottom pb-2 mb-3 mt-4">Update Status and Respond</h4>

                        <div class="mb-3">
                            <label for="status" class="form-label">Update Status:</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Pending" {{ $complaint->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $complaint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ $complaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="Closed" {{ $complaint->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="response_body" class="form-label">Your Official Response (Optional):</label>
                            <textarea id="response_body" name="response_body" rows="6"
                                class="form-control @error('response_body') is-invalid @enderror"
                                placeholder="Type your official response to the complaint here. This will be sent to the complainant if they provided an email.">{{ old('response_body') }}</textarea>
                            @error('response_body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Note: Only non-anonymous complainants who provided an email will receive this response.</div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2">
                            <i class="fas fa-save me-2"></i> Save Status and Send Response
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection