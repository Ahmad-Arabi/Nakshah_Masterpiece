<x-app-layout>
    <div class="checkout-page">
        <div class="container mt-3 mb-5">
            <h1 class="checkout-title mb-4">Checkout</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="d-grid gap-2 my-3 mx-1 justify-content-start ">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-2"></i> Return to Cart
                    </a>
                </div>

                <!-- Checkout Form -->
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Delivery Information</h5>
                        </div>
                        <div class="card-body">
                            <form id="checkoutForm" action="{{ route('checkout.place-order') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="delivery_address" class="form-label">Delivery Address</label>
                                    <input type="text" class="form-control" id="delivery_address"
                                        name="delivery_address"
                                        value="{{ old('delivery_address', $user->address ?? '') }}" required>
                                </div>

                                <div class="mb-4">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        value="{{ old('phone_number', $user->phone ?? '') }}" required>
                                </div>

                                <div class=" p-0 mb-3">
                                    <h5 class="mb-0">Payment Method</h5>
                                </div>

                                <div class="payment-methods mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="cash_on_delivery" value="cash_on_delivery" checked>
                                        <label class="form-check-label" for="cash_on_delivery">
                                            <i class="fa fa-money me-2"></i> Cash on Delivery
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="credit_card" value="credit_card">
                                        <label class="form-check-label" for="credit_card">
                                            <i class="fa fa-credit-card me-2"></i> Credit Card
                                        </label>
                                    </div>
                                </div>

                                <!-- Credit card form fields (initially hidden) -->

                                <input type="hidden" name="stripeToken" id="stripeToken">
                                <input type="hidden" name="total_price" id="total_price"
                                    value="{{ $totalPrice }}">
                                <div id="card-element" style="display: none;"
                                    class="card-payment-form mb-4 form-control py-2">
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-lg order-button"
                                        onclick="handlePayment(event)">
                                        Place Order <i class="fa fa-check-circle ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card shadow-sm order-summary">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="order-items">
                                @foreach ($cartItems as $item)
                                    <div class="order-item d-flex p-3 border-bottom">
                                        <div class="order-item-image me-3">
                                            <img src="{{ asset(Str::startsWith($item['image'], 'images/') ? $item['image'] : 'storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}" class="img-fluid rounded" width="60">
                                        </div>
                                        <div class="order-item-details flex-grow-1">
                                            <h6 class="item-name mb-1">{{ $item['name'] }}</h6>
                                            <div class="item-specs small text-muted">
                                                <div>Size: {{ $item['size'] }}</div>
                                                <div>Quantity: {{ $item['quantity'] }}</div>
                                            </div>
                                        </div>
                                        <div class="order-item-price text-end">
                                            <span class="price">{{ $item['subtotal'] }} JOD</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="order-totals p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong>{{ $subtotal }} JOD</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <strong>
                                        @if ($shippingFees !== 'Free')
                                            {{ number_format($shippingFees, 2) . 'JOD' }}
                                        @else
                                            {{ $shippingFees }}
                                        @endif
                                    </strong>
                                </div>

                                @if ($discount > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span>Discount:</span>
                                        <strong>-{{ $discount }} JOD</strong>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span class="order-total">{{ $totalPrice }} JOD</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coupon Code Section - Moved below the order summary -->
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Have a coupon?</h5>
                        </div>
                        <div class="card-body">
                            @if ($appliedCoupon)
                                <div class="applied-coupon mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-success me-2">Applied</span>
                                            <strong>{{ $appliedCoupon['code'] }}</strong>
                                            <span class="text-muted ms-2">
                                                @if ($appliedCoupon['discount_type'] === 'percentage')
                                                    ({{ $appliedCoupon['discount'] }}% off)
                                                @else
                                                    ({{ $appliedCoupon['discount'] }} JOD off)
                                                @endif
                                            </span>
                                        </div>
                                        <form action="{{ route('checkout.remove-coupon') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-times me-1"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('checkout.apply-coupon') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="coupon_code"
                                            placeholder="Enter coupon code">
                                        <button type="submit"
                                            class="btn btn-outline-primary apply-btn">Apply</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('user/css/checkout.css') }}">
    @endpush

    @push('scripts')
        <script src="https://js.stripe.com/basil/stripe.js"></script>
        <script>
            var stripe = Stripe('{{ env('STRIPE_KEY') }}');
            var elements = stripe.elements();
            var cardElement = elements.create('card');
            cardElement.mount('#card-element');

            function handlePayment(event) {
                let selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;

                if (selectedPayment === 'credit_card') {
                    event.preventDefault(); // Prevent form submission
                    createToken(); // Call Stripe token generation function
                }
            }

            function createToken() {
                stripe.createToken(cardElement).then(function(result) {
                    // console.log(result);
                    if (result.token) {

                        document.getElementById('stripeToken').value = result.token.id;
                        document.getElementById('checkoutForm').submit();
                    }

                });
            }

                

        </script>
        <script>
            $(document).ready(function() {
                // Toggle credit card form visibility
                $('input[name="payment_method"]').change(function() {
                    if ($(this).val() === 'credit_card') {
                        $('#card-element').slideDown();
                    } else {
                        $('#card-element').slideUp();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
