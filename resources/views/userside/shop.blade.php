<x-app-layout>
    <!-- Featured Products Carousel Section -->
    <div class="featured-bg py-5  nav-color-change">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading mb-4 ">
                        <h2 >Featured Products</h2>
                    </div>
                </div>
            </div>
            
            <!-- Bootstrap Carousel -->
            <div id="featuredCarousel" class="carousel slide featured-carousel" data-ride="carousel">
                <ol class="carousel-indicators">
                    @if(count($featuredProducts) > 0)
                        @for($i = 0; $i < ceil(count($featuredProducts) / 4); $i++)
                            <li data-target="#featuredCarousel" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
                        @endfor
                    @else
                        <li data-target="#featuredCarousel" data-slide-to="0" class="active"></li>
                    @endif
                </ol>
                
                <div class="carousel-inner">
                    @if(count($featuredProducts) > 0)
                        @foreach($featuredProducts->chunk(4) as $key => $chunk)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="row">
                                    @foreach($chunk as $product)
                                        <div class="col-6 col-sm-5 col-lg-3 col-md-4 py-3">
                                            <div class="card h-100 mb-0">
                                                <a href="{{ route('product.show', $product->id) }}">
                                                    @if($product->thumbnail)
                                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}">
                                                    @else
                                                        <img src="{{ asset('images/fallback.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                                                    @endif
                                                </a>
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $product->name }}</h5>
                                                    
                                                    @if($product->category)
                                                        <div class="category-text">
                                                            <a href="{{ route('shop', ['category' => $product->category->id]) }}" class="category-link">
                                                                {{ $product->category->name }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                    
                                                    <div class="stars-rating">
                                                        <ul class="stars">
                                                            @php 
                                                                $approvedReviews = $product->reviews->where('is_approved', 1);
                                                                $reviewCount = $approvedReviews->count();
                                                                $rating = $reviewCount > 0 ? $approvedReviews->avg('rating') : 0;
                                                                $fullStars = floor($rating);
                                                                $halfStar = $rating - $fullStars >= 0.5;
                                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                            @endphp
                                                            
                                                            @for($i = 0; $i < $fullStars; $i++)
                                                                <li><i class="fa fa-star"></i></li>
                                                            @endfor
                                                            
                                                            @if($halfStar)
                                                                <li><i class="fa fa-star-half-o"></i></li>
                                                            @endif
                                                            
                                                            @for($i = 0; $i < $emptyStars; $i++)
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endfor
                                                        </ul>
                                                        <span class="review-count">({{ $reviewCount }})</span>
                                                    </div>
                                                    
                                                    <div class="d-flex justify-content-between">
                                                        @if($product->color)
                                                            <div class="color-display">
                                                                <div class="color-circle" style="background-color: {{ $product->color }};"></div>
                                                                <span class="color-name">{{ $product->color }}</span>
                                                            </div>
                                                        @endif
                                                        
                                                        <p class="card-text price">{{ $product->price }} JOD</p>
                                                    </div>
                                                    
                                                    <a href="{{ route('product.show', $product->id) }}" class="customize-btn text-center d-block">
                                                        Customize
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-12 text-center py-5 bg-white">
                                    <h3>No featured products found</h3>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <a class="carousel-control-prev" href="#featuredCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#featuredCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Horizontal Filters - Now directly below featured section without margins -->
    <div class="filter-section">
        <div class="container-fluid ">
            <h4 class="mb-3">Find Your Product</h4>

            <form action="{{ route('shop') }}" method="GET" class="filter-form">
                <div class="form-group">
                    <label for="search">Search</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" 
                            placeholder="Product name..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group d-none d-sm-block">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-none d-sm-block">
                    <label for="color">Color</label>
                    <select class="form-control" id="color" name="color">
                        <option value="">Any Color</option>
                        @foreach($colors as $colorObj)
                            <option value="{{ $colorObj->color }}" {{ request('color') == $colorObj->color ? 'selected' : '' }}>
                                {{ $colorObj->color }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-none d-sm-block">
                    <label for="size">Size</label>
                    <select class="form-control" id="size" name="size">
                        <option value="">Any Size</option>
                        @foreach($sizes as $sizeObj)
                            <option value="{{ $sizeObj->size }}" {{ request('size') == $sizeObj->size ? 'selected' : '' }}>
                                {{ $sizeObj->size }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-none d-sm-block">
                    <label for="sort">Sort By</label>
                    <select class="form-control" id="sort" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    </select>
                </div>

                <div class="filter-buttons d-none d-sm-block ">
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>


    <!-- Main Products Section -->
    <div class="container my-4 " id="product-grid">
        <div class="row r">
            <!-- Products Grid -->
            <div class="col-12">
                <div class="row mb-3 ">
                    <div class="col-12 shop-search-header">
                        <h2>All Products</h2>
                        <p>{{ $products->total() }} products found</p>
                    </div>
                </div>

                <div class="row products-row ">
                    @forelse($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6 mb-4">
                            <div class="card product-card">
                                <a href="{{ route('product.show', $product->id) }}">
                                    @if($product->thumbnail)
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('images/fallback.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                                    @endif
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    
                                    @if($product->category)
                                        <div class="category-text">
                                            <a href="{{ route('shop', ['category' => $product->category->id]) }}" class="category-link">
                                                {{ $product->category->name }}
                                            </a>
                                        </div>
                                    @endif
                                    
                                    <div class="stars-rating mb-2">
                                        <ul class="stars">
                                            @php 
                                                $approvedReviews = $product->reviews->where('is_approved', 1);
                                                $reviewCount = $approvedReviews->count();
                                                $rating = $reviewCount > 0 ? $approvedReviews->avg('rating') : 0;
                                                $fullStars = floor($rating);
                                                $halfStar = $rating - $fullStars >= 0.5;
                                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                            @endphp
                                            
                                            @for($i = 0; $i < $fullStars; $i++)
                                                <li><i class="fa fa-star"></i></li>
                                            @endfor
                                            
                                            @if($halfStar)
                                                <li><i class="fa fa-star-half-o"></i></li>
                                            @endif
                                            
                                            @for($i = 0; $i < $emptyStars; $i++)
                                                <li><i class="fa fa-star-o"></i></li>
                                            @endfor
                                        </ul>
                                        <span class="review-count">({{ $reviewCount }})</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        @if($product->color)
                                            <div class="color-display">
                                                <div class="color-circle" style="background-color: {{ $product->color }};"></div>
                                                <span class="color-name">{{ $product->color }}</span>
                                            </div>
                                        @endif
                                        
                                        <p class="card-text price">{{ $product->price }} <span class="currency">JOD</span></p>
                                    </div>
                                    
                                    <a href="{{ route('product.show', $product->id) }}" class="customize-btn text-center d-block">
                                        Customize
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h3>No products found</h3>
                            <p>Try adjusting your search or filter criteria</p>
                        </div>
                    @endforelse
                </div>

                <!-- Bootstrap 4 Pagination -->
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            @if ($products->lastPage() > 1)
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Page Number Links --}}
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    @if ($i == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $i }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    $(document).ready(function() {
        // Add smooth scrolling to links
        $('a[href="#product-grid"]').on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - 80
                }, 800);
            }
        });
    });
</script>
@endpush
