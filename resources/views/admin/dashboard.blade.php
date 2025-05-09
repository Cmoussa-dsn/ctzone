@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('content')
    <div class="w-full">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Dashboard</h1>
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="glass p-6 rounded-xl">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Orders</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="glass p-6 rounded-xl">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Products</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-box text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="glass p-6 rounded-xl">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Customers</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Calculate revenue from recent orders if needed -->
            <div class="glass p-6 rounded-xl">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Revenue (30 days)</h3>
                        <p class="text-3xl font-bold text-gray-800">${{ number_format(array_sum($salesData['salesTotals']), 2) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sales Chart Section -->
        <div class="glass p-6 rounded-xl mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Sales Traffic</h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 rounded text-sm font-medium bg-blue-500 text-white period-selector" data-period="7days">7 Days</button>
                    <button class="px-3 py-1 rounded text-sm font-medium bg-gray-200 text-gray-800 period-selector" data-period="30days">30 Days</button>
                    <button class="px-3 py-1 rounded text-sm font-medium bg-gray-200 text-gray-800 period-selector" data-period="90days">90 Days</button>
                    <button class="px-3 py-1 rounded text-sm font-medium bg-gray-200 text-gray-800 period-selector" data-period="year">Year</button>
                </div>
            </div>
            <div class="h-72">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <!-- Recent Orders Section -->
        <div class="glass p-6 rounded-xl">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($order->total_price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status == 'delivered') bg-green-100 text-green-800 
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">View All Orders →</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        let salesChart;
        
        // Initial data
        const initialLabels = @json($salesData['labels']);
        const initialOrderCounts = @json($salesData['orderCounts']);
        const initialSalesTotals = @json($salesData['salesTotals']);
        
        function createChart(labels, orderCounts, salesTotals) {
            // Destroy existing chart if it exists
            if (salesChart) {
                salesChart.destroy();
            }
            
            salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Orders',
                        data: orderCounts,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        yAxisID: 'y',
                    }, {
                        label: 'Revenue ($)',
                        data: salesTotals,
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        yAxisID: 'y1',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Orders'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Revenue ($)'
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                        },
                        x: {
                            ticks: {
                                maxTicksLimit: 10,
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.dataset.label === 'Revenue ($)') {
                                        label += new Intl.NumberFormat('en-US', { 
                                            style: 'currency', 
                                            currency: 'USD' 
                                        }).format(context.raw);
                                    } else {
                                        label += context.raw;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize chart with 30-day data
        createChart(initialLabels, initialOrderCounts, initialSalesTotals);
        
        // Add event listeners to period selector buttons
        document.querySelectorAll('.period-selector').forEach(button => {
            button.addEventListener('click', function() {
                // Update active button styling
                document.querySelectorAll('.period-selector').forEach(btn => {
                    btn.classList.remove('bg-blue-500', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-800');
                });
                this.classList.remove('bg-gray-200', 'text-gray-800');
                this.classList.add('bg-blue-500', 'text-white');
                
                // Fetch data for the selected period
                const period = this.dataset.period;
                fetchSalesData(period);
            });
        });
        
        // Function to fetch sales data from the server
        function fetchSalesData(period) {
            fetch(`{{ route('admin.sales-data') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.date);
                    const orderCounts = data.map(item => item.order_count);
                    const salesTotals = data.map(item => item.total_sales);
                    
                    createChart(labels, orderCounts, salesTotals);
                })
                .catch(error => {
                    console.error('Error fetching sales data:', error);
                });
        }
    });
</script>
@endpush 