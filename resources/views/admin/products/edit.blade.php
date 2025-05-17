@extends('admin.layout')
@section('title', 'Edit Product')
@section('content')
    <div class="max-w-xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold text-green-700 mb-6">Edit Product</h1>
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Category</label>
                    <select name="category_id" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Type (for PC Builder)</label>
                    <select name="type" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500">
                        <option value="">Not a PC component</option>
                        <option value="processors" {{ old('type', $product->type) == 'processors' ? 'selected' : '' }}>Processor (CPU)</option>
                        <option value="motherboards" {{ old('type', $product->type) == 'motherboards' ? 'selected' : '' }}>Motherboard</option>
                        <option value="graphics" {{ old('type', $product->type) == 'graphics' ? 'selected' : '' }}>Graphics Card (GPU)</option>
                        <option value="memory" {{ old('type', $product->type) == 'memory' ? 'selected' : '' }}>Memory (RAM)</option>
                        <option value="storage" {{ old('type', $product->type) == 'storage' ? 'selected' : '' }}>Storage (SSD/HDD)</option>
                        <option value="power" {{ old('type', $product->type) == 'power' ? 'selected' : '' }}>Power Supply (PSU)</option>
                        <option value="cases" {{ old('type', $product->type) == 'cases' ? 'selected' : '' }}>PC Case</option>
                        <option value="cooling" {{ old('type', $product->type) == 'cooling' ? 'selected' : '' }}>Cooling</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Select a component type if this product should appear in the PC Builder</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                    @if($product->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-24 object-cover rounded">
                        </div>
                    @endif
                    <input type="file" name="image" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-between items-center">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection 