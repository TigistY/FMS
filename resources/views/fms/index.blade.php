@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-list-alt text-primary me-2"></i> Feedback List</h2>
        @if(Auth::user()->hasRole('System Administrator'))
            <span class="badge bg-danger">Admin View: All Feedbacks</span>
        @else
            <span class="badge bg-info">Unit: {{ Auth::user()->college->name_en ?? Auth::user()->department->name_en ?? Auth::user()->directory->name_en ?? 'Your Unit' }}</span>
        @endif
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Subject</th>
                            <th>Recipient Unit</th>
                            <th>Sender</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $key => $feedback)
                        <tr>
                            <td class="ps-4 text-muted">{{ $feedbacks->firstItem() + $key }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $feedback->subject }}</span>
                            </td>
                            <td>
                                <small class="badge bg-secondary-subtle text-dark border">
                                    {{ $feedback->recipient_type }}: {{ $feedback->recipient->name_en ?? 'N/A' }}
                                </small>
                            </td>
                            <td>
                                @if($feedback->is_anonymous)
                                    <span class="text-muted italic"><i class="fas fa-user-secret me-1"></i> Anonymous</span>
                                @else
                                    <span class="text-primary">{{ $feedback->user->name ?? $feedback->guest->name ?? 'Unknown' }}</span>
                                @endif
                            </td>
                            <td>
                                @if($feedback->responses->count() > 0)
                                    <span class="badge bg-success-subtle text-success border border-success">Responded</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('feedback.show', $feedback->id) }}" class="btn btn-sm btn-outline-primary shadow-sm">
                                    <i class="fas fa-eye me-1"></i> View
                                </a>
                                @if(Auth::user()->hasRole('System Administrator'))
                                            <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this complaint?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No feedback found for your unit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">
        {{ $feedbacks->links() }}
    </div>
</div>
@endsection