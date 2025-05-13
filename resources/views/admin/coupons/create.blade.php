<div class="modal fade" id="createCouponModal" tabindex="-1" aria-labelledby="createCouponLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-percent"></i> Add New Coupon
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
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="code" class="form-label">Coupon Code</label>
                        <input type="text" class="form-control" name="code" required
                            placeholder="Enter a unique code" value="{{ old('code') }}">
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount</label>
                        <input type="number" class="form-control" name="discount" step="any" required
                            placeholder="Enter discount value" value="{{ old('discount') }}">
                    </div>

                    <div class="mb-3">
                        <label for="discount_type" class="form-label">Discount Type</label>
                        <select name="discount_type" class="form-select" required>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="valid_from" class="form-label">Valid From</label>
                        <input type="date" class="form-control" name="valid_from" required
                            value="{{ old('valid_from') }}">
                    </div>

                    <div class="mb-3">
                        <label for="valid_to" class="form-label">Valid Until</label>
                        <input type="date" class="form-control" name="valid_to" required
                            value="{{ old('valid_to') }}">
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="is_featured" class="form-label">Featured</label>
                        <select name="is_featured" class="form-select" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary">Create Coupon</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
