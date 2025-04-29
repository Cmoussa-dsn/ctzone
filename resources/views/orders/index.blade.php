<x-app-layout>
    <div class="container">
        <h1 class="page-title">Order History</h1>
        
        @if($orders->count() > 0)
            <div class="orders-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <h2>Order #{{ $order->id }}</h2>
                                <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="order-status">
                                <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                <span class="order-total">${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order->id) }}" class="view-details-btn">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-orders">
                <p>You haven't placed any orders yet.</p>
                <a href="{{ route('buy') }}" class="btn">Browse Products</a>
            </div>
        @endif
    </div>

    <style>
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .page-title {
            font-size: 2rem;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
            text-align: center;
        }
        
        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .order-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s ease;
        }
        
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .order-info h2 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .order-date {
            color: #666;
            font-size: 0.9rem;
        }
        
        .order-status {
            text-align: right;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
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
        
        .order-total {
            display: block;
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }
        
        .order-actions {
            display: flex;
            justify-content: flex-end;
        }
        
        .view-details-btn {
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        
        .view-details-btn:hover {
            background-color: #2980b9;
        }
        
        .no-orders {
            text-align: center;
            padding: 40px 0;
        }
        
        .no-orders p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 20px;
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
            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .order-status {
                text-align: left;
                margin-top: 10px;
            }
        }
    </style>
</x-app-layout> 