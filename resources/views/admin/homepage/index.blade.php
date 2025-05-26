@extends('layouts.admin')

@section('style')
<link rel="stylesheet" href="/css/admin.css">
@endsection

@section('title')
    Admin : Homepage
@endsection

@section('content')
                  {{-- Table --}}
              <div class="container">
                <div class="my-3">
                  <h3>
                    <i class="bi bi-speedometer2"></i>
                    Dashoard
                  </h3>
                </div>
                
                <!-- Spinner -->
                <div id="spinner" class="text-center my-5">
                  <div class="loader text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                  </div>
                </div>

                <!-- User Table -->
                <div class="table-responsive" id="tableContainer" style="display: none;">
                  @include('admin.homepage.table') <!-- Dynamically load table -->
                </div>

                <div class="container" style="max-height: 100%">
    <div class="my-3">
        <h3>
            <i class="bi bi-graph-up"></i>
            Products & Stocks
        </h3>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Most Sold Products -->
            <div class="col-md-6 chart-container">
                <div class="chart-card">
                    <h5 class="text-center">Most Sold Products</h5>
                    <div class="table-container">
                        <table class="table table-sm table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Sold Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mostSold as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->order_items_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Low Stock Items -->
            <div class="col-md-6 chart-container">
                <div class="chart-card">
                    <h5 class="text-center">Low Stock Items</h5>
                    <div class="table-container">
                        <table class="table table-sm table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStock as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Low Stock Sizes -->
            <div class="col-md-12 chart-container">
                <div class="chart-card">
                    <h5 class="text-center">Low Stock Sizes</h5>
                    <div class="table-container">
                        <table class="table table-sm table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Size</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStockSizes as $size)
                                    <tr>
                                        <td>{{ $size->product_name }}</td>
                                        <td>{{ $size->size }}</td>
                                        <td>{{ $size->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                @endsection
                <script src="/js/admin.js"></script>  