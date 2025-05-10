@extends('admin.layout')
@section('title', 'Edit Mining Product')
@section('content')
    <div class="max-w-xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold text-blue-700 mb-6">Edit Mining Product</h1>
            <form action="{{ route('admin.mining.update', $miningProduct->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $miningProduct->name) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>{{ old('description', $miningProduct->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $miningProduct->price) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $miningProduct->stock_quantity) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mining specific fields -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Algorithm</label>
                    <select name="algorithm" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select an algorithm</option>
                        @foreach($algorithms as $value => $label)
                            <option value="{{ $value }}" {{ old('algorithm', $miningProduct->algorithm) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('algorithm')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Hashrate (with unit, e.g. "100 TH/s")</label>
                    <input type="text" name="hashrate" value="{{ old('hashrate', $miningProduct->hashrate) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('hashrate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Power Consumption (watts)</label>
                    <input type="number" name="power_consumption" value="{{ old('power_consumption', $miningProduct->power_consumption) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('power_consumption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Daily Profit Estimate (USD)</label>
                    <input type="number" step="0.01" name="daily_profit_estimate" value="{{ old('daily_profit_estimate', $miningProduct->daily_profit_estimate) }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    @error('daily_profit_estimate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="flex items-center text-gray-700 font-semibold">
                        <input type="checkbox" name="featured" value="1" {{ old('featured', $miningProduct->featured) ? 'checked' : '' }} class="mr-2 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        Featured Product
                    </label>
                    @error('featured')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                    @if($miningProduct->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $miningProduct->image) }}" alt="{{ $miningProduct->name }}" class="h-32 object-cover rounded">
                        </div>
                    @endif
                    <input type="file" name="image" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Leave empty to keep the current image</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-between items-center">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Update Product</button>
                    <a href="{{ route('admin.mining.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection 