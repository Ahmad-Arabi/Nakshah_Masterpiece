@extends('layouts.admin')

@section('title')
    Admin: Orders - View Details
@endsection

@section('style')
    <link rel="stylesheet" href="/css/admin.css">
    <style>
        /* Order-specific card styling */
        .order-item-card {
            background-color: #dbdbdb;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2px;
            transition: transform 0.2s ease;
            height: 100%;
            position: relative;
        }

        .order-item-card:hover {
            transform: translateY(-5px);
        }

        .modal-open .order-item-card:hover {
            transform: none !important;
        }


        .order-item-card img {
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .order-item-card .card-content {
            padding: 15px;
        }

        .order-item-card h5 {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .order-item-card p {
            margin-bottom: 2px;
            font-size: 0.9rem;
        }

        .order-items-container {
            margin-top: 10px;
        }

        .status-badge {
            padding: 6px 12px;
            font-weight: 500;
        }

        .custom-text {
            font-weight: bold;
        }

        /* Custom image button styling */
        .image-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="my-3">
            <h3>
                <i class="bi bi-receipt"></i> Order #{{ $order->id }}
            </h3>
        </div>

        <div class="my-2">
            <buton onclick="window.history.back()" class="btn btn-primary">
                <i class="bi bi-arrow-counterclockwise"></i> Go back
            </button>
        </div>

        <!-- Order Details -->
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Shipping Fees</th>
                    <th scope="col">Coupon Code</th>
                </tr>
            </thead>
            <tbody>
                <tr class="align-middle">
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ number_format($order->total_price, 2) }} JOD</td>
                    <td>
                        <span
                            class="badge status-badge 
                        {{ $order->status === 'pending'
                            ? 'bg-warning'
                            : ($order->status === 'shipped'
                                ? 'bg-primary'
                                : ($order->status === 'delivered'
                                    ? 'bg-success'
                                    : ($order->status === 'processing'
                                        ? 'bg-info'
                                        : 'bg-danger'))) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ number_format($order->discount_applied, 2) }} JOD</td>
                    <td>{{ $order->shipping_fees == 5.00 ? number_format($order->shipping_fees, 2) . ' JOD' : 'Free' }}</td>
                    <td>{{ $order->coupon ? $order->coupon->code : 'No Coupon' }}</td>
                </tr>

                <tr class="align-middle">
                    <td colspan="4"><strong>Delivery Address:</strong> {{ $order->delivery_address }}</td>
                    <td colspan="2"><strong>Phone Number:</strong> {{ $order->phone_number }}</td>
                    <td colspan="1"><strong>Payment Method:</strong> {{ $order->payment_method }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Order Items -->
        <h4 class="mt-4">Ordered Items</h4>
        <div class="row g-4 order-items-container">
            @foreach ($order->orderItems as $item)
                <div class="col-md-4">
                    <div class="order-item-card">
                        <img src="{{ $item->product->thumbnail ? asset('storage/' . $item->product->thumbnail) : asset('images/fallback.jpg') }}"
                            class="img-fluid w-100" alt="{{ $item->product->name }}">
                        <div class="card-content">
                            <h5>{{ $item->product->name }}</h5>
                            <p><strong>Color:</strong> {{ $item->selected_color }}</p>
                            <p><strong>Size:</strong> {{ $item->selected_size }}</p>
                            <p><strong>Quantity:</strong> {{ $item->quantity }}</p>
                            <p><strong>Price:</strong>{{ number_format($item->price, 2) }} JOD</p>

                            <!-- ✅ New: Custom Text & Text Color -->
                            @if ($item->custom_text)
                                <p class="custom-text" style="color: {{ $item->custom_text_color ?? 'black' }};">
                                    <strong>Custom Text:</strong> {{ $item->custom_text }}
                                </p>
                                <p>
                                    <strong>Text Color:</strong>
                                    <span style="display: inline-block; width: 15px; height: 15px; background-color: {{ $item->custom_text_color ?? 'black' }}; border-radius: 50%;"></span>
                                    <span>, {{ strtoupper($item->custom_text_color) }}</span>
                                </p>
                            @endif

                            <!-- ✅ New: Custom Image -->
                            @if ($item->custom_image)
                                <div class="image-buttons">
                                    <a href="{{ asset('storage/' . $item->custom_image) }}" download
                                        class="btn btn-secondary">
                                        <i class="bi bi-download"></i> Download Image
                                    </a>
                                    <button type="button" class="btn btn-info view-image" data-bs-toggle="modal"
                                        data-bs-target="#imageModal-{{ $item->id }}">
                                        <i class="bi bi-eye"></i> View Image
                                    </button>
                                </div>

                                <!-- ✅ New: Image Modal -->
                                <div class="modal fade" id="imageModal-{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="imageModalLabel-{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel-{{ $item->id }}">Custom
                                                    Image for {{ $item->product->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $item->custom_image) }}"
                                                    class="img-fluid rounded">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
