<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {

        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
        
        
        User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

       
        $categories = [
            ['name' => 'PC Parts'],
            ['name' => 'Gaming PCs'],
            ['name' => 'Office PCs'],
            ['name' => 'Monitors'],
            ['name' => 'Accessories'],
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
        
       
        $products = [
            [
                'name' => 'Gaming PC Pro',
                'category_id' => 2,
                'description' => 'High-end gaming PC with latest graphics card and processor.',
                'price' => 1499.99,
                'stock_quantity' => 10,
                'image' => 'gaming-pc-1.jpg',
            ],
            [
                'name' => 'Office PC Basic',
                'category_id' => 3,
                'description' => 'Reliable PC for everyday office tasks and productivity.',
                'price' => 699.99,
                'stock_quantity' => 15,
                'image' => 'office-pc-1.jpg',
            ],
            [
                'name' => 'RTX 4080 Graphics Card',
                'category_id' => 1,
                'description' => 'Latest generation graphics card for high-performance gaming.',
                'price' => 899.99,
                'stock_quantity' => 5,
                'image' => 'gpu-1.jpg',
            ],
            [
                'name' => 'Intel Core i9 Processor',
                'category_id' => 1,
                'description' => 'Powerful CPU for gaming and professional workloads.',
                'price' => 499.99,
                'stock_quantity' => 8,
                'image' => 'cpu-1.jpg',
            ],
            [
                'name' => '32GB RAM Kit',
                'category_id' => 1,
                'description' => 'High-speed memory kit for smooth multitasking.',
                'price' => 149.99,
                'stock_quantity' => 20,
                'image' => 'ram-1.jpg',
            ],
            [
                'name' => '4K Gaming Monitor',
                'category_id' => 4,
                'description' => 'Ultra HD monitor with high refresh rate for gaming.',
                'price' => 399.99,
                'stock_quantity' => 12,
                'image' => 'monitor-1.jpg',
            ],
            [
                'name' => 'RGB Mechanical Keyboard',
                'category_id' => 5,
                'description' => 'Customizable mechanical keyboard with RGB lighting.',
                'price' => 89.99,
                'stock_quantity' => 30,
                'image' => 'keyboard-1.jpg',
            ],
            [
                'name' => 'Gaming Mouse',
                'category_id' => 5,
                'description' => 'High-precision gaming mouse with programmable buttons.',
                'price' => 59.99,
                'stock_quantity' => 25,
                'image' => 'mouse-1.jpg',
            ],
        ];
        
        foreach ($products as $product) {
            Product::create($product);
        }

        
        $this->call([
            ComponentCategoriesSeeder::class,
            PcComponentsSeeder::class,
        ]);
    }
} 