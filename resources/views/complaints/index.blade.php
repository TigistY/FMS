@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2><i class="fas fa-exclamation-triangle me-2"></i> Complaints List</h2>
    <p class="text-muted">Manage all submitted complaints.</p>
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
                            <th>Status</th>
                            <th>Date Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($complaints as $complaint)
                            <tr>
                                <td>#{{ $complaint->id }}</td>
                                <td>{{ $complaint->subject }}</td>
                                <td>{{ $complaint->recipient_type }}</td>
                                <td>{{ $complaint->recipient->name_en ?? 'N/A' }}</td>
                                <td><span class="badge bg-{{ $complaint->status == 'Resolved' ? 'success' : ($complaint->status == 'Pending' ? 'warning' : 'info') }}">{{ $complaint->status }}</span></td>
                                <td>{{ $complaint->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-sm btn-primary" title="View Details"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-sm btn-info" title="Respond/Edit"><i class="fas fa-reply"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No complaints have been submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $complaints->links() }}
        </div>
    </div>
</div>
@endsection