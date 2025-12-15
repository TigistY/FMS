@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🗂️ የዳይሬክቶሬቶች ዝርዝር</h2>
        <a href="{{ route('directories.create') }}" class="btn btn-success">አዲስ ዳይሬክቶሬት ጨምር</a>
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
                        <th>የዳይሬክቶሬቱ ስም</th>
                        <th>የተፈጠረበት ቀን</th>
                        <th>እርምጃ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($directories as $directory)
                        <tr>
                            <td>{{ $directory->id }}</td>
                            <td>{{ $directory->name_en }}</td>
                            <td>{{ $directory->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('directories.show', $directory) }}" class="btn btn-sm btn-info text-white">ዝርዝር</a>
                                <a href="{{ route('directories.edit', $directory) }}" class="btn btn-sm btn-primary">አስተካክል</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">ምንም ዳይሬክቶሬት አልተመዘገበም</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection