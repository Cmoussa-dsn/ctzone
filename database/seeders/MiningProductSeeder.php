<?php

namespace Database\Seeders;

use App\Models\MiningProduct;
use Illuminate\Database\Seeder;

class MiningProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $miningProducts = [
            [
                'name' => 'Antminer S19 Pro',
                'description' => 'The Antminer S19 Pro is a high-performance Bitcoin mining ASIC manufactured by Bitmain. It offers excellent hashrate and energy efficiency for Bitcoin mining operations.',
                'price' => 2899.99,
                'stock_quantity' => 15,
                'image' => 'mining/antminer-s19-pro.webp',
                'hashrate' => '110 TH/s',
                'power_consumption' => 3250,
                'algorithm' => 'SHA-256',
                'daily_profit_estimate' => 5.75,
                'featured' => true
            ],
            [
                'name' => 'NVIDIA RTX 4090 Mining Edition',
                'description' => 'Specialized mining version of the powerful NVIDIA RTX 4090 GPU, optimized for cryptocurrency mining with enhanced cooling and power delivery.',
                'price' => 1899.99,
                'stock_quantity' => 22,
                'image' => 'mining/rtx-4090-mining.webp',
                'hashrate' => '150 MH/s',
                'power_consumption' => 320,
                'algorithm' => 'Ethash',
                'daily_profit_estimate' => 3.45,
                'featured' => true
            ],
            [
                'name' => 'WhatsMiner M50S',
                'description' => 'The WhatsMiner M50S is a Bitcoin mining machine known for its high efficiency and reliability. Perfect for professional mining operations.',
                'price' => 3499.99,
                'stock_quantity' => 8,
                'image' => 'mining/whatsminer-m50s.webp',
                'hashrate' => '126 TH/s',
                'power_consumption' => 3276,
                'algorithm' => 'SHA-256',
                'daily_profit_estimate' => 6.20,
                'featured' => false
            ],
            [
                'name' => 'AMD Radeon RX 6900 XT Mining Rig',
                'description' => 'Complete 6-GPU mining rig built with AMD Radeon RX 6900 XT cards, ready to mine right out of the box with pre-installed mining software.',
                'price' => 7499.99,
                'stock_quantity' => 5,
                'image' => 'mining/amd-mining-rig.webp',
                'hashrate' => '390 MH/s',
                'power_consumption' => 1800,
                'algorithm' => 'Ethash, Kawpow',
                'daily_profit_estimate' => 9.35,
                'featured' => true
            ],
            [
                'name' => 'Mining Rig Frame',
                'description' => 'Sturdy aluminum frame designed to hold up to 12 GPUs for cryptocurrency mining. Includes mounting hardware and power supply bracket.',
                'price' => 159.99,
                'stock_quantity' => 30,
                'image' => 'mining/mining-frame.webp',
                'hashrate' => 'N/A',
                'power_consumption' => 0,
                'algorithm' => 'N/A',
                'daily_profit_estimate' => 0.00,
                'featured' => false
            ],
            [
                'name' => 'Bitmain Power Supply APW9+',
                'description' => 'High-efficiency power supply designed specifically for Antminer ASIC miners. Delivers stable power for optimal mining performance.',
                'price' => 199.99,
                'stock_quantity' => 25,
                'image' => 'mining/bitmain-psu.webp',
                'hashrate' => 'N/A',
                'power_consumption' => 0,
                'algorithm' => 'N/A',
                'daily_profit_estimate' => 0.00,
                'featured' => false
            ],
            [
                'name' => 'Immersion Cooling Kit',
                'description' => 'Complete immersion cooling solution for mining rigs. Includes tank, cooling fluid, heat exchanger, and pump system for optimal temperature control.',
                'price' => 2499.99,
                'stock_quantity' => 7,
                'image' => 'mining/immersion-cooling.webp',
                'hashrate' => 'N/A',
                'power_consumption' => 200,
                'algorithm' => 'N/A',
                'daily_profit_estimate' => 0.00,
                'featured' => false
            ],
            [
                'name' => 'Mining Farm Setup Package',
                'description' => 'Complete starter package for a small mining farm. Includes 4 ASIC miners, power distribution unit, network switch, and basic monitoring system.',
                'price' => 12999.99,
                'stock_quantity' => 3,
                'image' => 'mining/mining-farm-package.webp',
                'hashrate' => '440 TH/s',
                'power_consumption' => 13000,
                'algorithm' => 'SHA-256',
                'daily_profit_estimate' => 22.80,
                'featured' => true
            ]
        ];

        foreach ($miningProducts as $product) {
            MiningProduct::create($product);
        }
    }
} 