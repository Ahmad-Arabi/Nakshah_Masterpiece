<x-app-layout>
    <div class="order-confirmation-page">
        <div class="container mt-3 mb-5">
            <div class="text-center mb-5">
                <div class="success-icon mb-4">
                    <i class="fa fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h1 class="confirmation-title mb-2">Thank You for Your Order!</h1>
                <p class="lead text-muted">Your order has been placed successfully.</p>
            </div>
            <div class="container text-center mb-3">
                {{-- <p class="mb-4">A confirmation email has been sent to your email address.</p> --}}
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary mx-1">
                        <i class="fa fa-list-alt me-2"></i> View My Orders
                    </a>
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary mx-1">
                        <i class="fa fa-shopping-bag me-2"></i> Continue Shopping
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Order #{{ $order->id }}</h5>
                                <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Order Details</h6>
                                    <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</p>
                                    <p class="mb-1"><strong>Total:</strong> {{ $order->total_price }} JOD</p>
                                    <p class="mb-0"><strong>Payment Method:</strong> 
                                        @if(stripos($order->payment_method, 'cash') !== false)
                                            Cash on Delivery
                                        @else
                                            Credit Card
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Shipping Information</h6>
                                    <p class="mb-1"><strong>Address:</strong> {{ $order->delivery_address }}</p>
                                    <p class="mb-0"><strong>Phone:</strong> {{ $order->phone_number }}</p>
                                </div>
                            </div>
                            
                            <h6 class="text-muted mb-3">Order Items</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product)
                                                            @if($item->product->thumbnail)
                                                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" 
                                                                    alt="{{ $item->product->name }}" class="img-thumbnail me-2" style="width: 50px;">
                                                            @endif
                                                            {{ $item->product->name }}
                                                        @else
                                                            Product not available
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $item->selected_size }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price }} JOD</td>
                                                <td>{{ $item->price * $item->quantity }} JOD</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                            <td>{{ $order->shipping_fees == 5.00 ? $order->total_price + $order->discount_applied - $order->shipping_fees :  $order->total_price + $order->discount_applied }} JOD</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                                            <td>
                                                @if($order->shipping_fees !== 'Free') 
                                                    {{ number_format($order->shipping_fees, 2) . "JOD" }}
                                                @else 
                                                    {{ $order->shipping_fees }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if($order->discount_applied > 0)
                                            <tr class="text-success">
                                                <td colspan="4" class="text-end"><strong>Discount:</strong></td>
                                                <td>-{{ $order->discount_applied }} JOD</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                            <td><strong>{{ $order->total_price }} JOD</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>

    <style>
        header {
    position: sticky;
    top: 0;
    z-index: 1000;
} 
    
    </style>
</x-app-layout>