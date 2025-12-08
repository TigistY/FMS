@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4 sm:p-6 lg:p-8">
<h1 class="text-3xl font-bold text-gray-800 mb-6">Complaint Management Dashboard</h1>

@if (session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
<span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white shadow-xl rounded-lg overflow-hidden">
<div class="p-4 bg-gray-50 border-b border-gray-200">
<h2 class="text-xl font-semibold text-gray-700">
@if (Auth::user()->hasRole('System Administrator'))
 <p>Administrator View</p>
@elseif (Auth::user()->hasRole('Unit Responder'))
<p>Unit Responder View</p>
@else
Complaints You Submitted
@endif
</h2>
</div>
<div class="p-0">
    @if ($complaints->isEmpty())
        <p class="p-6 text-gray-500">No complaints found matching your access level.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitter</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($complaints as $complaint)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $complaint->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ route('show', $complaint->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                    {{ \Illuminate\Support\Str::limit($complaint->subject, 40) }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $complaint->unit->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($complaint->status == 'Resolved' || $complaint->status == 'Closed') bg-green-100 text-green-800
                                    @elseif($complaint->status == 'Pending' || $complaint->status == 'Assigned') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ $complaint->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="text-xs font-semibold
                                    @if($complaint->priority == 'Urgent' || $complaint->priority == 'High') text-red-600
                                    @elseif($complaint->priority == 'Medium') text-yellow-600
                                    @else text-green-600
                                    @endif">
                                    {{ $complaint->priority }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($complaint->is_anonymous)
                                    <span class="font-bold text-gray-700">Anonymous</span>
                                @elseif($complaint->user_id)
                                    User: {{ $complaint->user->name ?? 'ID ' . $complaint->user_id }}
                                @elseif($complaint->guest_id)
                                    Guest: {{ $complaint->guest->name ?? $complaint->guest->email ?? 'ID ' . $complaint->guest_id }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('show', $complaint->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                
                                {{-- Admin or the responsible Responder can reply --}}
                                @if (Auth::user()->hasRole('System Administrator') || (Auth::user()->hasRole('Unit Responder') && Auth::user()->unit_id === $complaint->unit_id))
                                {{-- {{ route('respond', $complaint->id) }}      --}}
                                    <a href="#" class="text-green-600 hover:text-green-900 mr-3 font-bold">Respond</a>
                                }
                                }
                                @endif

                                {{-- Only System Administrator can edit/delete --}}
                                @if (Auth::user()->hasRole('System Administrator'))
                                    <form action="{{ route('destroy', $complaint->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>


</div>

</div>
@endsection