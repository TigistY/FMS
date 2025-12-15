@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2>ℹ️ የኮሌጅ ዝርዝር: {{ $college->name_en }}</h2>
    <div class="card shadow-sm">
        <div class="card-header">
            ኮሌጅ ID: {{ $college->id }}
        </div>
        <div class="card-body">
            <p><strong>የእንግሊዘኛ ስም:</strong> {{ $college->name_en }}</p>
            <p><strong>የአማርኛ ስም:</strong> {{ $college->name_am ?? 'N/A' }}</p>
            <p><strong>የተፈጠረበት ቀን:</strong> {{ $college->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('colleges.edit', $college) }}" class="btn btn-primary">አስተካክል</a>
            <form action="{{ route('colleges.destroy', $college) }}" method="POST" onsubmit="return confirm('እርግጠኛ ነዎት ይህን ኮሌጅ መሰረዝ ይፈልጋሉ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">ሰርዝ</button>
            </form>
            <a href="{{ route('colleges.index') }}" class="btn btn-secondary">ወደ ዝርዝሩ ተመለስ</a>
        </div>
    </div>
</div>
@endsection