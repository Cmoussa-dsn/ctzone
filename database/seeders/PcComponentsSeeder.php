<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PcComponentsSeeder extends Seeder
{
   
    public function run(): void
    {
        
        $this->call([
            ComponentCategoriesSeeder::class,
        ]);
        
        
        $processorsCategoryId = Category::where('name', 'Processors')->first()->id ?? 1;
        $motherboardsCategoryId = Category::where('name', 'Motherboards')->first()->id ?? 1;
        $graphicsCategoryId = Category::where('name', 'Graphics Cards')->first()->id ?? 1;
        $memoryCategoryId = Category::where('name', 'Memory')->first()->id ?? 1;
        $storageCategoryId = Category::where('name', 'Storage')->first()->id ?? 1;
        $powerCategoryId = Category::where('name', 'Power Supplies')->first()->id ?? 1;
        $casesCategoryId = Category::where('name', 'Cases')->first()->id ?? 1;
        $coolingCategoryId = Category::where('name', 'Cooling')->first()->id ?? 1;
        
       
        $processors = [
            [
                'name' => 'Intel Core i7 12700K',
                'category_id' => $processorsCategoryId,
                'type' => 'processors',
                'description' => 'High-performance processor with 12 cores and 20 threads.',
                'price' => 399.99,
                'stock_quantity' => 15,
                'image' => 'i99thgen.jpg',
            ],
            [
                'name' => 'AMD Ryzen 7 5800X',
                'category_id' => $processorsCategoryId,
                'type' => 'processors',
                'description' => 'Powerful 8-core, 16-thread processor for gaming and content creation.',
                'price' => 349.99,
                'stock_quantity' => 12,
                'image' => 'ryzen95900x.jpg',
            ],
        ];
        
        
        $motherboards = [
            [
                'name' => 'ASUS ROG Strix Z690-E',
                'category_id' => $motherboardsCategoryId,
                'type' => 'motherboards',
                'description' => 'Premium motherboard with advanced features for Intel processors.',
                'price' => 349.99,
                'stock_quantity' => 8,
                'image' => 'ASRock_4710483932311.jpg',
            ],
            [
                'name' => 'MSI MAG B550 Tomahawk',
                'category_id' => $motherboardsCategoryId,
                'type' => 'motherboards',
                'description' => 'Reliable motherboard with excellent performance for AMD processors.',
                'price' => 179.99,
                'stock_quantity' => 10,
                'image' => 'ASRock_4710483932311.jpg',
            ],
        ];
        
        
        $graphics = [
            [
                'name' => 'NVIDIA RTX 3080',
                'category_id' => $graphicsCategoryId,
                'type' => 'graphics',
                'description' => 'High-end graphics card with ray tracing capabilities.',
                'price' => 799.99,
                'stock_quantity' => 5,
                'image' => 'Gigabyte_889523033975.jpg',
            ],
            [
                'name' => 'AMD Radeon RX 6800 XT',
                'category_id' => $graphicsCategoryId,
                'type' => 'graphics',
                'description' => 'Powerful graphics card for gaming and content creation.',
                'price' => 649.99,
                'stock_quantity' => 7,
                'image' => 'Gigabyte_889523033975.jpg',
            ],
        ];
        
        
        $memory = [
            [
                'name' => 'Corsair Vengeance 32GB DDR4',
                'category_id' => $memoryCategoryId,
                'type' => 'memory',
                'description' => 'High-speed memory kit for smooth multitasking.',
                'price' => 149.99,
                'stock_quantity' => 20,
                'image' => 'Kingston_740617331875.jpg',
            ],
            [
                'name' => 'G.Skill Trident Z 16GB DDR4',
                'category_id' => $memoryCategoryId,
                'type' => 'memory',
                'description' => 'RGB memory kit with excellent performance.',
                'price' => 89.99,
                'stock_quantity' => 25,
                'image' => 'Kingston_740617331875.jpg',
            ],
        ];
        
       
        $storage = [
            [
                'name' => 'Samsung 970 EVO 1TB NVMe SSD',
                'category_id' => $storageCategoryId,
                'type' => 'storage',
                'description' => 'High-speed NVMe SSD for fast boot and load times.',
                'price' => 129.99,
                'stock_quantity' => 15,
                'image' => 'Addlink_4712927862406.jpg',
            ],
            [
                'name' => 'Seagate Barracuda 2TB HDD',
                'category_id' => $storageCategoryId,
                'type' => 'storage',
                'description' => 'Reliable hard drive for mass storage.',
                'price' => 59.99,
                'stock_quantity' => 22,
                'image' => 'Seagate_141412.jpg',
            ],
        ];
        
       
        $power = [
            [
                'name' => 'Corsair RM850x 850W',
                'category_id' => $powerCategoryId,
                'type' => 'power',
                'description' => 'High-quality power supply with 80+ Gold certification.',
                'price' => 129.99,
                'stock_quantity' => 12,
                'image' => 'Raidmax_719392166231.jpg',
            ],
            [
                'name' => 'EVGA SuperNOVA 750W',
                'category_id' => $powerCategoryId,
                'type' => 'power',
                'description' => 'Reliable power supply with excellent efficiency.',
                'price' => 99.99,
                'stock_quantity' => 15,
                'image' => 'Raidmax_719392166231.jpg',
            ],
        ];
        
       
        $cases = [
            [
                'name' => 'NZXT H510i Mid Tower',
                'category_id' => $casesCategoryId,
                'type' => 'cases',
                'description' => 'Elegant mid-tower case with smart features.',
                'price' => 109.99,
                'stock_quantity' => 10,
                'image' => 'Cooler Master_884102056529.jpg',
            ],
            [
                'name' => 'Corsair 4000D Airflow',
                'category_id' => $casesCategoryId,
                'type' => 'cases',
                'description' => 'Mid-tower case with optimized airflow.',
                'price' => 94.99,
                'stock_quantity' => 8,
                'image' => 'Cooler Master_884102056529.jpg',
            ],
        ];
        
        
        $cooling = [
            [
                'name' => 'Noctua NH-D15 Air Cooler',
                'category_id' => $coolingCategoryId,
                'type' => 'cooling',
                'description' => 'High-performance air cooler with quiet operation.',
                'price' => 89.99,
                'stock_quantity' => 14,
                'image' => 'TheramlTake Air Cooler.jpg',
            ],
            [
                'name' => 'Corsair H100i RGB PRO XT',
                'category_id' => $coolingCategoryId,
                'type' => 'cooling',
                'description' => 'All-in-one liquid cooler with RGB lighting.',
                'price' => 119.99,
                'stock_quantity' => 9,
                'image' => 'TheramlTake Air Cooler.jpg',
            ],
        ];
        
        
        $allComponents = array_merge(
            $processors,
            $motherboards,
            $graphics,
            $memory,
            $storage,
            $power,
            $cases,
            $cooling
        );
        
        
        foreach ($allComponents as $component) {
            
            $exists = Product::where('name', $component['name'])
                ->where('category_id', $component['category_id'])
                ->exists();
                
            if (!$exists) {
                Product::create($component);
            }
        }
    }
}
