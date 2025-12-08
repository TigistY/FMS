@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Complaint: #{{ $complaint->id }} 🛠️</h1>
    
    <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="bg-white shadow-xl rounded-lg p-6 md:p-8 mb-4 border-l-4 border-blue-600">
        @csrf
        @method('PUT') {{-- Use PUT method for updating the resource --}}

        <h2 class="text-xl font-semibold text-blue-600 mb-4 border-b pb-2">Administrative Actions</h2>

        {{-- Priority --}}
        <div class="mb-4">
            <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Priority *</label>
            <select name="priority" id="priority" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('priority') border-red-500 @enderror">
                @foreach ($priorities as $priority)
                    <option value="{{ $priority }}" {{ old('priority', $complaint->priority) == $priority ? 'selected' : '' }}>
                        {{ $priority }}
                    </option>
                @endforeach
            </select>
            @error('priority') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>
        
        {{-- Status --}}
        <div class="mb-6">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status *</label>
            <select name="status" id="status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ old('status', $complaint->status) == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
            @error('status') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <hr class="my-6 border-gray-300">
        
        <h2 class="text-xl font-semibold text-gray-600 mb-4 border-b pb-2">Complaint Details</h2>
        
        {{-- Subject --}}
        <div class="mb-4">
            <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject *</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject', $complaint->subject) }}" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror">
            @error('subject') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>
        
        {{-- Body --}}
        <div class="mb-6">
            <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Detailed Body *</label>
            <textarea name="body" id="body" rows="6" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('body') border-red-500 @enderror">{{ old('body', $complaint->body) }}</textarea>
            @error('body') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-between">
            <button type="submit" class="px-6 py-2 text-white font-semibold rounded-lg shadow-md bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                Save Changes
            </button>
            <a href="{{ route('complaints.show', $complaint) }}" class="px-6 py-2 text-white font-semibold rounded-lg shadow-md bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection