<x-app-layout>
    <div class="product-detail-page">
        <div class="container mt-2 mb-5">
            <div class="breadcrumb-section mb-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                        @if (isset($product->category))
                            <li class="breadcrumb-item"><a
                                    href="{{ route('shop', ['category' => $product->category->id]) }}">{{ $product->category->name }}</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>

            <div class="product-main-content">
                <div class="row">
                    <!-- Product Images Column -->
                    <div class="col-md-6 mb-4">
                        <div class="product-image-gallery p-3 rounded shadow-sm bg-white">
                            <div class="product-carousel owl-carousel">
                                @if ($product->thumbnail)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                            alt="{{ $product->name }}" class="img-fluid main-image">
                                    </div>
                                @else
                                    <div class="item">
                                        <img src="{{ asset('images/fallback.jpg') }}" alt="{{ $product->name }}"
                                            class="img-fluid main-image">
                                    </div>
                                @endif
                                @if ($product->image1)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $product->image1) }}"
                                            alt="{{ $product->name }} - Image 1" class="img-fluid main-image">
                                    </div>
                                @else
                                    <div class="item">
                                        <img src="{{ asset('images/fallback.jpg') }}"
                                            alt="{{ $product->name }} - Image 1" class="img-fluid main-image">
                                    </div>
                                @endif
                                @if ($product->image2)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $product->image2) }}"
                                            alt="{{ $product->name }} - Image 2" class="img-fluid main-image">
                                    </div>
                                @else
                                    <div class="item">
                                        <img src="{{ asset('images/fallback.jpg') }}"
                                            alt="{{ $product->name }} - Image 2" class="img-fluid main-image">
                                    </div>
                                @endif
                            </div>

                            <div class="product-thumbnails row mt-3">
                                @if ($product->thumbnail)
                                    <div class="col-4 col-md-3">
                                        <div class="thumbnail-item active" data-index="0">
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-4 col-md-3">
                                        <div class="thumbnail-item active" data-index="0">
                                            <img src="{{ asset('images/fallback.jpg') }}" alt="Thumbnail"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                @endif
                                @if ($product->image1)
                                    <div class="col-4 col-md-3">
                                        <div class="thumbnail-item" data-index="1">
                                            <img src="{{ asset('storage/' . $product->image1) }}" alt="Image 1"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-4 col-md-3">
                                        <div class="thumbnail-item" data-index="1">
                                            <img src="{{ asset('images/fallback.jpg') }}" alt="Image 1"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                @endif
                                @if ($product->image2)
                                    <div class="col-4 col-md-3">
                                        <div class="thumbnail-item" data-index="2">
                                            <img src="{{ asset('storage/' . $product->image2) }}" alt="Image 2"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-4 col-md-3">
                                        <div class="thumbnail-item" data-index="2">
                                            <img src="{{ asset('images/fallback.jpg') }}" alt="Image 2"
                                                class="img-fluid">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Info Column -->
                    <div class="col-md-6">
                        <div class="product-info">
                            <h1 class="product-title">{{ $product->name }}</h1>

                            @if (isset($product->category))
                                <div class="product-category">
                                    <a href="{{ route('shop', ['category' => $product->category->id]) }}"
                                        class="category-link">
                                        {{ $product->category->name }}
                                    </a>
                                </div>
                            @endif

                            <div class="product-rating mt-2">
                                <div class="stars-rating d-flex align-items-center">
                                    @php
                                        $approvedReviews = $product->reviews->where('is_approved', 1);
                                        $reviewCount = $approvedReviews->count();
                                        $rating = $reviewCount > 0 ? $approvedReviews->avg('rating') : 0;
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                    @endphp

                                    <ul class="stars d-flex list-unstyled mb-0 me-2">
                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <li><i class="fa fa-star text-warning"></i></li>
                                        @endfor

                                        @if ($halfStar)
                                            <li><i class="fa fa-star-half-o text-warning"></i></li>
                                        @endif

                                        @for ($i = 0; $i < $emptyStars; $i++)
                                            <li><i class="fa fa-star-o text-warning"></i></li>
                                        @endfor
                                    </ul>
                                    <span class="review-count">({{ $reviewCount }} @if ($reviewCount == 1)
                                            review
                                        @else
                                            reviews
                                        @endif)</span>
                                </div>
                            </div>

                            @if ($product->description)
                                <div class="product-description mt-3">
                                    <p>{{ $product->description }}</p>
                                </div>
                            @endif

                            <form class="product-customize-form mt-4">
                                @if ($product->colors)
                                    <div class="form-group product-colors">
                                        <label>Available Colors:</label>
                                        <div class="color-options">
                                            @foreach (explode(',', $product->colors) as $color)
                                                <div class="color-option"
                                                    style="background-color: {{ $color }};"
                                                    data-color="{{ $color }}"></div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="selected_color" id="selected-color">
                                    </div>
                                @endif

                                <div class="form-group mt-4">
                                    <label>Customization Type:</label>
                                    <div class="customization-type">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="customization_type"
                                                id="custom-text" value="text" checked>
                                            <label class="form-check-label" for="custom-text">
                                                Custom Text
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="customization_type"
                                                id="custom-image" value="image">
                                            <label class="form-check-label" for="custom-image">
                                                Custom Image
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3 custom-text-options">
                                    <label for="custom-text-input">Your Custom Text:</label>
                                    <input type="text" class="form-control" id="custom-text-input"
                                        placeholder="Enter your text here">

                                    <div class="text-color-options mt-2">
                                        <label>Text Color:</label>
                                        <div class="color-picker d-flex flex-wrap">
                                            <span class="color-swatch color-black"
                                                data-color="#000000"></span>
                                            <span class="color-swatch color-white border"
                                                data-color="#ffffff"></span>
                                            <span class="color-swatch color-red"
                                                data-color="#ff0000"></span>
                                            <span class="color-swatch color-blue"
                                                data-color="#0000ff"></span>
                                            <span class="color-swatch color-yellow"
                                                data-color="#ffff00"></span>
                                        </div>
                                        <input type="hidden" name="text_color" id="selected-text-color"
                                            value="#000000">
                                    </div>
                                </div>

                                <div class="form-group mt-3 custom-image-options d-none">
                                    <label for="custom-image-input">Upload Your Image:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="custom-image-input">
                                        <label class="custom-file-label" for="custom-image-input">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG,
                                        PNG</small>
                                </div>

                                <div class="form-group mt-4 size-selection">
                                    <label>Select Size:</label>
                                    <div class="size-options">
                                        @foreach ($product->productSizes as $productSize)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="size"
                                                    id="size-{{ $productSize->size }}"
                                                    value="{{ $productSize->id }}"
                                                    {{ $productSize->stock <= 0 ? 'disabled' : '' }}>
                                                <label
                                                    class="form-check-label {{ $productSize->stock <= 0 ? 'text-muted' : '' }}"
                                                    for="size-{{ $productSize->size }}">
                                                    {{ $productSize->size }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="form-group quantity-selector">
                                        <label>Quantity:</label>
                                        <div class="quantity-input">
                                            <button type="button" class="quantity-btn quantity-decrease">-</button>
                                            <input type="number" class="quantity-field" value="1" min="1"
                                                max="10">
                                            <button type="button" class="quantity-btn quantity-increase">+</button>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <span class="price">{{ $product->price }} JOD</span>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="button" class="add-to-cart-btn btn btn-primary">
                                        <i class="fa fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs: Description and Reviews only -->
            <div class="product-tabs mt-5">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    @if ($product->description)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab"
                                aria-controls="description" aria-selected="true">Description</button>
                        </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ !$product->description ? 'active' : '' }}" id="reviews-tab"
                            data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab"
                            aria-controls="reviews"
                            aria-selected="{{ !$product->description ? 'true' : 'false' }}">Reviews</button>
                    </li>
                </ul>
                <div class="tab-content" id="productTabContent">
                    @if ($product->description)
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            <div class="p-4">
                                <h4>Product Description</h4>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="tab-pane fade {{ !$product->description ? 'show active' : '' }}" id="reviews"
                        role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="p-4">
                            <h4>Customer Reviews</h4>
                            @if ($approvedReviews->count() > 0)
                                <div class="reviews-list">
                                    @foreach ($approvedReviews as $review)
                                        <div class="review-item mb-4 pb-3 border-bottom">
                                            <div class="review-header d-flex justify-content-between">
                                                <div class="reviewer fw-bold">{{ $review->user->name }}</div>
                                                <div class="review-date text-muted">
                                                    {{ $review->created_at->format('M d, Y') }}</div>
                                            </div>
                                            <div class="review-rating">
                                                <div class="stars d-flex list-unstyled mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="fa {{ $i <= $review->rating ? 'fa-star' : 'fa-star-o' }} text-warning me-1"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="review-content">
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>There are no reviews for this product yet. Be the first to leave a review!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <div class="related-products mt-5">
                <h3 class="section-title">Related Products</h3>

                <div class="related-products-carousel owl-carousel">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="product-item">
                            <a href="{{ route('product.show', $relatedProduct->id) }}">
                                @if ($relatedProduct->thumbnail)
                                    <img src="{{ asset('storage/' . $relatedProduct->thumbnail) }}"
                                        alt="{{ $relatedProduct->name }}" class="img-fluid">
                                @else
                                    <img src="{{ asset('images/fallback.jpg') }}" alt="{{ $relatedProduct->name }}">
                                @endif
                            </a>
                            <div class="down-content p-3">
                                <a href="{{ route('product.show', $relatedProduct->id) }}">
                                    <h4 class="product-title text-truncate">{{ $relatedProduct->name }}</h4>
                                </a>

                                @if ($relatedProduct->category)
                                    <a href="{{ route('shop', ['category' => $relatedProduct->category->id]) }}"
                                        class="category-link">
                                        {{ $relatedProduct->category->name }}
                                    </a>
                                @endif
                                
                                @php
                                    $relatedReviews = $relatedProduct->reviews->where('is_approved', 1);
                                    $relatedReviewCount = $relatedReviews->count();
                                    $relatedRating = $relatedReviewCount > 0 ? $relatedReviews->avg('rating') : 0;
                                    $relatedFullStars = floor($relatedRating);
                                    $relatedHalfStar = $relatedRating - $relatedFullStars >= 0.5;
                                    $relatedEmptyStars = 5 - $relatedFullStars - ($relatedHalfStar ? 1 : 0);
                                @endphp

                                <div class="stars-container mb-2">
                                    <ul class="stars d-inline-flex list-unstyled mb-0">
                                        @for ($i = 0; $i < $relatedFullStars; $i++)
                                            <li><i class="fa fa-star text-warning"></i></li>
                                        @endfor

                                        @if ($relatedHalfStar)
                                            <li><i class="fa fa-star-half-o text-warning"></i></li>
                                        @endif

                                        @for ($i = 0; $i < $relatedEmptyStars; $i++)
                                            <li><i class="fa fa-star-o text-warning"></i></li>
                                        @endfor
                                    </ul>
                                    <span class="review-count">({{ $relatedReviewCount }})</span>
                                </div>
                                
                                <div class="price-small mt-1">{{ $relatedProduct->price }} JOD</div>
                                
                                @if($relatedProduct->colors)
                                    <div class="color-info mt-2">
                                        @foreach(explode(',', $relatedProduct->colors) as $color)
                                            <span class="color-dot" style="background-color: {{ $color }}"></span>
                                        @endforeach
                                    </div>
                                @endif

                                <a href="{{ route('product.show', $relatedProduct->id) }}"
                                    class="customize-btn btn w-100 mt-1">
                                    Customize
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('user/css/product.css') }}">
    @endpush
    
    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize product image carousel
            var productCarousel = $('.product-carousel').owlCarousel({
                items: 1,
                loop: false,
                margin: 0,
                dots: false,
                nav: true,
                navText: [
                    '<i class="fa fa-angle-left"></i>',
                    '<i class="fa fa-angle-right"></i>'
                ]
            });
            
            // Thumbnail click handler
            $('.thumbnail-item').on('click', function() {
                var index = $(this).data('index');
                productCarousel.trigger('to.owl.carousel', [index, 300]);
                $('.thumbnail-item').removeClass('active');
                $(this).addClass('active');
            });
            
            // Update active thumbnail when carousel changes
            productCarousel.on('changed.owl.carousel', function(event) {
                var index = event.item.index;
                $('.thumbnail-item').removeClass('active');
                $('.thumbnail-item[data-index="' + index + '"]').addClass('active');
            });
            
            // Related products carousel
            $('.related-products-carousel').owlCarousel({
                loop: true,
                margin: 15,
                nav: true,
                navText: [
                    '<i class="fa fa-angle-left"></i>',
                    '<i class="fa fa-angle-right"></i>'
                ],
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    992: {
                        items: 4
                    }
                }
            });
            
            // Toggle customization options based on selection
            $('input[name="customization_type"]').on('change', function() {
                var selected = $(this).val();
                if (selected === 'text') {
                    $('.custom-text-options').removeClass('d-none').show();
                    $('.custom-image-options').addClass('d-none').hide();
                } else {
                    $('.custom-text-options').addClass('d-none').hide();
                    $('.custom-image-options').removeClass('d-none').show();
                }
            });
            
            // Color selection
            $('.color-option').on('click', function() {
                $('.color-option').removeClass('selected');
                $(this).addClass('selected');
                $('#selected-color').val($(this).data('color'));
            });
            
            // Text color selection
            $('.color-swatch').on('click', function() {
                $('.color-swatch').removeClass('selected');
                $(this).addClass('selected');
                $('#selected-text-color').val($(this).data('color'));
            });
            
            // Quantity selection
            $('.quantity-decrease').on('click', function() {
                var input = $(this).siblings('.quantity-field');
                var value = parseInt(input.val());
                if (value > 1) {
                    input.val(value - 1);
                }
            });
            
            $('.quantity-increase').on('click', function() {
                var input = $(this).siblings('.quantity-field');
                var value = parseInt(input.val());
                var max = parseInt(input.attr('max'));
                if (value < max) {
                    input.val(value + 1);
                }
            });
            
            // File input label update
            $('#custom-image-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName || 'Choose file');
                
                // Validate file size
                if (this.files[0] && this.files[0].size > 2 * 1024 * 1024) {
                    alert('File size exceeds 2MB limit.');
                    $(this).val('');
                    $(this).siblings('.custom-file-label').html('Choose file');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
