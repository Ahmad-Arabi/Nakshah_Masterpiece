@extends('layouts.admin')

@section('style')
<link rel="stylesheet" href="/css/admin.css">
<style>
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
@endsection

@section('title')
    Admin : Products & Stocks
@endsection

@section('content')
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