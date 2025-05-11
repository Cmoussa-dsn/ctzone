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
    
} 