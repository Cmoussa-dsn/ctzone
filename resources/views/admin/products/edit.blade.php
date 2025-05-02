@extends('admin.layout')
@section('title', 'Edit Product')
@section('content')
    <div class="max-w-xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold text-green-700 mb-6">Edit Product</h1>
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Category</label>
                    <select name="category_id" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-between items-center">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection 