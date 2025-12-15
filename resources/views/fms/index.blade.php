@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2><i class="fas fa-comment-dots me-2"></i> Feedback List</h2>
    <p class="text-muted">Manage all submitted suggestions, appreciations, and advice.</p>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Recipient Type</th>
                            <th>Recipient Unit</th>
                            <th>Date Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feedbacks as $feedback)
                            <tr>
                                <td>#{{ $feedback->id }}</td>
                                <td>{{ $feedback->subject }}</td>
                                <td>{{ $feedback->recipient_type }}</td>
                                <td>{{ $feedback->recipient->name_en ?? 'N/A' }}</td>
                                <td>{{ $feedback->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('feedback.show', $feedback->id) }}" class="btn btn-sm btn-primary" title="View Details"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No feedback has been submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $feedbacks->links() }}
        </div>
    </div>
</div>
@endsection