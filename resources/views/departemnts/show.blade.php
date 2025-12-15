@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2>ℹ️ የዲፓርትመንት ዝርዝር: {{ $department->name_en }}</h2>
    <div class="card shadow-sm">
        <div class="card-header">
            ዲፓርትመንት ID: {{ $department->id }}
        </div>
        <div class="card-body">
            <p><strong>ኮሌጅ:</strong> {{ $department->college->name_en ?? 'N/A' }}</p>
            <p><strong>የእንግሊዘኛ ስም:</strong> {{ $department->name_en }}</p>
            <p><strong>የተፈጠረበት ቀን:</strong> {{ $department->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">አስተካክል</a>
            <form action="{{ route('departments.destroy', $department) }}" method="POST" onsubmit="return confirm('እርግጠኛ ነዎት ይህን ዲፓርትመንት መሰረዝ ይፈልጋሉ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">ሰርዝ</button>
            </form>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">ወደ ዝርዝሩ ተመለስ</a>
        </div>
    </div>
</div>
@endsection