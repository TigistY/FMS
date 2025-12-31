@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-list-ul me-2 text-primary"></i> Complaints List</h2>
        
            @if(Auth::user()->hasRole('System Administrator'))
            <span class="badge bg-danger">Admin View: All complaints</span>
        @else
            <span class="badge bg-info">Unit: {{ Auth::user()->college->name_en ?? Auth::user()->department->name_en ?? Auth::user()->directory->name_en ?? 'Your Unit' }}</span>
        @endif

        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Subject</th>
                            <th>Recipient Unit</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($complaints as $complaint)
                            <tr>
                                <td class="ps-4">#{{ $complaint->id }}</td>
                                <td>
                                    <span class="fw-bold d-block">{{ $complaint->subject }}</span>
                                    <small class="text-muted">By: {{ $complaint->is_anonymous ? 'Anonymous' : ($complaint->user->name ?? $complaint->guest->name ?? 'Guest') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-normal">{{ $complaint->recipient_type }}</span><br>
                                    <small>{{ $complaint->recipient->name_en ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    @php
                                        $color = match($complaint->status) {
                                            'Resolved' => 'success',
                                            'Pending' => 'warning',
                                            'In Progress' => 'info',
                                            'Closed' => 'secondary',
                                            default => 'primary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $complaint->status }}</span>
                                </td>
                                <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('show', $complaint->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i> View
                                        </a>

                                        @if(Auth::user()->hasRole('System Administrator'))
                                            <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this complaint?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">No complaints found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $complaints->links() }}
        </div>
    </div>
</div>
@endsection