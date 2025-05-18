<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class ComponentCategoriesSeeder extends Seeder
{
    
    public function run(): void
    {
        
        $categories = [
            ['name' => 'Processors'],
            ['name' => 'Motherboards'],
            ['name' => 'Graphics Cards'],
            ['name' => 'Memory'],
            ['name' => 'Storage'],
            ['name' => 'Power Supplies'],
            ['name' => 'Cases'],
            ['name' => 'Cooling']
        ];
        
        
        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
} 