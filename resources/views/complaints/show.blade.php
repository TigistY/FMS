@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4 sm:p-6 lg:p-8">
<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
<div class="p-6 border-b border-gray-200 bg-gray-50">
<h1 class="text-3xl font-bold text-gray-800 flex justify-between items-center">
<span>Complaint #{{ $complaint->id }} - {{ $complaint->subject }}</span>
<span class="text-sm font-semibold
@if($complaint->status == 'Resolved' || $complaint->status == 'Closed') text-green-600
@elseif($complaint->status == 'Pending') text-yellow-600
@else text-blue-600
@endif">
Status: {{ $complaint->status }}
</span>
</h1>
<p class="text-sm text-gray-500 mt-1">Unit: {{ $complaint->unit->name ?? 'N/A' }} | Priority: {{ $complaint->priority }}</p>
</div>

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-6 mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="p-6">
    {{-- Original Complaint Body --}}
    <div class="mb-8 p-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-md">
        <h3 class="text-xl font-semibold text-indigo-800 mb-3">Complaint Details</h3>
        <p class="text-gray-700 whitespace-pre-wrap">{{ $complaint->body }}</p>

        <div class="mt-4 text-sm text-gray-600 border-t pt-3">
            Submitter: 
            @if($complaint->is_anonymous)
                <span class="font-bold text-gray-700">Anonymous</span>
            @elseif($complaint->user_id)
                {{ $complaint->user->name ?? 'Registered User' }} ({{ $complaint->user->email ?? '' }})
            @elseif($complaint->guest_id)
                {{ $complaint->guest->name ?? 'Guest' }} ({{ $complaint->guest->email ?? '' }})
            @endif
            <p class="mt-1">Submission Date: {{ $complaint->created_at->format('M d, Y H:i') }}</p>
        </div>
    </div>

    {{-- Action Buttons (Response and Delete) --}}
    <div class="mb-6 flex justify-end space-x-3">
        @if (Auth::user()->hasRole('System Administrator') || (Auth::user()->hasRole('Unit Responder') && Auth::user()->unit_id === $complaint->unit_id))
            <a href="{{ route('respond', $complaint->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-reply me-1"></i> Respond
            </a>
        @endif
        
        @if (Auth::user()->hasRole('System Administrator'))
            <form action="{{ route('destroy', $complaint->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </form>
        @endif
    </div>


    {{-- Response History (Fetches from the 'responses' table) --}}
    <h3 class="text-xl font-semibold text-gray-800 mb-3 border-b pb-2">Response History</h3>

    @forelse ($complaint->responses as $response)
        <div class="bg-gray-100 p-4 mb-4 rounded-md shadow-sm border border-gray-200">
            <div class="flex justify-between items-center mb-2 border-b pb-1">
                <span class="text-sm font-semibold text-gray-700">
                    Responder: {{ $response->responder->name ?? 'System User' }}
                </span>
                <span class="text-xs text-gray-500">
                    Response Date: {{ $response->created_at->format('M d, Y H:i') }}
                </span>
            </div>
            <p class="text-gray-800 whitespace-pre-wrap">{{ $response->response_text }}</p>
            <div class="mt-2 text-right">
                 <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                    Status at Response Time: {{ $response->status_at_response }}
                </span>
            </div>
        </div>
    @empty
        <p class="text-gray-500 p-4 bg-gray-50 rounded-md">No responses have been provided yet.</p>
    @endforelse

</div>


        <a href="{{ route('index') }}" class="text-blue-600 hover:text-blue-800 hover:underline font-medium mt-4 block">
            ⬅️ Back to List
        </a>
</div>

</div>
@endsection