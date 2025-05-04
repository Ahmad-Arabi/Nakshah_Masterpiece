@extends('layouts.admin')

@section('title')
    Order History
@endsection

@section('style')
<link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
<div class="container">
    <div class="my-3">
        <h3>
            <i class="bi bi-cart-check"></i>
            Order History
        </h3>
    </div>

    <div class="my-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-counterclockwise"></i> Go back
        </a>
    </div>

    <table class="table table-striped table-hover">
        <thead>
        <tr class="table-dark">
            <th scope="col">Ordered At</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Delivery Address</th>
            <th scope="col">Total Price</th>
            <th scope="col">Coupon</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @if ($orders->count())
                @foreach ($orders as $order)
                    <tr class="align-middle">
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $order->phone_number }}</td>
                        <td>{{ $order->delivery_address }}</td>
                        <td>{{ number_format($order->total_price, 2) }} JOD</td>
                        <td>{{ $order->coupon->code ?? 'None' }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'canceled' ? 'danger' : 'warning'))) }}">
                                {{ ucfirst($order->status) }}
                            </span> <!-- ✅ Styled order status -->
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-eye"></i> View Order
                            </a> <!-- ✅ Redirect to the Order show page -->
                        </td>
                    </tr>
                @endforeach
            @else
            <tr class="align-middle">
                <td colspan="7" class="text-center">This user has no orders yet.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection