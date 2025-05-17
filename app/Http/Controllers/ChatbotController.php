<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class ChatbotController extends Controller
{
    private $apiKey;
    private $model = 'gpt-3.5-turbo';
    private $maxTokens = 500;
    private $temperature = 0.7;
    private $timeout = 15;
    private $maxHistoryMessages = 5; // Maximum number of previous messages to store

    public function __construct()
    {
        // Get the API key from environment variables
        $this->apiKey = env('OPENAI_API_KEY');
    }

    /**
     * Process the chatbot message and return AI response
     */
    public function processMessage(Request $request)
    {
        try {
            $message = $request->input('message');
            
            if (empty($message)) {
                return response()->json(['error' => 'No message provided'], 400);
            }

            // Check if the message is PC-related
            if (!$this->isPcRelated($message)) {
                return response()->json([
                    'response' => "I'm specialized in helping with computer and PC-related questions. Please ask me about our products, computer specifications, or PC building services."
                ]);
            }

            // Check if API key is set
            if (empty($this->apiKey)) {
                Log::error('OpenAI API key is not set');
                return response()->json(['error' => 'API key configuration error'], 500);
            }

           
            $history = $this->getConversationHistory();
            
           
            $dbInfo = $this->getDatabaseInfo($message);

            
            $systemMessage = "You are a helpful computer store assistant for CT ZONE, a computer store in Lebanon, Tripoli. 
            Your name is CT ZONE Assistant.
            Only answer questions related to computers, PC components, and CT ZONE products and services.
            Keep responses concise (under 150 words) and focused on helping customers.
            
            Database information (use this for accurate product information):
            {$dbInfo}
            
            If asked about pricing, use the exact prices from the database information provided above.
            For non-PC related questions, politely explain you can only help with computer-related topics.
            
            Key services: PC Building, PC Repair, Technical Support, Component Upgrades.
            Contact info: +961 71 64 87 44, located in Tripoli, Lebanon.";

            
            $messages = [
                ['role' => 'system', 'content' => $systemMessage],
            ];
            
            
            foreach ($history as $item) {
                $messages[] = $item;
            }
            
            // hot lal user msg (currntly)
            $messages[] = ['role' => 'user', 'content' => $message];

           
            $response = Http::timeout($this->timeout)->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => $messages,
                'max_tokens' => $this->maxTokens,
                'temperature' => $this->temperature,
                'presence_penalty' => 0.1,
                'frequency_penalty' => 0.1,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $aiMessage = $responseData['choices'][0]['message']['content'] ?? null;
                
                if ($aiMessage) {
                    
                    $this->addToConversationHistory($message, $aiMessage);
                    
                    // Log successful response for monitoring
                    Log::info('Chatbot response sent', ['message_length' => strlen($message), 'response_length' => strlen($aiMessage)]);
                    return response()->json(['response' => $aiMessage]);
                }
                
                Log::error('OpenAI returned empty response', ['response' => $responseData]);
                return response()->json(['error' => 'No response from AI', 'user_message' => 'I apologize, but I couldn\'t generate a response. Please try asking in a different way.'], 500);
            }
            
            // handling la kam api error messages
        
            $statusCode = $response->status();
            $errorBody = $response->json();
            $errorType = $errorBody['error']['type'] ?? 'unknown_error';
            $errorMessage = $errorBody['error']['message'] ?? 'Unknown error';
            
            Log::error('OpenAI API error', [
                'status' => $statusCode,
                'type' => $errorType,
                'message' => $errorMessage,
                'user_query' => $message
            ]);
            
            // Provide  user facing msg based on error tp
            $userMessage = 'I\'m having trouble connecting to my knowledge base. Please try again in a moment.';
            
            if ($statusCode === 429) {
                $userMessage = 'I\'m currently handling too many requests. Please try again in a few moments.';
            } elseif ($statusCode === 400) {
                $userMessage = 'I couldn\'t process your request. Please try asking in a different way.';
            } elseif ($statusCode >= 500) {
                $userMessage = 'My knowledge service is temporarily unavailable. Please try again later.';
            }
            
            return response()->json(['error' => $errorMessage, 'user_message' => $userMessage], 500);
            
        } catch (\Exception $e) {
            Log::error('ChatbotController error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'An error occurred while processing your request',
                'user_message' => 'I apologize, but I\'m experiencing technical difficulties. Please try again later.'
            ], 500);
        }
    }

    
    private function getConversationHistory()
    {
        return Session::get('chatbot_history', []);
    }

    
    private function addToConversationHistory($userMessage, $aiMessage)
    {
        $history = $this->getConversationHistory();
        
        
        $history[] = ['role' => 'user', 'content' => $userMessage];
        $history[] = ['role' => 'assistant', 'content' => $aiMessage];
        
        // Khalle ekher 2 msgs kermel ma n2atte3 token limits
        if (count($history) > $this->maxHistoryMessages * 2) {
            $history = array_slice($history, -$this->maxHistoryMessages * 2);
        }
        
        // hotta nel session mn baad ma nkhalles msging
        Session::put('chatbot_history', $history);
    }

    private function getDatabaseInfo($message)
    {
        $info = [];
        $message = strtolower($message);

        
        $isRecommendationQuery = $this->isRecommendationQuery($message);
        if ($isRecommendationQuery) {
            $info[] = "Customer is asking for product recommendations.";
        }

        $totalProducts = Product::count();
        $info[] = "Total products available: {$totalProducts}";

       
        $categories = Category::all();
        $categoryList = "Product categories: " . $categories->pluck('name')->join(', ');
        $info[] = $categoryList;

        
        $productsQuery = Product::query();
        
        
        if (strpos($message, 'gaming') !== false || 
            strpos($message, 'gaming pc') !== false || 
            strpos($message, 'gaming computer') !== false) {
            $productsQuery->where('name', 'like', '%gaming%')->orWhere('description', 'like', '%gaming%');
            $info[] = "Gaming PC information requested.";
        }
        
        if (strpos($message, 'desktop') !== false) {
            $productsQuery->where('name', 'like', '%desktop%')->orWhere('description', 'like', '%desktop%');
        }
        
        if (strpos($message, 'laptop') !== false) {
            $productsQuery->where('name', 'like', '%laptop%')->orWhere('description', 'like', '%laptop%');
        }
        
        
        foreach (['gpu', 'graphics card', 'cpu', 'processor', 'ram', 'memory', 'motherboard', 'storage', 'ssd', 'hdd'] as $term) {
            if (strpos($message, $term) !== false) {
                $productsQuery->where('name', 'like', '%' . $term . '%')
                            ->orWhere('description', 'like', '%' . $term . '%');
                $info[] = "Information about {$term} requested.";
            }
        }
        
        // nabish aal  products li bl query
        $products = $productsQuery->take(5)->get();
        
        if ($products->count() > 0) {
            $info[] = "Relevant products:";
            foreach ($products as $product) {
                $info[] = "- {$product->name}: \${$product->price} - {$product->description}";
            }
        } else {
            // jib aham prd eza ma le2a specific product bl query
            $popularProducts = Product::orderBy('id', 'desc')->take(3)->get();
            $info[] = "Some of our products:";
            foreach ($popularProducts as $product) {
                $info[] = "- {$product->name}: \${$product->price} - {$product->description}";
            }
        }
        
        // Include price range
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
        $info[] = "Our products range in price from \${$minPrice} to \${$maxPrice}.";
        
        //  jib ekher order eza aam yeseal aan l popularity lal product
        if (strpos($message, 'popular') !== false || strpos($message, 'best selling') !== false || 
            strpos($message, 'top') !== false) {
            // This is a simplified approach - in a real system you'd count order items by product
            $recentOrderItems = DB::table('order_items')
                ->select('product_id', DB::raw('count(*) as count'))
                ->groupBy('product_id')
                ->orderBy('count', 'desc')
                ->take(3)
                ->get();
                
            if ($recentOrderItems->count() > 0) {
                $info[] = "Our most popular products:";
                foreach ($recentOrderItems as $item) {
                    $popularProduct = Product::find($item->product_id);
                    if ($popularProduct) {
                        $info[] = "- {$popularProduct->name}: \${$popularProduct->price} - Purchased {$item->count} times recently";
                    }
                }
            }
        }
        
        // eza aam yeseal aan recommends 3ti aktar details
        if ($isRecommendationQuery) {
            //  hott aya budget eza saeal
            if (preg_match('/(\$|usd|dollar|price|cost|budget|under|below|around|about)\s*(\d+)/', $message, $matches)) {
                $budget = (int) $matches[2];
                $budgetProducts = Product::where('price', '<=', $budget)
                                        ->orderBy('price', 'desc')
                                        ->take(3)
                                        ->get();
                
                if ($budgetProducts->count() > 0) {
                    $info[] = "Products within budget (\${$budget}):";
                    foreach ($budgetProducts as $product) {
                        $info[] = "- {$product->name}: \${$product->price} - {$product->description}";
                    }
                }
            }
            
            
            $bestProducts = Product::orderBy('id', 'desc')->take(2)->get();
            foreach ($bestProducts as $product) {
                
                $categoryName = $product->category ? $product->category->name : 'Uncategorized';
                $info[] = "Detailed specs for {$product->name} (Category: {$categoryName}):";
                
                
                $specs = $this->extractSpecifications($product->description);
                foreach ($specs as $spec) {
                    $info[] = "  * {$spec}";
                }
            }
        }
        
        return implode("\n", $info);
    }

    // chuf eza l msg elo 3ale2a bl pcs (pc related)
    private function isPcRelated($message)
    {
        $message = strtolower($message);
        
        $computerTerms = [
            'pc', 'computer', 'laptop', 'desktop', 'processor', 'cpu', 'gpu', 'graphics card',
            'ram', 'memory', 'motherboard', 'hard drive', 'ssd', 'gaming', 'storage', 'monitor',
            'keyboard', 'mouse', 'component', 'build', 'custom', 'upgrade', 'repair', 'windows',
            'mac', 'intel', 'amd', 'nvidia', 'performance', 'fps', 'gigabyte', 'megabyte',
            'terabyte', 'cooling', 'fan', 'power supply', 'psu', 'case', 'tower', 'driver',
            'software', 'hardware', 'gaming pc', 'workstation', 'video card', 'benchmark',
            'installation', 'setup', 'configuration', 'gaming', 'price', 'cost', 'warranty',
            'delivery', 'shipping', 'order', 'payment', 'specs', 'specifications', 'compatibility',
            'ct zone', 'store', 'shop', 'buy', 'purchase', 'product', 'service', 'support',
            'tech', 'technology', 'graphic', 'display', 'screen', 'system', 'os', 'operating system',
            'cable', 'peripheral', 'wifi', 'network', 'speed', 'fast', 'slow', 'crash',
            'error', 'blue screen', 'boot', 'restart', 'freeze', 'overclock', 'rgb', 'light'
        ];
        
        foreach ($computerTerms as $term) {
            if (strpos($message, $term) !== false) {
                return true;
            }
        }
        
       
        $generalTerms = ['hello', 'hi', 'hey', 'help', 'thanks', 'thank you', 'contact', 'assistance'];
        
        foreach ($generalTerms as $term) {
            if (strpos($message, $term) !== false) {
                return true;
            }
        }
        
        return false;
    }

   
    private function isRecommendationQuery($message)
    {
        $recommendationTerms = [
            'recommend', 'suggestion', 'suggest', 'best', 'top', 'better', 
            'which one', 'which is better', 'what should i', 'what would you', 
            'looking for', 'need a', 'need to buy', 'want to buy', 'planning to buy',
            'good for', 'suitable for', 'budget', 'affordable'
        ];
        
        foreach ($recommendationTerms as $term) {
            if (strpos($message, $term) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    
    private function extractSpecifications($description)
    {
        $specs = [];
        
        
        $specPatterns = [
            'CPU' => '/(?:cpu|processor)[:\s]+([^,\.]+)/i',
            'GPU' => '/(?:gpu|graphics)[:\s]+([^,\.]+)/i',
            'RAM' => '/(?:ram|memory)[:\s]+([^,\.]+)/i',
            'Storage' => '/(?:storage|ssd|hdd|drive)[:\s]+([^,\.]+)/i',
            'Display' => '/(?:display|screen|monitor)[:\s]+([^,\.]+)/i',
        ];
        
        foreach ($specPatterns as $component => $pattern) {
            if (preg_match($pattern, $description, $matches)) {
                $specs[] = "{$component}: {$matches[1]}";
            }
        }
        
        // eza l specs ma la2ehon bl structured way, bas hott fawasel
        if (empty($specs)) {
            $parts = preg_split('/[,\.]/', $description);
            foreach ($parts as $part) {
                $part = trim($part);
                if (!empty($part) && strlen($part) > 10) {
                    $specs[] = $part;
                }
            }
        }
        
        return $specs;
    }

    
    public function clearConversation(Request $request)
    {
        Session::forget('chatbot_history');
        return response()->json(['success' => true, 'message' => 'Conversation history cleared']);
    }
} 