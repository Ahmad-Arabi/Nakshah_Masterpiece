<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            @if (isset($order))
                <form id="editOrderForm" action="{{ route('admin.orders.update', $order->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil"></i> Edit Order #{{ $order->id }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!--  Status -->
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="status" class="form-label text-danger">Order Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="processing"
                                            {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>
                                            Canceled</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        required value="{{ $order->phone_number }}">
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Address -->
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label for="delivery_address" class="form-label">Delivery Address</label>
                                <input type="text" class="form-control" id="delivery_address" name="delivery_address"
                                    required value="{{ $order->delivery_address }}">
                            </div>
                        </div>

                        <!-- Order Items -->
                        <h5 class="mt-4">Ordered Items</h5>
                        <div class="row g-4 d-flex align-items-stretch">
                            @foreach ($order->orderItems as $index => $item)
                                <div class="col-md-6 col-12">
                                    <div class="order-item card border p-3 shadow-sm h-100">
                                        <label class="mb-3 fw-bold">{{ $item->product->name }}</label>
                                        <input type="hidden" name="order_items[{{ $index }}][product_id]"
                                            value="{{ $item->product_id }}">

                                        <!-- Size -->
                                        <div class="mb-2">
                                            <label for="order_items[{{ $index }}][selected_size]"
                                                class="form-label">Selected Size</label>
                                            @if ($item->product->productSizes && count($item->product->productSizes))
                                                <select class="form-select"
                                                    name="order_items[{{ $index }}][selected_size]" required>
                                                    @foreach ($item->product->productSizes as $sizeOption)
                                                        <option value="{{ $sizeOption->size }}"
                                                            {{ $item->selected_size == $sizeOption->size ? 'selected' : '' }}
                                                            {{ $sizeOption->stock == 0 ? 'disabled' : '' }}>
                                                            <!--  Disable if stock is 0 -->
                                                            {{ $sizeOption->size }} ({{ $sizeOption->stock }} in
                                                            stock)
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <p class="text-danger">No sizes available for this product.</p>
                                            @endif
                                        </div>

                                        <!-- Custom Text -->
                                        @if ($item->custom_text)
                                            <div class="row g-2">
                                                <label>Custom Text</label>
                                                <div class="col-12 d-flex align-items-center">
                                                    <input type="text" class="form-control me-2"
                                                        name="order_items[{{ $index }}][custom_text]"
                                                        value="{{ $item->custom_text }}">
                                                    <input type="color" class="form-control"
                                                        name="order_items[{{ $index }}][custom_text_color]"
                                                        value="{{ $item->custom_text_color }}"
                                                        style="height: 100%; min-height: 38px;">
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Custom Image -->
                                        @if ($item->custom_image)
                                            <div class="mb-2 text-center">
                                                <label>Current Custom Image</label>
                                                <img src="{{ asset('storage/' . $item->custom_image) }}"
                                                    class="img-thumbnail" width="100">
                                            </div>

                                            <div class="mb-2">
                                                <label for="order_items[{{ $index }}][custom_image]"
                                                    class="form-label">Upload New Custom Image</label>
                                                <input type="file" class="form-control"
                                                    name="order_items[{{ $index }}][custom_image]"
                                                    accept=".jpeg,.jpg,.png">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Order</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
