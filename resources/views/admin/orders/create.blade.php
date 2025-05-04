<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-file-plus"></i> Add New Order
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.orders.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Customer Selection -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Customer</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="" disabled selected>-- Select the customer --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Coupon Selection (Without Frontend Calculation) -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="coupon_id" class="form-label">Coupon (Optional)</label>
                                <select class="form-select" id="coupon_id" name="coupon_id">
                                    <option value="" disabled selected>-- Select a coupon --</option>
                                    @foreach ($coupons as $coupon)
                                        <option value="{{ $coupon->id }}">
                                            {{ $coupon->code }} 
                                            ({{ $coupon->discount_type === 'fixed' ? '$' . number_format($coupon->discount, 2) : $coupon->discount . '%' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-muted">
                                The selected discount will be applied to the total price during order processing.
                            </small> <!-- ✅ New: Inform users that discount is backend-processed -->
                        </div>
                    </div>

                    <div class="row">
                        <!-- Price & Status -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="total_price" class="form-label">Total Price (JOD)</label>
                                <input type="number" step="any" class="form-control" id="total_price" name="total_price" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="status" class="form-label">Order Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="" disabled selected>-- Select order status --</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- ✅ New: Delivery Address & Phone -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="delivery_address" class="form-label">Delivery Address</label>
                                <input type="text" class="form-control" id="delivery_address" name="delivery_address" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary">Create Order</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>