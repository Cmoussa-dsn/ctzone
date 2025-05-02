@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="glass p-10 rounded-2xl shadow-lg text-center mb-8">
            <h1 class="text-4xl font-extrabold mb-2 text-green-700">Welcome, Admin!</h1>
            <p class="text-gray-600 mb-4">You have successfully accessed the admin area.</p>
            <div class="flex justify-center gap-8 mt-8">
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mb-2">
                        <i class="fas fa-box text-2xl text-green-600"></i>
                    </div>
                    <div class="text-lg font-bold text-gray-800">Products</div>
                    <div class="text-green-700 font-bold text-xl">{{ \App\Models\Product::count() }}</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center mb-2">
                        <i class="fas fa-tags text-2xl text-indigo-600"></i>
                    </div>
                    <div class="text-lg font-bold text-gray-800">Categories</div>
                    <div class="text-indigo-700 font-bold text-xl">{{ \App\Models\Category::count() }}</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center mb-2">
                        <i class="fas fa-users text-2xl text-gray-600"></i>
                    </div>
                    <div class="text-lg font-bold text-gray-800">Users</div>
                    <div class="text-gray-700 font-bold text-xl">{{ \App\Models\User::count() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection 