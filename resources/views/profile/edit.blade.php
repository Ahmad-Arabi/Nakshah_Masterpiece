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

        .profile-page {
            min-height: 100vh;
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

        .form-label {
            font-size: 14px;
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
                                Order History
                            </button>
                            <button id="edit-profile-tab" class="nav-link text-start">
                                Edit Profile
                            </button>
                        </div>
                    </div>

                    <!-- Content Area - Right Column -->
                    <div class="col-md-9 col-lg-10">
                        <div class="border-start ps-md-4">
                            <!-- Order History Section - Now visible by default -->
                            <div id="order-history-content">
                                <h5 class="mb-4" style="color: var(--primary);">{{ __('Order History') }}</h5>

                                @if (isset($orders) && $orders->count() > 0)
                                    <div class="order-list">
                                        @foreach ($orders as $order)
                                            <div class="card mb-3 order-item" data-order-id="{{ $order->id }}"
                                                style="cursor: pointer;">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">Order #{{ $order->id }}</h6>
                                                            <p class="text-muted small mb-0">
                                                                {{ $order->created_at->format('M d, Y') }}</p>
                                                        </div>
                                                        <div class="text-end">
                                                            <p class="fw-bold mb-1">
                                                                {{ number_format($order->total_price, 2) }} JOD</p>
                                                            <span
                                                                class="badge rounded-pill 
                                                            {{ $order->status === 'delivered'
                                                                ? 'bg-success'
                                                                : ($order->status === 'processing'
                                                                    ? 'bg-primary'
                                                                    : ($order->status === 'shipped'
                                                                        ? 'bg-warning text-dark'
                                                                        : ($order->status === 'pending'
                                                                            ? 'bg-info'
                                                                        : 'bg-secondary'))) }}">
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
                                                <div class="modal-header"
                                                    style="background-color: var(--accent); color: #fff;">
                                                    <h5 class="modal-title">
                                                        <i class="bi bi-cart-check"></i>Order Details
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="order-details-content"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center p-5"
                                        style="background-color: rgba(245, 240, 225, 0.5); border-radius: 8px;">
                                        <i class="fas fa-shopping-bag fa-3x mb-3" style="color: var(--primary);"></i>
                                        <h6>No orders yet</h6>
                                        <p class="text-muted small">Start shopping to see your orders here.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Edit Profile Section - Now hidden by default -->
                            <div id="edit-profile-content" class="d-none">
                                <form method="post" action="{{ route('profile.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <div class="row g-3 mb-3">
        
                                        <!-- Name Field -->
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">{{ __('Name') }}</label>
                                            <input id="name" name="name" type="text" class="form-control"
                                                value="{{ old('name', $user->name) }}" required autofocus
                                                autocomplete="name">
                                            @error('name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email Field -->
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">{{ __('Email') }}</label>
                                            <input id="email" name="email" type="email" class="form-control"
                                                value="{{ old('email', $user->email) }}" required
                                                autocomplete="username">
                                            @error('email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                            <div class="col-12">
                                                <div class="alert alert-warning small">
                                                    {{ __('Your email address is unverified.') }}
                                                    <button form="send-verification"
                                                        class="btn btn-link p-0 m-0 align-baseline text-decoration-none"
                                                        style="color: var(--accent);">
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
                                                value="{{ old('address', $user->address) }}"
                                                autocomplete="address-level2">
                                            @error('address')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Profile Picture Upload -->
                                        <div class="col-12">
                                            <label for="profile_picture"
                                                class="form-label">{{ __('Profile Picture') }}</label>
                                            <input id="profile_picture" name="profile_picture" type="file"
                                                class="form-control" accept=".jpeg,.jpg,.png,.gif">
                                            <div class="form-text">PNG, JPG, JPEG or GIF (max. 2MB)</div>
                                            @error('profile_picture')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Section -->
                                    <div class="mt-4 pt-4 border-top">
                                        <h5 class="mb-3" style="color: var(--primary);">{{ __('Update Password') }}
                                        </h5>
                                         <p class="text-danger small">
                                            {{ __('Please enter your current password to confirm any changes to your account.') }}
                                        </p>
                                        <p class="text-muted small mb-3">
                                            {{ __('Leave new password and confirm password fields empty if you don\'t want to change it.') }}
                                        </p>

                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="password"
                                                    class="form-label">{{ __('Password') }}</label>
                                                <input id="password" name="password" type="password"
                                                    class="form-control" autocomplete="password">
                                                @error('password', 'updatePassword')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="password"
                                                    class="form-label">{{ __('New Password') }}</label>
                                                <input id="new_password" name="new_password" type="password"
                                                    class="form-control" autocomplete="new-password">
                                                @error('password', 'updatePassword')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="password_confirmation"
                                                    class="form-label">{{ __('Confirm Password') }}</label>
                                                <input id="password_confirmation" name="new_password_confirmation"
                                                    type="password" class="form-control" autocomplete="new-password">
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
                                            <div class="alert alert-success d-inline-block ms-3 mb-0 py-1 px-3">
                                                {{ __('Saved.') }}</div>
                                        @endif
                                    </div>
                                </form>

                                <!-- Delete Account Section -->
                                <div class="mt-5 pt-4 border-top">
                                    <h5 class="mb-3" style="color: var(--accent);">{{ __('Delete Account') }}</h5>
                                    <p class="text-muted small">
                                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                                    </p>

                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#confirm-delete-modal" class="btn btn-danger"
                                        style="background-color: var(--accent); border-color: var(--accent);">
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
                            <input id="delete-password" name="password" type="password" class="form-control"
                                required>
                            @error('password', 'userDeletion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" form="delete-account-form"
                        class="btn btn-danger">{{ __('Delete Account') }}</button>
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
        });
    </script>

    <!-- Custom profile CSS and Order details script -->
    <link rel="stylesheet" href="{{ asset('user/css/profile.css') }}">
    <script src="{{ asset('js/order-details.js') }}"></script>
    </script>
</x-app-layout>
