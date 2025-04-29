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
        // Get demo components for PC building
        $components = [
            'processors' => $this->getDemoComponents('processors'),
            'motherboards' => $this->getDemoComponents('motherboards'),
            'graphics' => $this->getDemoComponents('graphics'),
            'memory' => $this->getDemoComponents('memory'),
            'storage' => $this->getDemoComponents('storage'),
            'power' => $this->getDemoComponents('power'),
            'cases' => $this->getDemoComponents('cases'),
            'cooling' => $this->getDemoComponents('cooling'),
        ];
        
        return view('build.index', compact('components'));
    }
    
    /**
     * New PC Builder page with clean implementation
     */
    public function pcBuilder()
    {
        // Get demo components for PC building
        $components = [
            'processors' => $this->getDemoComponents('processors'),
            'motherboards' => $this->getDemoComponents('motherboards'),
            'graphics' => $this->getDemoComponents('graphics'),
            'memory' => $this->getDemoComponents('memory'),
            'storage' => $this->getDemoComponents('storage'),
            'power' => $this->getDemoComponents('power'),
            'cases' => $this->getDemoComponents('cases'),
            'cooling' => $this->getDemoComponents('cooling'),
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
        
        // Create a custom build ID
        $buildId = 'custom-' . time();
        
        // Store PC configuration in session
        session([
            'custom_pc' => [
                'id' => $buildId,
                'name' => 'Custom PC Build',
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
        
        return redirect()->route('cart.index')
            ->with('success', 'Custom PC has been added to your cart!');
    }
    
    /**
     * Get demo components when database is empty
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