@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🏛️ የዲፓርትመንቶች ዝርዝር</h2>
        <a href="{{ route('departments.create') }}" class="btn btn-success">አዲስ ዲፓርትመንት ጨምር</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>የዲፓርትመንት ስም</th>
                        <th>ኮሌጅ</th>
                        <th>እርምጃ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $department)
                        <tr>
                            <td>{{ $department->id }}</td>
                            <td>{{ $department->name_en }}</td>
                            <td>{{ $department->college->name_en ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-info text-white">ዝርዝር</a>
                                <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-primary">አስተካክል</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">ምንም ዲፓርትመንት አልተመዘገበም</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection