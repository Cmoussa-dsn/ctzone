<x-app-layout>
    <div class="container">
        <div class="order-header">
            <a href="{{ route('orders.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <h1 class="page-title">Order Details</h1>
        </div>
        
        <div class="order-info-card">
            <div class="order-meta">
                <div class="order-number">
                    <h2>Order #{{ $order->id }}</h2>
                    <span class="order-date">Placed on {{ $order->created_at->format('F d, Y') }}</span>
                </div>
                <div class="order-status">
                    <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
        </div>
        
        <div class="order-content">
            <div class="order-items">
                <h3>Order Items</h3>
                <div class="items-list">
                    @foreach($orderItems as $item)
                        <div class="item-card">
                            <div class="item-image">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/default-pc.jpg') }}" alt="{{ $item->product->name }}">
                            </div>
                            <div class="item-details">
                                <h4 class="item-name">{{ $item->product->name }}</h4>
                                <p class="item-price">${{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                <p class="item-total">{{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="order-summary">
                <h3>Order Summary</h3>
                <div class="summary-card">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->total_price, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${{ number_format($order->total_price, 2) }}</span>
                    </div>
                </div>
                
                <div class="order-actions">
                    <a href="{{ route('buy') }}" class="btn">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .order-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .back-link {
            display: flex;
            align-items: center;
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            margin-right: 20px;
        }
        
        .back-link i {
            margin-right: 5px;
        }
        
        .page-title {
            font-size: 1.8rem;
            color: #333;
            font-weight: 600;
            margin: 0;
        }
        
        .order-info-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .order-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .order-number h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .order-date {
            color: #666;
            font-size: 0.9rem;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
        }
        
        .status-pending {
            background-color: #f39c12;
        }
        
        .status-processing {
            background-color: #3498db;
        }
        
        .status-shipped {
            background-color: #2ecc71;
        }
        
        .status-delivered {
            background-color: #27ae60;
        }
        
        .status-cancelled {
            background-color: #e74c3c;
        }
        
        .order-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .order-items, .order-summary {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        .order-items h3, .order-summary h3 {
            font-size: 1.3rem;
            margin: 0 0 20px 0;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .items-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .item-card {
            display: flex;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .item-image {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }
        
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .item-name {
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0 0 5px 0;
        }
        
        .item-price {
            color: #666;
            font-size: 0.9rem;
            margin: 0 0 5px 0;
        }
        
        .item-total {
            font-weight: 600;
            margin: 0;
        }
        
        .summary-card {
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .summary-row.total {
            font-weight: 600;
            font-size: 1.2rem;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            border-bottom: none;
        }
        
        .order-actions {
            margin-top: 30px;
            text-align: center;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        @media (max-width: 768px) {
            .order-content {
                grid-template-columns: 1fr;
            }
            
            .order-meta {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .order-status {
                margin-top: 15px;
            }
        }
    </style>
</x-app-layout> 