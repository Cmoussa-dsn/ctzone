@extends('admin.layout')
@section('title', 'Edit Category')
@section('content')
    <div class="max-w-xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold text-green-700 mb-6">Edit Category</h1>
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-between items-center">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">Update Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection 