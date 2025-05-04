@extends('layouts.admin')

@section('title')
    Product Details
@endsection

@section('style')
    <link rel="stylesheet" href="/css/admin.css">
    <style>
        .product-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .product-card h3 {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .product-card .carousel img {
            border-radius: 10px;
            margin: auto;
        }

        .product-card .row {
            margin-top: 20px;
        }

        .product-card .list-group-item {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .image {
            max-width: 100%;
            height: 250px;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="my-3">
            <h3>
                <i class="bi bi-cart-check"></i>
                {{ $product->name }}'s Details
            </h3>
        </div>

        <div class="my-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-counterclockwise"></i>
                Go back</a>
        </div>
        <div class="product-card shadow">
            <div class="card-body">
                <h3 class="card-title text-center">{{ $product->name }}</h3>
                <h6 class="text-muted text-center">Category: {{ $product->category->name }}</h6>

                <div id="productCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-inner text-center">
                        <div class="carousel-item active">
                            <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : asset('images/fallback.jpg') }}"
                                class="d-block img-fluid image" alt="Product Thumbnail">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ $product->image1 ? asset('storage/' . $product->image1) : asset('images/fallback.jpg') }}"
                                class="d-block img-fluid image" alt="Product Image 1">
                        </div>
                        <div class="carousel-item ">
                            <img src="{{ $product->image2 ? asset('storage/' . $product->image2) : asset('images/fallback.jpg') }}"
                                class="d-block img-fluid image" alt="Product Image 2">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <p><strong>Color:</strong> {{ $product->color }}</p>
                        <p><strong>Price:</strong> {{ number_format($product->price, 2) }} JOD</p>
                        <p><strong>Stock Quantity:</strong> {{ $product->quantity }}</p>
                        <p>
                            <strong>Featured:</strong>
                            @if ($product->isFeatured)
                                <span class="badge bg-success">Featured</span>
                            @else
                                <span class="badge bg-secondary">Regular</span>
                            @endif
                        </p>
                        </p>

                        <!-- Stock Status Column -->
                        <p>
                            <strong>Stock Status:</strong>
                            @if ($product->isActive > 0)
                                <span class="badge bg-primary">In Stock</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Available Sizes</h5>
                        <ul class="list-group">
                            @foreach ($product->productSizes as $size)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $size->size }}</span>
                                    <span>Stock: {{ $size->stock }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
