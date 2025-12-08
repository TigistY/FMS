@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4 sm:p-6 lg:p-8">
<div class="max-w-3xl mx-auto bg-white shadow-xl rounded-lg">
<div class="p-6 border-b border-gray-200 bg-gray-50">
<h1 class="text-2xl font-bold text-gray-800">Respond to Complaint</h1>
<p class="text-sm text-gray-500">Responding to Complaint #{{ $complaint->id }}: {{ $complaint->subject }}</p>
</div>

<form action="{{ route('processResponse', $complaint->id) }}" method="POST" class="p-6">
    @csrf

    {{-- Complaint Summary --}}
    <div class="mb-6 p-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-md">
        <h3 class="text-lg font-semibold text-indigo-800 mb-2">Complaint Summary</h3>
        <p class="text-gray-700 whitespace-pre-wrap text-sm">{{ \Illuminate\Support\Str::limit($complaint->body, 300) }}</p>
        <p class="text-xs mt-2 text-indigo-600">View Full Complaint: <a href="{{ route('show', $complaint->id) }}" class="underline">Click Here</a></p>
    </div>

    {{-- Response Body --}}
    <div class="mb-4">
        <label for="response_body" class="block text-sm font-medium text-gray-700 mb-1">Your Response <span class="text-red-500">*</span></label>
        <textarea id="response_body" name="response_body" rows="8" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter your detailed response here...">{{ old('response_body') }}</textarea>
        @error('response_body')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    {{-- Status Update --}}
    <div class="mb-6">
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Update Complaint Status <span class="text-red-500">*</span></label>
        <select id="status" name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            {{-- All users who can respond can update the status --}}
            @php
                $statuses = ['Pending', 'Assigned', 'In Progress', 'Resolved', 'Closed'];
            @endphp
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ old('status', $complaint->status) == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
        @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('show', $complaint->id) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
            Cancel
        </a>
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Submit Response
        </button>
    </div>
</form>


</div>

</div>
@endsection