@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-4xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Respond to Feedback #{{ $feedback->id }}</h1>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-8 border border-indigo-200">
        <h2 class="text-xl font-semibold text-indigo-700 mb-4">Original Feedback Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
            <div>
                <p class="font-medium">Subject:</p>
                <p class="font-bold text-lg">{{ $feedback->subject }}</p>
            </div>
            <div>
                <p class="font-medium">Submitted To Unit:</p>
                <p>{{ $feedback->unit->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="font-medium">Submitted By:</p>
                <p>
                    @if($feedback->is_anonymous)
                        <span class="font-bold text-gray-700">Anonymous</span>
                    @elseif($feedback->user_id)
                        Registered User: {{ $feedback->user->name ?? 'ID ' . $feedback->user_id }}
                    @elseif($feedback->guest_id)
                        Guest: {{ $feedback->guest->name ?? $feedback->guest->email ?? 'ID ' . $feedback->guest_id }}
                    @endif
                </p>
            </div>
            <div>
                <p class="font-medium">Date Submitted:</p>
                <p>{{ $feedback->created_at->format('M d, Y H:i A') }}</p>
            </div>
        </div>
        
        <div class="mt-6 border-t pt-4">
            <p class="font-medium mb-2">Body:</p>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-gray-800">
                {{ $feedback->body }}
            </div>
        </div>
    </div>

    <!-- Response Form -->
    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 border border-green-200">
        <h2 class="text-xl font-semibold text-green-700 mb-4">Submit Official Response</h2>

        <form action="{{ route('feedback.processResponse', $feedback->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="response_body" class="block text-sm font-medium text-gray-700 mb-2">Your Response (Minimum 20 characters)</label>
                <textarea 
                    name="response_body" 
                    id="response_body" 
                    rows="8" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3 border" 
                    required>{{ old('response_body') }}</textarea>
                @error('response_body')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                >
                    Submit Response
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6">
        <a href="{{ route('feedback.show', $feedback->id) }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Feedback Details
        </a>
    </div>

</div>
@endsection