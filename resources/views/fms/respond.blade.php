@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2>✍️ ለአስተያየት ምላሽ መስጫ</h2>
    <div class="alert alert-info">
        ለ **{{ $feedback->subject }}** አስተያየት ምላሽ እየሰጡ ነው ። ሪፖርተሩ: {{ $feedback->is_anonymous ? 'ስም የለሽ' : ($feedback->user->name ?? $feedback->guest->name) }}
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('feedback.processResponse', $feedback) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="response_body" class="form-label">የምላሽ መልእክት</label>
                    <textarea class="form-control @error('response_body') is-invalid @enderror" id="response_body" name="response_body" rows="6" required>{{ old('response_body') }}</textarea>
                    @error('response_body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- ለ Feedback status update ስለሌለ፣ Status input አያስፈልግም። --}}
                
                <button type="submit" class="btn btn-primary">ምላሽ አስቀምጥ</button>
                <a href="{{ route('feedback.show', $feedback) }}" class="btn btn-secondary">ይቅር</a>
            </form>
        </div>
    </div>
</div>
@endsection