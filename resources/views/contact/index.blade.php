@php
use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold mb-2">Computer Repair Request</h1>
        <p class="text-gray-600">Fill out the form below to submit a repair request. Our team will contact you as soon as possible.</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-medium mb-2">Your Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', Auth::user() ? Auth::user()->name : '') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', Auth::user() ? Auth::user()->email : '') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    required>
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="problem" class="block text-gray-700 font-medium mb-2">Describe Your Problem</label>
                <textarea name="problem" id="problem" rows="5" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                    required>{{ old('problem') }}</textarea>
                @error('problem')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-center">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition duration-200">
                    Submit Repair Request
                </button>
            </div>
        </form>
    </div>
    
    <div class="mt-10 text-center">
        <h2 class="text-2xl font-bold mb-4">Our Repair Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-indigo-600 text-4xl mb-4">
                    <i class="fas fa-laptop-medical"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Computer Diagnostics</h3>
                <p class="text-gray-600">We'll identify and fix hardware or software issues affecting your computer.</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-indigo-600 text-4xl mb-4">
                    <i class="fas fa-shield-virus"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Virus Removal</h3>
                <p class="text-gray-600">We'll clean your system of malware and set up better protection.</p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-indigo-600 text-4xl mb-4">
                    <i class="fas fa-memory"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Hardware Upgrades</h3>
                <p class="text-gray-600">We can upgrade your RAM, storage, and other components to improve performance.</p>
            </div>
        </div>
    </div>
</div>
@endsection 