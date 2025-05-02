@extends('admin.layout')
@section('title', 'Categories')
@section('content')
    <div class="relative max-w-5xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-green-700">Categories</h1>
                <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-2 px-5 py-2 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition font-semibold text-lg">
                    <i class="fas fa-plus"></i> Add Category
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">{{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $category->products_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-block text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category? This will also delete all associated products.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block text-red-600 hover:text-red-900 font-semibold bg-transparent border-none cursor-pointer">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection 