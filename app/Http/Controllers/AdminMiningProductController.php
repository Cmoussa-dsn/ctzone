<?php

namespace App\Http\Controllers;

use App\Models\MiningProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiningProductController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $miningProducts = MiningProduct::paginate(15);
            return view('admin.mining.index', compact('miningProducts'));
        }
        return redirect('/')->with('error', 'Unauthorized.');
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $algorithms = [
                'SHA-256' => 'SHA-256 (Bitcoin)',
                'Ethash' => 'Ethash (Ethereum Classic)',
                'Scrypt' => 'Scrypt (Litecoin)',
                'X11' => 'X11 (Dash)',
                'RandomX' => 'RandomX (Monero)'
            ];
            return view('admin.mining.create', compact('algorithms'));
        }
        return redirect('/')->with('error', 'Unauthorized.');
    }

    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'hashrate' => 'required|string',
                'power_consumption' => 'required|numeric|min:0',
                'algorithm' => 'required|string',
                'daily_profit_estimate' => 'nullable|numeric',
                'featured' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Set featured to false if not present
            $validated['featured'] = $request->has('featured') ? true : false;

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('mining', 'public');
            }

            MiningProduct::create($validated);
            return redirect()->route('admin.mining.index')->with('success', 'Mining product created successfully.');
        }
        return redirect('/')->with('error', 'Unauthorized.');
    }

    public function edit($id)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $miningProduct = MiningProduct::findOrFail($id);
            $algorithms = [
                'SHA-256' => 'SHA-256 (Bitcoin)',
                'Ethash' => 'Ethash (Ethereum Classic)',
                'Scrypt' => 'Scrypt (Litecoin)',
                'X11' => 'X11 (Dash)',
                'RandomX' => 'RandomX (Monero)'
            ];
            return view('admin.mining.edit', compact('miningProduct', 'algorithms'));
        }
        return redirect('/')->with('error', 'Unauthorized.');
    }

    public function update(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $miningProduct = MiningProduct::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'hashrate' => 'required|string',
                'power_consumption' => 'required|numeric|min:0',
                'algorithm' => 'required|string',
                'daily_profit_estimate' => 'nullable|numeric',
                'featured' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Set featured to false if not present
            $validated['featured'] = $request->has('featured') ? true : false;

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('mining', 'public');
            }

            $miningProduct->update($validated);
            return redirect()->route('admin.mining.index')->with('success', 'Mining product updated successfully.');
        }
        return redirect('/')->with('error', 'Unauthorized.');
    }

    public function destroy($id)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $miningProduct = MiningProduct::findOrFail($id);
            $miningProduct->delete();
            return redirect()->route('admin.mining.index')->with('success', 'Mining product deleted successfully.');
        }
        return redirect('/')->with('error', 'Unauthorized.');
    }

    public function show($id)
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $miningProduct = MiningProduct::findOrFail($id);
            return view('admin.mining.show', compact('miningProduct'));
        }
        return redirect('/')->with('error', 'Unauthorized.');
    }
} 