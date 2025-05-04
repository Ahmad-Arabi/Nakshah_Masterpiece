<div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @if (isset($coupon))
                <form id="editCouponForm" action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil"></i> Edit Coupon - {{ $coupon->code }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="code" class="form-label">Coupon Code</label>
                            <input type="text" class="form-control" name="code" required
                                value="{{ $coupon->code }}">
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" class="form-control" name="discount" step="any" required
                                value="{{ $coupon->discount }}">
                        </div>
                        <div class="mb-3">
                            <label for="discount_type" class="form-label">Discount Type</label>
                            <select name="discount_type" class="form-select" required>
                                <option value="percentage"
                                    {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed
                                    Amount</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="valid_from" class="form-label">Valid From</label>
                            <input type="date" class="form-control" name="valid_from" required
                                value="{{ Carbon\Carbon::parse($coupon->valid_from)->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="valid_to" class="form-label">Valid Until</label>
                            <input type="date" class="form-control" name="valid_to" required
                                value="{{ Carbon\Carbon::parse($coupon->valid_to)->format('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ $coupon->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$coupon->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Coupon</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            @else
                <p class="text-center">No coupon data available.</p>
            @endif
        </div>
    </div>
</div>
