@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16 max-w-4xl text-center">
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <div class="text-green-500 text-7xl mb-6">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h1 class="text-3xl font-bold mb-4">Request Submitted Successfully!</h1>
        
        <p class="text-gray-600 text-lg mb-8">
            Thank you for submitting your repair request. Our team will review your information and contact you soon.
        </p>
        
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200 mb-8">
            <h2 class="text-xl font-semibold mb-3 text-blue-800">What happens next?</h2>
            <ul class="text-left text-gray-700 space-y-2">
                <li class="flex items-start">
                    <i class="fas fa-phone-alt text-blue-600 mt-1 mr-2"></i>
                    <span>Our technician will call you within 24 hours to discuss your repair needs</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-calendar-check text-blue-600 mt-1 mr-2"></i>
                    <span>We'll schedule a time for you to bring in your device or arrange for pickup</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-tools text-blue-600 mt-1 mr-2"></i>
                    <span>After diagnosing the issue, we'll provide a repair quote for your approval</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-blue-600 mt-1 mr-2"></i>
                    <span>Once approved, we'll complete the repair and notify you when ready</span>
                </li>
            </ul>
        </div>
        
        <div class="flex justify-center space-x-4">
            <a href="{{ route('home') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                Return to Home
            </a>
            <a href="{{ route('buy') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                Browse Products
            </a>
        </div>
    </div>
    
    <div class="mt-8">
        <p class="text-gray-600">
            If you have any urgent questions, please call us directly at 
            <a href="tel:+96171648744" class="text-indigo-600 font-semibold">+961 71 64 87 44</a>
        </p>
    </div>
</div>
@endsection 