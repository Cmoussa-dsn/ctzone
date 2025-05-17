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
            
        // Get accessories - either from products explicitly named as accessories
        // or products with N/A algorithm which indicates they're not miners
        $accessories = MiningProduct::where('algorithm', 'N/A')
            ->orWhereIn('name', ['Mining Rig Frame', 'Bitmain Power Supply APW9+', 'Immersion Cooling Kit'])
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function products(Request $request): View
    {
        // Get filter parameters
        $priceRange = $request->input('price_range');
        $sortBy = $request->input('sort_by', 'featured');
        $filterType = $request->input('filter_type', 'all');
        
        // Initialize base query
        $query = MiningProduct::query();
        
        // Apply filter by type
        if ($filterType !== 'all') {
            switch ($filterType) {
                case 'ASIC':
                    $query->where('algorithm', 'like', '%SHA-256%');
                    break;
                case 'GPU':
                    $query->where('algorithm', '!=', 'N/A')
                          ->where('algorithm', 'not like', '%SHA-256%');
                    break;
                case 'accessories':
                    $query->where('algorithm', 'N/A');
                    break;
            }
        }
        
        // Apply price range filter
        if ($priceRange) {
            $prices = explode('-', $priceRange);
            if (count($prices) == 2) {
                $minPrice = (float) $prices[0];
                $maxPrice = (float) $prices[1];
                
                // If maxPrice is 0, it means no upper limit (e.g., "2000+")
                if ($maxPrice > 0) {
                    $query->whereBetween('price', [$minPrice, $maxPrice]);
                } else {
                    $query->where('price', '>=', $minPrice);
                }
            }
        }
        
        // Apply sorting
        switch ($sortBy) {
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'hashrate-high':
                // Special case for hashrate sorting
                // First, sort by products with numeric hashrate in descending order
                // For accessories with N/A hashrate, put them at the end
                $query->orderByRaw("CASE WHEN hashrate = 'N/A' THEN 1 ELSE 0 END")
                      ->orderBy('price', 'desc'); // Fallback for accessories with N/A hashrate
                break;
            case 'featured':
            default:
                $query->where('featured', true)->orderBy('price', 'desc')
                      ->orWhere('featured', false);
                break;
        }
        
        $miningProducts = $query->paginate(12)->withQueryString();
        
        return view('mining.products', compact('miningProducts', 'priceRange', 'sortBy', 'filterType'));
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
        
        // For products with N/A algorithm, show related accessories
        // Otherwise, show related mining products
        if ($product->algorithm === 'N/A') {
            $relatedProducts = MiningProduct::where('id', '!=', $id)
                ->where('algorithm', 'N/A')
                ->take(4)
                ->get();
        } else {
            $relatedProducts = MiningProduct::where('id', '!=', $id)
                ->where(function($query) use ($product) {
                    $query->where('algorithm', $product->algorithm)
                        ->orWhere('power_consumption', '<=', $product->power_consumption + 100)
                        ->orWhere('power_consumption', '>=', $product->power_consumption - 100);
                })
                ->take(4)
                ->get();
        }
            
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
     * Calculate mining profitability based on user input
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateProfitability(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'hashrate' => 'required|numeric|min:0',
            'hashrate_unit' => 'required|string|in:TH,GH,MH,KH',
            'power_consumption' => 'required|numeric|min:0',
            'electricity_cost' => 'required|numeric|min:0',
            'algorithm' => 'required|string|in:SHA-256,Ethash,Scrypt,X11,RandomX',
            'pool_fee' => 'required|numeric|min:0|max:100',
            'price_refresh_only' => 'nullable|boolean'
        ]);
        
        // If this is just a price refresh request, return the current prices
        if (isset($validated['price_refresh_only']) && $validated['price_refresh_only']) {
            return response()->json([
                'prices' => $this->getCryptoPrices()
            ]);
        }
        
        // Get crypto prices from cache or API
        $cryptoPrices = Cache::remember('crypto_prices', 300, function () {
            return $this->getCryptoPrices();
        });
        
        // Extract user inputs
        $hashrateValue = $validated['hashrate'];
        $hashrateUnit = $validated['hashrate_unit'];
        $algorithm = $validated['algorithm'];
        $powerConsumption = $validated['power_consumption'];
        $electricityCost = $validated['electricity_cost'];
        $poolFeePercentage = $validated['pool_fee'] / 100;
        
        // Calculate daily rewards based on algorithm and hashrate
        // Using direct reference values based on current mining profitability
        $dailyReward = 0;
        $cryptoSymbol = '';
        
        switch ($algorithm) {
            case 'SHA-256':
                $cryptoSymbol = 'BTC';
                // For SHA-256 mining (Bitcoin)
                // Convert to TH/s as standard unit for BTC mining
                $hashrateInTH = $this->convertToStandardUnit($hashrateValue, $hashrateUnit, 'TH');
                
                // Real-world reference: 1 TH/s ≈ 0.000008 BTC per day
                // Increased to 0.00005 BTC per day for better visibility in MH/s range
                $dailyReward = $hashrateInTH * 0.0000005;
                break;
                
            case 'Ethash':
                $cryptoSymbol = 'ETH';
                // For Ethash mining (Ethereum/ETC)
                // Convert to MH/s as standard unit for ETH mining
                $hashrateInMH = $this->convertToStandardUnit($hashrateValue, $hashrateUnit, 'MH');
                
                // Real-world reference enhanced for better visibility
                // 100 MH/s ≈ 0.003 ETH per day
                $dailyReward = ($hashrateInMH / 100) * 0.00003;
                break;
                
            case 'Scrypt':
                $cryptoSymbol = 'LTC';
                // For Scrypt mining (Litecoin)
                // Convert to MH/s as standard unit for LTC mining
                $hashrateInMH = $this->convertToStandardUnit($hashrateValue, $hashrateUnit, 'MH');
                
                // Real-world reference enhanced for better visibility
                // 100 MH/s ≈ 0.03 LTC per day
                $dailyReward = ($hashrateInMH / 100) * 0.00003;
                break;
                
            case 'X11':
                $cryptoSymbol = 'DASH';
                // For X11 mining (Dash)
                // Convert to GH/s as standard unit for DASH mining
                $hashrateInGH = $this->convertToStandardUnit($hashrateValue, $hashrateUnit, 'GH');
                
                // Real-world reference enhanced for better visibility
                // 1 GH/s ≈ 0.002 DASH per day
                $dailyReward = $hashrateInGH * 0.000002;
                break;
                
            case 'RandomX':
                $cryptoSymbol = 'XMR';
                // For RandomX mining (Monero)
                // Convert to H/s as standard unit for XMR mining
                $hashrateInH = $this->convertToStandardUnit($hashrateValue, $hashrateUnit, 'H');
                
                // Real-world reference enhanced for better visibility
                // 10000 H/s ≈ 0.008 XMR per day
                $dailyReward = ($hashrateInH / 10000) * 0.000008;
                break;
                
            default:
                // Fallback
                $cryptoSymbol = 'BTC';
                $dailyReward = 0.00000001;
        }
        
        // Apply pool fee
        $dailyReward = $dailyReward * (1 - $poolFeePercentage);
        
        // Get cryptocurrency price
        $cryptoPrice = $cryptoPrices[$cryptoSymbol] ?? $this->getFallbackPrices()[$cryptoSymbol];
        
        // Calculate rewards in USD
        $dailyRewardUsd = $dailyReward * $cryptoPrice;
        
        // Calculate power costs
        $dailyPowerCost = ($powerConsumption / 1000) * 24 * $electricityCost; // kWh per day * cost per kWh
        
        // Calculate profit
        $dailyProfit = $dailyRewardUsd - $dailyPowerCost;
        $monthlyProfit = $dailyProfit * 30;
        $yearlyProfit = $dailyProfit * 365;
        
        // Calculate monthly and yearly costs
        $monthlyPowerCost = $dailyPowerCost * 30;
        $yearlyPowerCost = $dailyPowerCost * 365;
        
        // Calculate monthly and yearly crypto rewards
        $monthlyReward = $dailyReward * 30;
        $yearlyReward = $dailyReward * 365;
        
        // Log calculation details for debugging
        Log::info("Mining profitability calculation", [
            'algorithm' => $algorithm,
            'hashrate' => $hashrateValue . ' ' . $hashrateUnit,
            'crypto_symbol' => $cryptoSymbol,
            'crypto_price' => $cryptoPrice,
            'daily_reward_crypto' => $dailyReward,
            'daily_reward_usd' => $dailyRewardUsd,
            'daily_power_cost' => $dailyPowerCost,
            'daily_profit' => $dailyProfit
        ]);
        
        return response()->json([
            'daily_reward' => number_format($dailyReward, 8, '.', ''),
            'monthly_reward' => number_format($monthlyReward, 8, '.', ''),
            'yearly_reward' => number_format($yearlyReward, 8, '.', ''),
            'daily_reward_usd' => number_format($dailyRewardUsd, 2, '.', ''),
            'daily_power_cost' => number_format($dailyPowerCost, 2, '.', ''),
            'daily_profit' => number_format($dailyProfit, 2, '.', ''),
            'monthly_power_cost' => number_format($monthlyPowerCost, 2, '.', ''),
            'monthly_profit' => number_format($monthlyProfit, 2, '.', ''),
            'yearly_power_cost' => number_format($yearlyPowerCost, 2, '.', ''),
            'yearly_profit' => number_format($yearlyProfit, 2, '.', ''),
            'crypto_symbol' => $cryptoSymbol,
            'crypto_price' => $cryptoPrice,
            'using_live_prices' => !isset($cryptoPrices['is_fallback']),
            'price_updated_at' => isset($cryptoPrices['timestamp']) ? date('Y-m-d H:i:s', $cryptoPrices['timestamp']) : date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Convert hashrate to standard unit used for each algorithm
     *
     * @param float $value Original hashrate value
     * @param string $fromUnit Original unit (TH, GH, MH, KH)
     * @param string $toUnit Target unit (TH, GH, MH, KH, H)
     * @return float Converted hashrate value
     */
    private function convertToStandardUnit($value, $fromUnit, $toUnit)
    {
        // Define conversion factors (to H/s)
        $toHs = [
            'KH' => 1000,
            'MH' => 1000000,
            'GH' => 1000000000,
            'TH' => 1000000000000,
            'H' => 1
        ];
        
        // First convert to H/s
        $valueInHs = $value * $toHs[$fromUnit];
        
        // Then convert to target unit
        $result = $valueInHs / $toHs[$toUnit];
        
        return $result;
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
            'BTC' => 60000,    // Updated fallback Bitcoin price
            'ETH' => 3500,     // Updated fallback Ethereum price
            'LTC' => 80,       // Updated fallback Litecoin price
            'DASH' => 30,      // Updated fallback Dash price
            'XMR' => 180,      // Updated fallback Monero price
            'timestamp' => time(),
            'is_fallback' => true
        ];
    }
} 
