<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;

class BuildController extends Controller
{
    /**
     * Display the PC builder page
     */
    public function index()
    {
        // Get components for PC building from database
        $components = [
            'processors' => $this->getComponentsByType('processors'),
            'motherboards' => $this->getComponentsByType('motherboards'),
            'graphics' => $this->getComponentsByType('graphics'),
            'memory' => $this->getComponentsByType('memory'),
            'storage' => $this->getComponentsByType('storage'),
            'power' => $this->getComponentsByType('power'),
            'cases' => $this->getComponentsByType('cases'),
            'cooling' => $this->getComponentsByType('cooling'),
        ];
        
        return view('build.index', compact('components'));
    }
    
    /**
     * New PC Builder page with clean implementation
     */
    public function pcBuilder()
    {
        // Get components for PC building from database
        $components = [
            'processors' => $this->getComponentsByType('processors'),
            'motherboards' => $this->getComponentsByType('motherboards'),
            'graphics' => $this->getComponentsByType('graphics'),
            'memory' => $this->getComponentsByType('memory'),
            'storage' => $this->getComponentsByType('storage'),
            'power' => $this->getComponentsByType('power'),
            'cases' => $this->getComponentsByType('cases'),
            'cooling' => $this->getComponentsByType('cooling'),
        ];
        
        return view('pc-builder', compact('components'));
    }
    
    /**
     * Store a custom PC build in the cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'processor' => 'required',
            'motherboard' => 'required',
            'graphics' => 'required',
            'memory' => 'required',
            'storage' => 'required',
            'power' => 'required',
            'case' => 'required',
            'cooling' => 'required',
            'total_price' => 'required|numeric'
        ]);
        
        // First, we need to handle creating a virtual product for the custom PC build
        // Get the processor component as the base product
        $processorId = $request->processor;
        $processor = null;
        
        // Try to find the processor component in the database
        if (is_numeric($processorId)) {
            $processor = Product::find($processorId);
        }
        
        // If processor is not found or is a demo component, create a new product for the custom PC
        if (!$processor) {
            // Create a temporary product for the custom PC
            $product = Product::create([
                'name' => 'Custom PC Build',
                'category_id' => 2, // Gaming PCs category
                'description' => 'Custom built PC with selected components',
                'price' => $request->total_price,
                'stock_quantity' => 1,
                'type' => 'custom_pc',
            ]);
        } else {
            // Create a custom PC product based on the processor
            $product = Product::create([
                'name' => 'Custom PC with ' . $processor->name,
                'category_id' => 2, // Gaming PCs category
                'description' => 'Custom built PC with selected components including ' . $processor->name,
                'price' => $request->total_price,
                'stock_quantity' => 1,
                'type' => 'custom_pc',
            ]);
        }
        
        // Create a custom build ID
        $buildId = 'custom-' . time();
        
        // Store PC configuration in session
        session([
            'custom_pc' => [
                'id' => $buildId,
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $request->total_price,
                'components' => [
                    'processor' => $request->processor,
                    'motherboard' => $request->motherboard,
                    'graphics' => $request->graphics,
                    'memory' => $request->memory,
                    'storage' => $request->storage,
                    'power' => $request->power,
                    'case' => $request->case,
                    'cooling' => $request->cooling,
                ]
            ]
        ]);
        
        // Add the custom PC to the cart
        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        
        return redirect()->route('cart.index')
            ->with('success', 'Custom PC has been added to your cart!');
    }
    
    /**
     * Get components by type from the database
     * Try to find by type first, then by category name
     */
    private function getComponentsByType($type)
    {
        // Try to find components by type field
        $components = Product::where('type', $type)->get();
        
        // If no components found by type, try to find by category
        if ($components->isEmpty()) {
            // Map of type to possible category names
            $categoryMap = [
                'processors' => ['Processors', 'CPUs', 'PC Parts'],
                'motherboards' => ['Motherboards', 'PC Parts'],
                'graphics' => ['Graphics Cards', 'GPUs', 'PC Parts'],
                'memory' => ['Memory', 'RAM', 'PC Parts'],
                'storage' => ['Storage', 'SSDs', 'HDDs', 'PC Parts'],
                'power' => ['Power Supplies', 'PSUs', 'PC Parts'],
                'cases' => ['Cases', 'PC Cases', 'PC Parts'],
                'cooling' => ['Cooling', 'CPU Coolers', 'PC Parts']
            ];
            
            // Get categories that could match this component type
            $possibleCategories = $categoryMap[$type] ?? ['PC Parts'];
            
            // Find category IDs
            $categoryIds = Category::whereIn('name', $possibleCategories)->pluck('id')->toArray();
            
            if (!empty($categoryIds)) {
                $components = Product::whereIn('category_id', $categoryIds)->get();
            }
        }
        
        // If still no components found, use demo components
        if ($components->isEmpty()) {
            return $this->getDemoComponents($type);
        }
        
        return $components;
    }
    
    /**
     * Get demo components when database is empty
     * This serves as a fallback method
     */
    private function getDemoComponents($type)
    {
        $demoComponents = [
            'processors' => [
                ['id' => 'demo-cpu-1', 'name' => 'Intel Core i7 12700K', 'price' => 399.99],
                ['id' => 'demo-cpu-2', 'name' => 'AMD Ryzen 7 5800X', 'price' => 349.99],
            ],
            'motherboards' => [
                ['id' => 'demo-mb-1', 'name' => 'ASUS ROG Strix Z690-E', 'price' => 349.99],
                ['id' => 'demo-mb-2', 'name' => 'MSI MAG B550 Tomahawk', 'price' => 179.99],
            ],
            'graphics' => [
                ['id' => 'demo-gpu-1', 'name' => 'NVIDIA RTX 3080', 'price' => 799.99],
                ['id' => 'demo-gpu-2', 'name' => 'AMD Radeon RX 6800 XT', 'price' => 649.99],
            ],
            'memory' => [
                ['id' => 'demo-ram-1', 'name' => 'Corsair Vengeance 32GB DDR4', 'price' => 149.99],
                ['id' => 'demo-ram-2', 'name' => 'G.Skill Trident Z 16GB DDR4', 'price' => 89.99],
            ],
            'storage' => [
                ['id' => 'demo-ssd-1', 'name' => 'Samsung 970 EVO 1TB NVMe SSD', 'price' => 129.99],
                ['id' => 'demo-hdd-1', 'name' => 'Seagate Barracuda 2TB HDD', 'price' => 59.99],
            ],
            'power' => [
                ['id' => 'demo-psu-1', 'name' => 'Corsair RM850x 850W', 'price' => 129.99],
                ['id' => 'demo-psu-2', 'name' => 'EVGA SuperNOVA 750W', 'price' => 99.99],
            ],
            'cases' => [
                ['id' => 'demo-case-1', 'name' => 'NZXT H510i Mid Tower', 'price' => 109.99],
                ['id' => 'demo-case-2', 'name' => 'Corsair 4000D Airflow', 'price' => 94.99],
            ],
            'cooling' => [
                ['id' => 'demo-cool-1', 'name' => 'Noctua NH-D15 Air Cooler', 'price' => 89.99],
                ['id' => 'demo-cool-2', 'name' => 'Corsair H100i RGB PRO XT', 'price' => 119.99],
            ],
        ];
        
        // Convert array to collection of objects
        return collect($demoComponents[$type])->map(function($item) {
            return (object)$item;
        });
    }
} 