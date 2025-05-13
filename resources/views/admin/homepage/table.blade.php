<style>
    .container {
        overflow: hidden;
    }
  .chart-container {
      margin-bottom: 30px;
  }
  .chart-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }
  .table-container {
      margin-top: 15px;
  }
  .table th, .table td {
      vertical-align: middle;
  }
</style>
<div class="container py-5 mt-2">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xl-5 g-4 dashboard_tiles justify-content-center"> 

        <!-- Total Orders -->
        <a href="{{ route('admin.orders.index') }}" class="col">
            <div class="card3d text-center">
                <div class="card-body">
                    <i class="bi bi-cart-check fs-2 text-primary"></i>
                    <h6 class="card-title mt-2">Total Orders</h6>
                    <p class="card-text fw-bold">{{ $totalOrders }}</p>
                    {{-- <small class="text-muted">
                        <i class="bi bi-check-circle text-success"></i> Delivered: {{ $completedOrders }}
                    </small> --}}
                    <small class="text-muted">
                        <i class="bi bi-hourglass-split text-warning"></i> Pending: {{ $pendingOrders }}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-graph-up-arrow text-success"></i> Monthly Revenue: {{ number_format($monthlyRevenue, 2) }} JOD
                    </small>
                </div>
            </div>
        </a>

        <!-- Total Users -->
        <a href="{{ route('admin.users.index') }}" class="col">
            <div class="card3d text-center">
                <div class="card-body">
                    <i class="bi bi-people fs-2 text-secondary"></i>
                    <h6 class="card-title mt-2">Total Users</h6>
                    <p class="card-text fw-bold">{{ $totalUsers }}</p>
                    <small class="text-muted">
                        <i class="bi bi-person-badge text-info"></i> Admins: {{ $adminUsers }}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-calendar-plus text-primary"></i> New This Month: {{ $newUsersThisMonth }}
                    </small>
                </div>
            </div>
        </a>

        <!-- Total Products -->
        <a href="{{ route('admin.products.index') }}" class="col">
            <div class="card3d text-center">
                <div class="card-body">
                    <i class="bi bi-box-seam fs-2 text-success"></i>
                    <h6 class="card-title mt-2">Total Products</h6>
                    <p class="card-text fw-bold">{{ $totalProducts }}</p>
                    <small class="text-muted">
                        <i class="bi bi-exclamation-triangle text-danger"></i> Low Stock: {{ $lowStockProducts }}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-fire text-primary"></i> Most Ordered: {{ $mostOrderedItem->name ?? 'N/A' }}
                    </small>
                </div>
            </div>
        </a>

        <!-- Coupons Overview  -->
        <a href="{{ route('admin.coupons.index') }}" class="col">
            <div class="card3d text-center">
                <div class="card-body">
                    <i class="bi bi-ticket-perforated fs-2 text-danger"></i>
                    <h6 class="card-title mt-2">Total Coupons</h6>
                    <p class="card-text fw-bold">{{ $totalCoupons }}</p>
                    <small class="text-muted">
                        <i class="bi bi-check-circle-fill text-success"></i> Active Coupons: {{ $activeCoupons }}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-fire text-warning"></i> Most Used: {{ $mostUsedCoupon->coupon->code ?? 'N/A' }}
                    </small>
                </div>
            </div>
        </a>

        <!-- Reviews Overview (✅ Kept Original Stats & Centered in Layout) -->
        <a href="{{ route('admin.reviews.index') }}" class="col">
            <div class="card3d text-center">
                <div class="card-body">
                    <i class="bi bi-chat-square-dots fs-2 text-info"></i>
                    <h6 class="card-title mt-2">Total Reviews</h6>
                    <p class="card-text fw-bold">{{ $totalReviews }}</p>
                    <small class="text-muted">
                        <i class="bi bi-hourglass-bottom text-danger"></i> Pending Approval: {{ $pendingReviews }}
                    </small>
                </div>
            </div>
        </a>

    </div>
    <div>
</div>
