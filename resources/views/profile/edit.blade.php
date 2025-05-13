<x-app-layout>
    <style>
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .profile-page .card {
            background-color: var(--transparent-light);
            border: none;
        }
        
        .profile-page .nav-link {
            transition: all 0.3s ease;
        }
        
        .profile-page .nav-link.active {
            background-color: var(--accent) !important;
            color: white !important;
        }
        
        .profile-page .nav-link:not(.active) {
            background-color: transparent;
            color: var(--primary) !important;
        }
        
        .profile-page .nav-link:not(.active):hover {
            background-color: rgba(75, 63, 114, 0.1);
        }
        
        .profile-page .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        
        .profile-page .btn-primary:hover,
        .profile-page .btn-primary:focus,
        .profile-page .btn-primary:active {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .profile-page .order-item {
            border-left: 4px solid var(--accent);
            background-color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        
        .profile-page .order-item:hover {
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
    
    <div class="container mt-5 mb-5 profile-page">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h4 class="mb-0">{{ __('Profile Settings') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Profile Sidebar - Left Column -->
                    <div class="col-md-3 col-lg-2 mb-4 mb-md-0">
                        <div class="text-center mb-3">
                            <!-- Profile Picture - Smaller Size -->
                            <div class="mx-auto mb-3  nav-color-change" style="width: 100px; height: 100px;">
                                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default.png') }}"
                                     alt="{{ $user->name }}" class="rounded-circle img-fluid border"
                                     style="width: 100px; height: 100px; object-fit: cover; border-color: var(--accent) !important; border-width: 3px !important;">
                            </div>
                            
                            <!-- User Name -->
                            <h5 class="fw-bold" style="color: var(--primary);">{{ $user->name }}</h5>
                            
                            <!-- User Email -->
                            <p class="text-muted small">{{ $user->email }}</p>
                        </div>
                        
                        <!-- Navigation Tabs - Changed order to show Order History first -->
                        <div class="nav flex-column nav-pills">
                            <button id="order-history-tab" class="nav-link active text-start mb-2">
                                <i class="fas fa-shopping-bag me-2"></i> Order History
                            </button>
                            <button id="edit-profile-tab" class="nav-link text-start">
                                <i class="fas fa-user-edit me-2"></i> Edit Profile
                            </button>
                        </div>
                    </div>
                    
                    <!-- Content Area - Right Column -->
                    <div class="col-md-9 col-lg-10">
                        <div class="border-start ps-md-4">
                            <!-- Order History Section - Now visible by default -->
                            <div id="order-history-content">
                                <h5 class="mb-4" style="color: var(--primary);">{{ __('Order History') }}</h5>
                                
                                @if($user->orders && $user->orders->count() > 0)
                                    <div class="order-list">
                                        @foreach($user->orders as $order)
                                            <div class="card mb-3 order-item" data-order-id="{{ $order->id }}" 
                                                style="cursor: pointer;">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">Order #{{ $order->id }}</h6>
                                                            <p class="text-muted small mb-0">{{ $order->created_at->format('M d, Y') }}</p>
                                                        </div>
                                                        <div class="text-end">
                                                            <p class="fw-bold mb-1">{{ number_format($order->total_price, 2) }} JOD</p>
                                                            <span class="badge rounded-pill 
                                                            {{ $order->status === 'completed' ? 'bg-success' : 
                                                             ($order->status === 'processing' ? 'bg-primary' : 'bg-warning') }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Order Details Modal -->
                                    <div class="modal fade" id="order-details-modal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: var(--primary);">Order Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="order-details-content"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center p-5" style="background-color: rgba(245, 240, 225, 0.5); border-radius: 8px;">
                                        <i class="fas fa-shopping-bag fa-3x mb-3" style="color: var(--primary);"></i>
                                        <h6>No orders yet</h6>
                                        <p class="text-muted small">Start shopping to see your orders here.</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Edit Profile Section - Now hidden by default -->
                            <div id="edit-profile-content" class="d-none">
                                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <div class="row g-3 mb-3">
                                        <!-- Name Field -->
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">{{ __('Name') }}</label>
                                            <input id="name" name="name" type="text" class="form-control" 
                                                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                            @error('name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email Field -->
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">{{ __('Email') }}</label>
                                            <input id="email" name="email" type="email" class="form-control" 
                                                value="{{ old('email', $user->email) }}" required autocomplete="username">
                                            @error('email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                            <div class="col-12">
                                                <div class="alert alert-warning small">
                                                    {{ __('Your email address is unverified.') }}
                                                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-decoration-none" style="color: var(--accent);">
                                                        {{ __('Click here to re-send the verification email.') }}
                                                    </button>
                                                </div>
                                                @if (session('status') === 'verification-link-sent')
                                                    <div class="alert alert-success small">
                                                        {{ __('A new verification link has been sent to your email address.') }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Phone Field -->
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                                            <input id="phone" name="phone" type="text" class="form-control" 
                                                value="{{ old('phone', $user->phone) }}" autocomplete="tel">
                                            @error('phone')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Address Field -->
                                        <div class="col-md-6">
                                            <label for="address" class="form-label">{{ __('Address') }}</label>
                                            <input id="address" name="address" type="text" class="form-control" 
                                                value="{{ old('address', $user->address) }}" autocomplete="address-level2">
                                            @error('address')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Profile Picture Upload -->
                                        <div class="col-12">
                                            <label for="profile_picture" class="form-label">{{ __('Profile Picture') }}</label>
                                            <input id="profile_picture" name="profile_picture" type="file" class="form-control" accept=".jpeg,.jpg,.png,.gif">
                                            <div class="form-text">PNG, JPG, JPEG or GIF (max. 2MB)</div>
                                            @error('profile_picture')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Section -->
                                    <div class="mt-4 pt-4 border-top">
                                        <h5 class="mb-3" style="color: var(--primary);">{{ __('Update Password') }}</h5>
                                        <p class="text-muted small mb-3">{{ __('Leave password fields empty if you don\'t want to change it.') }}</p>

                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                                                <input id="current_password" name="current_password" type="password" 
                                                    class="form-control" autocomplete="current-password">
                                                @error('current_password', 'updatePassword')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="password" class="form-label">{{ __('New Password') }}</label>
                                                <input id="password" name="password" type="password" 
                                                    class="form-control" autocomplete="new-password">
                                                @error('password', 'updatePassword')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                                <input id="password_confirmation" name="password_confirmation" type="password" 
                                                    class="form-control" autocomplete="new-password">
                                                @error('password_confirmation', 'updatePassword')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Save Changes') }}
                                        </button>

                                        @if (session('status') === 'profile-updated')
                                            <div class="alert alert-success d-inline-block ms-3 mb-0 py-1 px-3">{{ __('Saved.') }}</div>
                                        @endif
                                    </div>
                                </form>

                                <!-- Delete Account Section -->
                                <div class="mt-5 pt-4 border-top">
                                    <h5 class="mb-3" style="color: var(--accent);">{{ __('Delete Account') }}</h5>
                                    <p class="text-muted small">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>

                                    <button type="button" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal"
                                        class="btn btn-danger" style="background-color: var(--accent); border-color: var(--accent);">
                                        {{ __('Delete Account') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div class="modal fade" id="confirm-delete-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Are you sure you want to delete your account?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>
                    
                    <form id="delete-account-form" method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="delete-password" name="password" type="password" class="form-control" required>
                            @error('password', 'userDeletion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" form="delete-account-form" class="btn btn-danger">{{ __('Delete Account') }}</button>
                </div>
            </div>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- JavaScript for tab switching -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editProfileTab = document.getElementById('edit-profile-tab');
            const orderHistoryTab = document.getElementById('order-history-tab');
            const editProfileContent = document.getElementById('edit-profile-content');
            const orderHistoryContent = document.getElementById('order-history-content');
            
            // Tab switching
            editProfileTab.addEventListener('click', function() {
                editProfileContent.classList.remove('d-none');
                orderHistoryContent.classList.add('d-none');
                editProfileTab.classList.add('active');
                orderHistoryTab.classList.remove('active');
            });
            
            orderHistoryTab.addEventListener('click', function() {
                editProfileContent.classList.add('d-none');
                orderHistoryContent.classList.remove('d-none');
                orderHistoryTab.classList.add('active');
                editProfileTab.classList.remove('active');
            });
            
            // Order details modal
            const orderItems = document.querySelectorAll('.order-item');
            const orderDetailsModal = new bootstrap.Modal(document.getElementById('order-details-modal'));
            const orderDetailsContent = document.getElementById('order-details-content');
            
            orderItems.forEach(item => {
                item.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    // Fetch order details via AJAX
                    fetch(`/orders/${orderId}/details`)
                        .then(response => response.json())
                        .then(data => {
                            // Fill the modal with order details
                            let itemsHtml = '';
                            data.items.forEach(item => {
                                // Ensure price is a number
                                const itemPrice = parseFloat(item.price);
                                const itemTotal = parseFloat(item.total);
                                
                                // Check for custom options
                                const hasCustomText = item.options.custom_text && item.options.custom_text.trim() !== '';
                                const hasCustomImage = item.options.custom_image && item.options.custom_image.trim() !== '';
                                
                                itemsHtml += `
                                    <div class="border-bottom py-3">
                                        <div class="row align-items-start">
                                            <div class="col-8 d-flex">
                                                <img src="${item.thumbnail}" alt="${item.product_name}" class="rounded" 
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                <div class="ms-3">
                                                    <p class="fw-medium mb-1">${item.product_name}</p>
                                                    <p class="text-muted small mb-0">Qty: ${item.quantity}</p>
                                                    ${item.options.size ? `<p class="text-muted small mb-0">Size: ${item.options.size}</p>` : ''}
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <p class="fw-medium">${itemPrice.toFixed(2)} JOD</p>
                                            </div>
                                        </div>
                                        
                                        ${hasCustomText ? `
                                        <div class="row mt-2">
                                            <div class="col-12 ps-5 ms-4">
                                                <div class="d-flex align-items-center">
                                                    <span class="small fw-medium me-2" style="color: var(--primary);">Custom Text:</span>
                                                    <span class="small px-2 py-1 rounded" style="
                                                        background-color: rgba(245, 240, 225, 0.5); 
                                                        color: ${item.options.custom_text_color || '#000000'};
                                                        border: 1px solid #e5e0d1;
                                                    ">${item.options.custom_text}</span>
                                                </div>
                                            </div>
                                        </div>
                                        ` : ''}
                                        
                                        ${hasCustomImage ? `
                                        <div class="row mt-2">
                                            <div class="col-12 ps-5 ms-4">
                                                <span class="small fw-medium d-block mb-1" style="color: var(--primary);">Custom Image:</span>
                                                <img src="${item.options.custom_image}" alt="Custom Image" 
                                                    class="border rounded" style="height: 60px; object-fit: contain;">
                                            </div>
                                        </div>
                                        ` : ''}
                                    </div>
                                `;
                            });
                            
                            // Ensure all monetary values are numbers
                            const subtotal = parseFloat(data.order.subtotal);
                            const shipping = data.order.shipping_fees;

                            const discount = parseFloat(data.order.discount || 0);
                            const total = parseFloat(data.order.total_price);
                            console.log(data.order);
                            orderDetailsContent.innerHTML = `
                                <div class="border-bottom pb-3 mb-3">
                                    <div class="row mb-2">
                                        <div class="col-6 text-muted small">Order #${data.order.id}</div>
                                        <div class="col-6 text-end text-muted small">${data.order.date}</div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-6 text-muted small">Status:</div>
                                        <div class="col-6 text-end fw-medium" style="color: var(--primary);">${data.order.status}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 text-muted small">Shipping Address:</div>
                                        <div class="col-6 text-end small">${data.order.delivery_address}</div>
                                    </div>
                                </div>
                                
                                <h6 class="fw-medium mb-3" style="color: var(--primary);">Items</h6>
                                <div class="mb-4">
                                    ${itemsHtml}
                                </div>
                                
                                <div class="border-top pt-3 mt-3">
                                    <div class="row mb-1">
                                        <div class="col-6 text-muted small">Subtotal:</div>
                                        <div class="col-6 text-end fw-medium">${subtotal.toFixed(2)} JOD</div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-6 text-muted small">Shipping:</div>
                                        <div class="col-6 text-end fw-medium">${shipping}</div>
                                    </div>
                                    ${discount > 0 ? 
                                    `<div class="row mb-1">
                                        <div class="col-6 text-muted small">Discount:</div>
                                        <div class="col-6 text-end fw-medium text-danger">-${discount.toFixed(2)} JOD</div>
                                    </div>` : ''}
                                    <div class="row border-top pt-2 mt-2">
                                        <div class="col-6 fw-medium" style="color: var(--primary);">Total:</div>
                                        <div class="col-6 text-end fw-medium" style="color: var(--primary);">${total.toFixed(2)} JOD</div>
                                    </div>
                                </div>
                            `;
                            
                            orderDetailsModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching order details:', error);
                            orderDetailsContent.innerHTML = '<div class="alert alert-danger">Error loading order details. Please try again.</div>';
                            orderDetailsModal.show();
                        });
                });
            });
        });
    </script>
</x-app-layout>
