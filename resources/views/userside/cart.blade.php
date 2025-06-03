@section('page_title', 'My Cart')
<x-app-layout>
    <div class="cart-page">
        <div class="container py-5 mt-3 mb-5">
            <h1 class="cart-title mb-4">Your Shopping Cart</h1>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(count($cartItems) > 0)
                <div class="cart-container">
                    <div class="checkout-section d-md-none mb-3">
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg checkout-btn">
                            Proceed to Checkout <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                    <!-- Cart items for desktop -->
                    <div class="card shadow-sm d-none d-md-block">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover cart-table mb-0 cart-background">
                                    <thead class="thead">
                                        <tr>
                                            <th class="product-col">Product</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Customization</th>
                                            <th class="price-col">Price</th>
                                            <th class="quantity-col">Quantity</th>
                                            <th class="subtotal-col">Subtotal</th>
                                            <th class="action-col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart-background">
                                        @foreach($cartItems as $item)
                                            <tr class="cart-item cart-background" data-id="{{ $item['id'] }}">
                                                <td class="product-col">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset(Str::startsWith($item['image'], 'images/') ? $item['image'] : 'storage/' . $item['image']) }}" 
                                                             alt="{{ $item['name'] }}" class="cart-product-image">
                                                        <div class="product-info ms-3">
                                                            <h5 class="product-name">{{ $item['name'] }}</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $item['size'] }}</td>
                                                <td>
                                                    @if($item['selected_color'])
                                                        <div class="product-color d-flex align-items-center">
                                                            <span class="color-dot" style="background-color: {{ $item['selected_color'] }}"></span>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item['customization_type'] == 'text')
                                                        <div class="custom-text">
                                                            <p class="mb-0"><strong>Text:</strong> {{ $item['custom_text'] }}</p>
                                                            <p class="mb-0">
                                                                <strong>Color:</strong> 
                                                                <span class="color-dot" style="background-color: {{ $item['custom_text_color'] }}"></span>
                                                            </p>
                                                        </div>
                                                    @else
                                                        <div class="custom-image">
                                                            <p class="mb-0"><strong>Custom Image:</strong></p>
                                                            <img src="{{ asset('storage/' . $item['custom_image']) }}" alt="Custom Image" class="img-thumbnail custom-preview">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="price-col">{{ $item['price'] }} JOD</td>
                                                <td class="quantity-col">
                                                    <div class="quantity-control">
                                                        <button type="button" class="btn-qty decrease">-</button>
                                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="qty-input" data-id="{{ $item['id'] }}">
                                                        <button type="button" class="btn-qty increase">+</button>
                                                    </div>
                                                </td>
                                                <td class="subtotal-col">
                                                    <span class="subtotal" data-id="{{ $item['id'] }}">{{ number_format($item['subtotal'], 2) }}</span> JOD
                                                </td>
                                                <td class="action-col">
                                                    <button type="button" class="btn-remove border-0 bg-transparent p-0" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}">
                                                        <i class="fa fa-trash-o text-danger"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile cart items view -->
                    <div class="d-md-none mobile-cart">
                        @foreach($cartItems as $item)
                            <div class="card cart-item-card mb-3 cart-background" data-id="{{ $item['id'] }}">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-title product-name mb-0">{{ $item['name'] }}</h5>
                                        <button type="button" class="btn-remove border-0 bg-transparent p-0" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}">
                                            <i class="fa fa-trash-o text-danger"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <img src="{{ asset(Str::startsWith($item['image'], 'images/') ? $item['image'] : 'storage/' . $item['image']) }}" 
                                                alt="{{ $item['name'] }}" class="img-fluid rounded">
                                        </div>
                                        <div class="col-8">
                                            <div class="specs">
                                                <p class="mb-1"><strong>Size:</strong> {{ $item['size'] }}</p>
                                                
                                                @if($item['selected_color'])
                                                <p class="mb-1 d-flex align-items-center">
                                                    <strong>Color:</strong>&nbsp;
                                                    <span class="color-dot ms-1" style="background-color: {{ $item['selected_color'] }}"></span>
                                                </p>
                                                @endif
                                                
                                                @if($item['customization_type'] == 'text')
                                                <p class="mb-1"><strong>Text:</strong> {{ $item['custom_text'] }}</p>
                                                <p class="mb-1 d-flex align-items-center">
                                                    <strong>Text Color:</strong>&nbsp;
                                                    <span class="color-dot ms-1" style="background-color: {{ $item['custom_text_color'] }}"></span>
                                                </p>
                                                @else
                                                <p class="mb-1"><strong>Custom Image:</strong></p>
                                                <img src="{{ asset('storage/' . $item['custom_image']) }}" alt="Custom Image" class="img-thumbnail custom-preview" style="max-width: 50px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="price-wrap">
                                            <p class="mb-0"><strong>Price:</strong> {{ $item['price'] }} JOD</p>
                                            <p class="mb-0"><strong>Subtotal:</strong> <span class="subtotal" data-id="{{ $item['id'] }}">{{ $item['subtotal'] }}</span> JOD</p>
                                        </div>
                                        
                                        <div class="quantity-control compact">
                                            <button type="button" class="btn-qty decrease">-</button>
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="qty-input" data-id="{{ $item['id'] }}">
                                            <button type="button" class="btn-qty increase">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Cart summary section -->
                    <div class="card shadow-sm mt-4 cart-background">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="cart-summary">
                                        <h5>Cart Summary</h5>
                                        <div class="d-flex justify-content-between">
                                            <span>Total:</span>
                                            <strong class="cart-total">{{ number_format($totalPrice, 2) }} JOD</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cart actions -->
                    <div class="cart-actions d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-4">
                        <div class="action-buttons mb-3 mb-md-0 d-flex justify-content-between w-100 gap-4 d-md-block">
                            <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-2"></i> Continue Shopping
                            </a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#clearCartModal">
                                <i class="fa fa-trash-o me-2"></i> Clear Cart
                            </button>
                        </div>
                        
                        <div class="checkout-section d-none d-md-flex">
                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg checkout-btn">
                                Proceed to Checkout <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="checkout-section d-md-none">
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg checkout-btn">
                            Proceed to Checkout <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            @else
                <div class="empty-cart text-center py-5">
                    <div class="empty-cart-icon mb-3">
                        <i class="fa fa-shopping-cart fa-3x text-muted shopping-cart"></i>
                    </div>
                    <h3 class="mb-3">Your cart is empty</h3>
                    <p class="mb-4">Looks like you haven't added any products to your cart yet.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary cancel-btn">
                        <i class="fa fa-arrow-left me-2"></i> Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Delete Item Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Remove Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove <span id="delete-item-name"></span> from your cart?
                </div>
                <div class="modal-footer">
                    <a href="#" id="confirm-delete" class="btn btn-danger remove-btn">Remove</a>
                    <button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Clear Cart Modal -->
    <div class="modal fade" id="clearCartModal" tabindex="-1" aria-labelledby="clearCartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clearCartModalLabel">Clear Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to clear your entire cart? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ route('cart.clear') }}" class="btn btn-danger">Clear Cart</a>
                </div>
            </div>
        </div>
    </div>
    
    @push('styles')
        <link rel="stylesheet" href="{{ asset('user/css/cart.css') }}">
    @endpush
    
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Delete modal
                $('#deleteModal').on('show.bs.modal', function (event) {
                    const button = $(event.relatedTarget);
                    const itemId = button.data('item-id');
                    const itemName = button.data('item-name');
                    
                    const modal = $(this);
                    modal.find('#delete-item-name').text(itemName);
                    modal.find('#confirm-delete').attr('href', '{{ route("cart.remove", "") }}/' + itemId);
                });
                
                // Quantity increase/decrease
                $('.btn-qty.decrease').click(function() {
                    const input = $(this).siblings('.qty-input');
                    let value = parseInt(input.val());
                    if (value > 1) {
                        input.val(value - 1);
                        updateQuantity(input);
                    }
                });
                
                $('.btn-qty.increase').click(function() {
                    const input = $(this).siblings('.qty-input');
                    let value = parseInt(input.val());
                    input.val(value + 1);
                    updateQuantity(input);
                });
                
                $('.qty-input').on('change', function() {
                    updateQuantity($(this));
                });
                
                function updateQuantity(input) {
                    const itemId = input.data('id');
                    const quantity = input.val();
                    
                    $.ajax({
                        url: '{{ route('cart.update') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            item_id: itemId,
                            quantity: quantity
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update all instances of this item's subtotal
                                $(`span.subtotal[data-id="${itemId}"]`).text(response.subtotal);
                                $('.cart-total').text(response.total + ' JOD');
                            } else {
                                // Show error and reset to available quantity
                                alert(response.message);
                                input.val(response.available);
                            }
                        },
                        error: function() {
                            alert('Something went wrong. Please try again.');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>