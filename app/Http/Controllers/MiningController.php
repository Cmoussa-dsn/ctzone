<?php

namespace App\Http\Controllers;

use App\Models\MiningProduct;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class MiningController extends Controller
{
    /**
     * Display the mining homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $featuredProducts = MiningProduct::where('featured', true)
            ->take(4)
            ->get();
            
        $asicMiners = MiningProduct::where('algorithm', 'SHA-256')
            ->take(3)
            ->get();
            
        $gpuMiners = MiningProduct::where('algorithm', 'like', '%Ethash%')
            ->take(3)
            ->get();
            
        $accessories = MiningProduct::whereIn('name', ['Mining Rig Frame', 'Bitmain Power Supply APW9+', 'Immersion Cooling Kit'])
            ->take(3)
            ->get();
            
        return view('mining.index', compact(
            'featuredProducts',
            'asicMiners',
            'gpuMiners',
            'accessories'
        ));
    }
    
    /**
     * Display all mining products.
     *
     * @return \Illuminate\View\View
     */
    public function products(): View
    {
        $miningProducts = MiningProduct::paginate(12);
        
        return view('mining.products', compact('miningProducts'));
    }
    
    /**
     * Display a single mining product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        $product = MiningProduct::findOrFail($id);
        $relatedProducts = MiningProduct::where('id', '!=', $id)
            ->where(function($query) use ($product) {
                $query->where('algorithm', $product->algorithm)
                    ->orWhere('power_consumption', '<=', $product->power_consumption + 100)
                    ->orWhere('power_consumption', '>=', $product->power_consumption - 100);
            })
            ->take(4)
            ->get();
            
        return view('mining.show', compact('product', 'relatedProducts'));
    }
    
    /**
     * Display the mining calculator page.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function calculator()
    {
        // Require authentication for the calculator
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to access the mining calculator.');
        }
        
        $miningProducts = MiningProduct::whereNotIn('hashrate', ['N/A'])->get();
        
        // Get cryptocurrency prices for display on the calculator page
        $cryptoPrices = Cache::remember('crypto_prices', 300, function () {
            return $this->getCryptoPrices();
        });
        
        return view('mining.calculator', compact('miningProducts', 'cryptoPrices'));
    }
    
    /**
     * Get live cryptocurrency prices from CoinMarketCap API
     * 
     * @return array
     */
    private function getCryptoPrices()
    {
        $apiKey = env('COINMARKETCAP_API_KEY');
        $symbols = 'BTC,ETH,LTC,DASH,XMR'; // Bitcoin, Ethereum, Litecoin, Dash, Monero
        
        try {
            $url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol={$symbols}";
            $headers = [
                'X-CMC_PRO_API_KEY: ' . $apiKey,
                'Accept: application/json'
            ];
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                // Log the error but use fallback prices
                Log::error("CoinMarketCap API Error: {$err}");
                return $this->getFallbackPrices();
            }
            
            $data = json_decode($response, true);
            if (!isset($data['data'])) {
                Log::error("CoinMarketCap API returned invalid data: " . json_encode($data));
                return $this->getFallbackPrices();
            }
            
            // Extract prices
            $prices = [];
            foreach ($data['data'] as $symbol => $coinData) {
                $prices[$symbol] = $coinData['quote']['USD']['price'];
            }
            
            // Add timestamp for caching purposes
            $prices['timestamp'] = time();
            
            // Cache the prices for 5 minutes to avoid excessive API calls
            Cache::put('crypto_prices', $prices, 300);
            
            return $prices;
        } catch (\Exception $e) {
            Log::error("CoinMarketCap API Exception: " . $e->getMessage());
            return $this->getFallbackPrices();
        }
    }
    
    /**
     * Provide fallback prices in case the API call fails
     * 
     * @return array
     */
    private function getFallbackPrices()
    {
        return [
            'BTC' => 39500,
            'ETH' => 2000,
            'LTC' => 80,
            'DASH' => 30,
            'XMR' => 160,
            'timestamp' => time(),
            'is_fallback' => true
        ];
    }
    
    /**
     * Calculate mining profitability based on input parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateProfitability(Request $request)
    {
        // Require authentication for the API
        if (!Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }
        
        $request->validate([
            'hashrate' => 'required|numeric',
            'hashrate_unit' => 'required|string|in:TH,GH,MH,KH',
            'power_consumption' => 'required|numeric',
            'electricity_cost' => 'required|numeric',
            'algorithm' => 'required|string',
            'pool_fee' => 'required|numeric',
        ]);
        
        // If this is a manual refresh (from the button click), clear the cache
        // to force a fresh API call for the latest prices
        if ($request->has('price_refresh_only') && $request->price_refresh_only) {
            Cache::forget('crypto_prices');
        }
        
        // Get cryptocurrency prices (either from cache or from API)
        $prices = Cache::remember('crypto_prices', 300, function () {
            return $this->getCryptoPrices();
        });
        
        // If this is just a price refresh request, return only the prices
        if ($request->has('price_refresh_only') && $request->price_refresh_only) {
            return response()->json([
                'prices' => $prices
            ]);
        }
        
        // Convert hashrate to standard units based on algorithm
        $hashrate = $request->hashrate;
        $hashrateUnit = $request->hashrate_unit;
        $algorithm = $request->algorithm;
        
        // Standardize hashrate to TH/s for SHA-256 and MH/s for everything else
        if ($algorithm == 'SHA-256') {
            // Convert to TH/s
            switch ($hashrateUnit) {
                case 'KH':
                    $standardizedHashrate = $hashrate / 1000000000;
                    break;
                case 'MH':
                    $standardizedHashrate = $hashrate / 1000000;
                    break;
                case 'GH':
                    $standardizedHashrate = $hashrate / 1000;
                    break;
                case 'TH':
                default:
                    $standardizedHashrate = $hashrate;
                    break;
            }
        } else {
            // Convert to MH/s for other algorithms
            switch ($hashrateUnit) {
                case 'KH':
                    $standardizedHashrate = $hashrate / 1000;
                    break;
                case 'MH':
                    $standardizedHashrate = $hashrate;
                    break;
                case 'GH':
                    $standardizedHashrate = $hashrate * 1000;
                    break;
                case 'TH':
                    $standardizedHashrate = $hashrate * 1000000;
                    break;
            }
        }
        
        // Current network data with live prices
        $networkData = [
            'SHA-256' => [
                'difficulty' => 90000000000000, // Example Bitcoin network difficulty
                'block_reward' => 3.125, // BTC per block after 2024 halving
                'block_time' => 600, // seconds (10 minutes)
                'price' => $prices['BTC'] ?? 39500, // Get live price from API
                'symbol' => 'BTC'
            ],
            'Ethash' => [
                'difficulty' => 12000000000000000, // Example Ethereum network difficulty
                'block_reward' => 2, // ETH per block (post-merge this is actually 0)
                'block_time' => 12, // seconds
                'price' => $prices['ETH'] ?? 2000, // Get live price from API
                'symbol' => 'ETH'
            ],
            'Scrypt' => [
                'difficulty' => 15000000, // Example Litecoin network difficulty
                'block_reward' => 12.5, // LTC per block
                'block_time' => 150, // seconds (2.5 minutes)
                'price' => $prices['LTC'] ?? 80, // Get live price from API
                'symbol' => 'LTC'
            ],
            'X11' => [
                'difficulty' => 2500000, // Example Dash network difficulty
                'block_reward' => 1.55, // DASH per block
                'block_time' => 150, // seconds (2.5 minutes)
                'price' => $prices['DASH'] ?? 30, // Get live price from API
                'symbol' => 'DASH'
            ],
            'RandomX' => [
                'difficulty' => 350000000000, // Example Monero network difficulty
                'block_reward' => 0.6, // XMR per block
                'block_time' => 120, // seconds (2 minutes)
                'price' => $prices['XMR'] ?? 160, // Get live price from API
                'symbol' => 'XMR'
            ]
        ];
        
        if (!isset($networkData[$algorithm])) {
            return response()->json(['error' => 'Unsupported algorithm'], 400);
        }
        
        $data = $networkData[$algorithm];
        
        // Calculate daily reward based on algorithm and network difficulty
        $dailyReward = 0;
        
        if ($algorithm == 'SHA-256') {
            // BTC Mining (SHA-256)
            // Daily reward = (hashrate / network_hashrate) * blocks_per_day * block_reward
            // Network hashrate can be approximated as difficulty * 2^32 / block_time
            $networkHashrate = ($data['difficulty'] * pow(2, 32)) / $data['block_time'] / 1000000000000; // in TH/s
            $blocksPerDay = 86400 / $data['block_time']; // 86400 seconds in a day
            $dailyReward = ($standardizedHashrate / $networkHashrate) * $blocksPerDay * $data['block_reward'];
        } 
        else if ($algorithm == 'Ethash') {
            // ETH Mining (Ethash)
            // For proof of stake chains (like ETH post-merge), we provide a legacy calculation
            // that would be applicable to Ethereum Classic or other Ethash chains
            $networkHashrateMH = 1000000; // Simplified - would be fetched from API
            $blocksPerDay = 86400 / $data['block_time'];
            $dailyReward = ($standardizedHashrate / $networkHashrateMH) * $blocksPerDay * $data['block_reward'];
        } 
        else if ($algorithm == 'Scrypt' || $algorithm == 'X11' || $algorithm == 'RandomX') {
            // Generic calculation for other algorithms
            // Daily reward = (hashrate / network_hashrate) * blocks_per_day * block_reward
            $networkHashrateMH = 1000000; // Simplified - would be fetched from API
            $blocksPerDay = 86400 / $data['block_time'];
            $dailyReward = ($standardizedHashrate / $networkHashrateMH) * $blocksPerDay * $data['block_reward'];
        }
        
        // Apply pool fee
        $poolFee = $request->pool_fee / 100;
        $dailyReward = $dailyReward * (1 - $poolFee);
        
        // Calculate revenue in USD
        $dailyRevenueUsd = $dailyReward * $data['price'];
        $monthlyRevenueUsd = $dailyRevenueUsd * 30;
        $yearlyRevenueUsd = $dailyRevenueUsd * 365;
        
        // Calculate power cost
        $dailyPowerCost = ($request->power_consumption / 1000) * 24 * $request->electricity_cost;
        $monthlyPowerCost = $dailyPowerCost * 30;
        $yearlyPowerCost = $dailyPowerCost * 365;
        
        // Calculate profit
        $dailyProfit = $dailyRevenueUsd - $dailyPowerCost;
        $monthlyProfit = $monthlyRevenueUsd - $monthlyPowerCost;
        $yearlyProfit = $yearlyRevenueUsd - $yearlyPowerCost;
        
        return response()->json([
            'daily_reward' => round($dailyReward, 8),
            'daily_reward_usd' => round($dailyRevenueUsd, 2),
            'daily_power_cost' => round($dailyPowerCost, 2),
            'daily_profit' => round($dailyProfit, 2),
            'monthly_profit' => round($monthlyProfit, 2),
            'yearly_profit' => round($yearlyProfit, 2),
            'crypto_symbol' => $data['symbol'],
            'crypto_price' => round($data['price'], 2),
            'monthly_reward' => round($dailyReward * 30, 8),
            'yearly_reward' => round($dailyReward * 365, 8),
            'monthly_power_cost' => round($monthlyPowerCost, 2),
            'yearly_power_cost' => round($yearlyPowerCost, 2),
            'using_live_prices' => !isset($prices['is_fallback']),
            'price_updated_at' => date('Y-m-d H:i:s', $prices['timestamp'])
        ]);
    }
} 