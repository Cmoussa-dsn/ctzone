@extends('admin.layout')

@section('title', 'Error')

@section('content')
<div class="w-full">
    <div class="glass p-8 rounded-xl">
        <div class="text-center">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">An Error Occurred</h2>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 text-left">
                <p class="text-red-700 font-mono">{{ $message }}</p>
            </div>
            <a href="{{ route('admin.no-middleware') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left mr-2"></i> Return to Admin
            </a>
        </div>
    </div>
</div>
@endsection 