@extends('admin.layout')
@section('title', 'Add Product')
@section('content')
    <div class="max-w-xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold text-green-700 mb-6">Add New Product</h1>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Category</label>
                    <select name="category_id" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                        <option value="processors" {{ old('type') == 'processors' ? 'selected' : '' }}>Processor (CPU)</option>
                        <option value="motherboards" {{ old('type') == 'motherboards' ? 'selected' : '' }}>Motherboard</option>
                        <option value="graphics" {{ old('type') == 'graphics' ? 'selected' : '' }}>Graphics Card (GPU)</option>
                        <option value="memory" {{ old('type') == 'memory' ? 'selected' : '' }}>Memory (RAM)</option>
                        <option value="storage" {{ old('type') == 'storage' ? 'selected' : '' }}>Storage (SSD/HDD)</option>
                        <option value="power" {{ old('type') == 'power' ? 'selected' : '' }}>Power Supply (PSU)</option>
                        <option value="cases" {{ old('type') == 'cases' ? 'selected' : '' }}>PC Case</option>
                        <option value="cooling" {{ old('type') == 'cooling' ? 'selected' : '' }}>Cooling</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Select a component type if this product should appear in the PC Builder</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                    <input type="file" name="image" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-green-500 focus:border-green-500">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-between items-center">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">Add Product</button>
                    <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection 