<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Clear any existing data
DB::table('mining_products')->truncate();

// Insert mock data
$products = [
    [
        'name' => 'Antminer S19 Pro',
        'description' => 'The Antminer S19 Pro is a high-performance Bitcoin mining machine with exceptional hashrate and energy efficiency. Perfect for professional miners looking to maximize their returns.',
        'price' => 2899.99,
        'stock_quantity' => 15,
        'image' => 'mining/antminer-s19-pro.webp',
        'hashrate' => '110 TH/s',
        'power_consumption' => 3250,
        'algorithm' => 'SHA-256',
        'daily_profit_estimate' => 5.80,
        'featured' => true,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'NVIDIA RTX 4090 Mining Edition',
        'description' => 'Specialized mining version of the powerful NVIDIA GeForce RTX 4090. This card delivers exceptional hashrates for Ethereum and other GPU-mineable cryptocurrencies.',
        'price' => 1899.99,
        'stock_quantity' => 22,
        'image' => 'mining/rtx-4090-mining.webp',
        'hashrate' => '150 MH/s',
        'power_consumption' => 320,
        'algorithm' => 'Ethash, Kawpow, Octopus',
        'daily_profit_estimate' => 3.25,
        'featured' => true,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'WhatsMiner M50S',
        'description' => 'The WhatsMiner M50S is a Bitcoin mining machine known for its reliability and solid performance. Great for miners of all experience levels.',
        'price' => 3499.99,
        'stock_quantity' => 8,
        'image' => 'mining/whatsminer-m50s.webp',
        'hashrate' => '126 TH/s',
        'power_consumption' => 3276,
        'algorithm' => 'SHA-256',
        'daily_profit_estimate' => 6.40,
        'featured' => true,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'AMD Radeon RX 6900 XT Mining Rig',
        'description' => 'Complete 6-GPU mining rig built with AMD Radeon RX 6900 XT cards. Plug-and-play solution with all necessary components including frame, motherboard, power supplies, and risers.',
        'price' => 7499.99,
        'stock_quantity' => 5,
        'image' => 'mining/amd-mining-rig.webp',
        'hashrate' => '390 MH/s',
        'power_consumption' => 1800,
        'algorithm' => 'Ethash, Kawpow',
        'daily_profit_estimate' => 8.75,
        'featured' => true,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'Mining Rig Frame',
        'description' => 'Sturdy aluminum frame designed to hold up to 12 GPUs. Includes proper airflow design and built-in power button for convenience.',
        'price' => 159.99,
        'stock_quantity' => 30,
        'image' => 'mining/mining-frame.webp',
        'hashrate' => 'N/A',
        'power_consumption' => 0,
        'algorithm' => 'N/A',
        'daily_profit_estimate' => 0.00,
        'featured' => false,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'Bitmain Power Supply APW9+',
        'description' => 'High-efficiency power supply designed specifically for cryptocurrency mining. Supports multiple Antminer models with stable power delivery.',
        'price' => 199.99,
        'stock_quantity' => 25,
        'image' => 'mining/bitmain-psu.webp',
        'hashrate' => 'N/A',
        'power_consumption' => 0,
        'algorithm' => 'N/A',
        'daily_profit_estimate' => 0.00,
        'featured' => false,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'Immersion Cooling Kit',
        'description' => 'Complete immersion cooling solution for mining rigs. Includes tank, dielectric fluid, and pump system for optimal temperature management and increased mining efficiency.',
        'price' => 2499.99,
        'stock_quantity' => 7,
        'image' => 'mining/immersion-cooling.webp',
        'hashrate' => 'N/A',
        'power_consumption' => 200,
        'algorithm' => 'N/A',
        'daily_profit_estimate' => 0.00,
        'featured' => false,
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'name' => 'Mining Farm Setup Package',
        'description' => 'Complete starter package for a small mining farm. Includes 3 Antminer S19j Pro units, power distribution unit, shelving, and networking equipment.',
        'price' => 12999.99,
        'stock_quantity' => 3,
        'image' => 'mining/mining-farm-package.webp',
        'hashrate' => '440 TH/s',
        'power_consumption' => 13000,
        'algorithm' => 'SHA-256',
        'daily_profit_estimate' => 22.50,
        'featured' => true,
        'created_at' => now(),
        'updated_at' => now()
    ]
];

foreach ($products as $product) {
    DB::table('mining_products')->insert($product);
}

echo "Mining products imported successfully!\n"; 