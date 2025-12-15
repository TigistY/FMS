@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-building me-2"></i> College Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('colleges.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Add New College
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>College Name</th>
                    <th>የኮሌጁ ስም </th>
                    <th>Code</th>
                    <th>Dean Name</th>
                    <th>Departments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colleges as $college)
                    <tr>
                        <td>{{ $colleges->firstItem() + $loop->index }}</td>
                        <td>{{ $college->name_en }}</td>
                        <td>{{ $college->name_am }}</td>
                        <td>{{ $college->code }}</td>
                        <td>{{ $college->dean_name ?? 'N/A' }}</td>
                        <td>{{ $college->departments->count() }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cog"></i> Action
                                </button>
                                <ul class="dropdown-menu">
                                    {{-- Edit College --}}
                                    <li><a class="dropdown-item text-primary" href="{{ route('colleges.edit', $college) }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                    {{-- Delete College --}}
                                    <li>
                                        <form action="{{ route('colleges.destroy', $college) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this college? All related departments will also be deleted!');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $colleges->links() }}
    </div>
@endsection