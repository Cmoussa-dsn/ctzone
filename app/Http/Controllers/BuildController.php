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
    
    public function index()
    {
       
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
    
    
    public function pcBuilder()
    {
       
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
        
        
        $processorId = $request->processor;
        $processor = null;
        
       
        if (is_numeric($processorId)) {
            $processor = Product::find($processorId);
        }
        
        
        if (!$processor) {
            
            $product = Product::create([
                'name' => 'Custom PC Build',
                'category_id' => 2, 
                'description' => 'Custom built PC with selected components',
                'price' => $request->total_price,
                'stock_quantity' => 1,
                'type' => 'custom_pc',
            ]);
        } else {
           
            $product = Product::create([
                'name' => 'Custom PC with ' . $processor->name,
                'category_id' => 2, 
                'description' => 'Custom built PC with selected components including ' . $processor->name,
                'price' => $request->total_price,
                'stock_quantity' => 1,
                'type' => 'custom_pc',
            ]);
        }
        
        
        $buildId = 'custom-' . time();
        
        
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
        
        
        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        
        return redirect()->route('cart.index')
            ->with('success', 'Custom PC has been added to your cart!');
    }
    
    
    private function getComponentsByType($type)
    {
        
        Log::debug("Fetching components of type: " . $type);
        
        $components = Product::where('type', $type)->get();
        
        
        Log::debug("Query executed: " . Product::where('type', $type)->toSql());
        
        
        Log::debug("Found " . $components->count() . " components with type: " . $type);
        
       
        if ($components->isEmpty()) {
            
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
            
            $possibleCategories = $categoryMap[$type] ?? ['PC Parts'];
            Log::debug("Looking by categories: " . implode(", ", $possibleCategories));
            
            $categoryIds = Category::whereIn('name', $possibleCategories)->pluck('id')->toArray();
            Log::debug("Found category IDs: " . implode(", ", $categoryIds));
            
            if (!empty($categoryIds)) {
                
                $components = Product::whereIn('category_id', $categoryIds)
                                    ->where(function($query) {
                                        $query->whereNull('type')
                                            ->orWhere('type', '');
                                    })
                                    ->get();
                Log::debug("Found " . $components->count() . " components by category");
            }
        }
        
        //  return demo data eza ma l2ina comps
        if ($components->isEmpty()) {
            Log::debug("No components found, returning demo data");
            return $this->getDemoComponents($type);
        }
        
        // 
        foreach($components as $component) {
            Log::debug("Component: {$component->id} - {$component->name} - Type: {$component->type}");
        }
        
        return $components;
    }
    
    
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
        
        
        return collect($demoComponents[$type])->map(function($item) {
            return (object)$item;
        });
    }
} 