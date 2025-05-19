@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Repair Request Details</h1>
        <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Back to Requests
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <span class="text-gray-500 mr-2">Status:</span>
                    @if($contact->status == 'pending')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    @elseif($contact->status == 'in-progress')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            In Progress
                        </span>
                    @elseif($contact->status == 'resolved')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Resolved
                        </span>
                    @endif
                </div>
                <div class="text-sm text-gray-500">
                    Submitted: {{ $contact->created_at->format('M d, Y g:i A') }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h2 class="text-lg font-semibold mb-2">Customer Information</h2>
                    <div class="bg-gray-50 p-4 rounded">
                        <div class="mb-2">
                            <span class="text-gray-500">Name:</span>
                            <span class="font-medium">{{ $contact->name }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500">Email:</span>
                            <a href="mailto:{{ $contact->email }}" class="text-indigo-600 hover:underline">{{ $contact->email }}</a>
                        </div>
                        <div>
                            <span class="text-gray-500">Phone:</span>
                            <a href="tel:{{ $contact->phone }}" class="text-indigo-600 hover:underline">{{ $contact->phone }}</a>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-semibold mb-2">Update Status</h2>
                    <form action="{{ route('admin.contacts.update-status', $contact) }}" method="POST" class="bg-gray-50 p-4 rounded">
                        @csrf
                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border rounded-md">
                                <option value="pending" {{ $contact->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ $contact->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $contact->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-2">Repair Request Details</h2>
                <div class="bg-gray-50 p-4 rounded whitespace-pre-wrap">
                    {{ $contact->problem }}
                </div>
            </div>

            <div class="mt-8 flex items-center space-x-4">
                <a href="tel:{{ $contact->phone }}" class="px-4 py-2 bg-green-600 text-white rounded-md flex items-center hover:bg-green-700">
                    <i class="fas fa-phone-alt mr-2"></i>
                    Call Customer
                </a>
                <a href="mailto:{{ $contact->email }}" class="px-4 py-2 bg-blue-600 text-white rounded-md flex items-center hover:bg-blue-700">
                    <i class="fas fa-envelope mr-2"></i>
                    Email Customer
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 