<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class ComponentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define all component categories needed for the PC builder
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
        
        // Create categories only if they don't already exist
        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
} 