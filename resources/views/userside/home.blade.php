@push('styles')
    <style>
        /* Responsive fixes for carousel items */
        .row-cols-1>* {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .row-cols-2>* {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .row-cols-3>* {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .row-cols-4>* {
            flex: 0 0 25%;
            max-width: 25%;
        }

        /* Ensure only 2 cards show on smaller screens */
        @media (max-width: 767.98px) {
            .carousel-inner .row {
                display: flex;
                flex-wrap: wrap;
            }

            .carousel-inner .row>div {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        /* For extra small screens (mobile), ensure items are properly sized */
        @media (max-width: 575.98px) {
            .carousel-inner .row>div {
                flex: 0 0 50%;
                max-width: 50%;
            }

            /* Adjust card padding for better mobile display */
            .product-item {
                padding: 5px;
            }

            /* Make sure content fits nicely */
            .product-item .down-content {
                padding: 10px;
            }
        }

        /* Category title link styling */

        /* Make the entire category card clickable */
        .category-image {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
    </style>
@endpush

<x-app-layout>
    <!-- Banner Starts Here -->
    <div class="banner header-text nav-color-change">
        <div class="owl-banner owl-carousel">
            <div class="banner-item-01">
                <div class="text-content">
                    <h4>Personalized Designs</h4>
                    <h2>Express Your Unique Style</h2>
                    <a href="{{ route('shop') }}" class="filled-button">Start Now!</a>
                </div>
            </div>
            <div class="banner-item-02">
                <div class="text-content">
                    <h4>Custom Collections</h4>
                    <h2>Create Your Perfect Design</h2>
                    <a href="{{ route('shop') }}" class="filled-button">Start Now!</a>
                </div>
            </div>
            <div class="banner-item-03">
                <div class="text-content">
                    <h4>Premium Quality</h4>
                    <h2>From Imagination To Reality</h2>
                    <a href="{{ route('shop') }}" class="filled-button">Start Now!</a>
                </div>
            </div>
        </div>
        <!-- Banner Ends Here -->
        <div class="container-fluid mx-0 px-0">
            <div class="owl-carousel coupons-carousel">
              @foreach ($featuredCoupons as $coupon)
                <div> Use Code: <span class="coupon">{{ $coupon->code }}</span> for <span class="discount">{{ $coupon->discount }}</span> off of your next purchase! </div>
                <div> Use Code: <span class="coupon">{{ $coupon->code }}</span> for <span class="discount">{{ $coupon->discount }}</span> off of your next purchase! </div>
                <div> Use Code: <span class="coupon">{{ $coupon->code }}</span> for <span class="discount">{{ $coupon->discount }}</span> off of your next purchase! </div>
              @endforeach
              <div> Get free shipping on orders over 50 JOD !</div>
              <div> Get free shipping on orders over 50 JOD !</div>
            </div>
        </div>

    </div>

    <div class="latest-products">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Latest Products</h2>
                        <a href="{{ route('shop') }}">view all products <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="position-relative">
                <div class="products-carousel owl-carousel">
                    @forelse($products as $product)
                        <div class="product-item">
                            <a href="{{ route('product.show', $product->id) }}">
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                        class="img-fluid">
                                @else
                                    <img src="{{ asset('images/fallback.jpg') }}" alt="{{ $product->name }}">
                                @endif
                            </a>
                            <div class="down-content">
                                <a href="{{ route('product.show', $product->id) }}">
                                    <h4>{{ $product->name }}</h4>
                                </a>

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

                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <li><i class="fa fa-star"></i></li>
                                        @endfor

                                        @if ($halfStar)
                                            <li><i class="fa fa-star-half-o"></i></li>
                                        @endif

                                        @for ($i = 0; $i < $emptyStars; $i++)
                                            <li><i class="fa fa-star-o"></i></li>
                                        @endfor
                                    </ul>
                                    <span class="review-count">({{ $reviewCount }})</span>
                                </div>

                                <h6 class="mt-2">{{ $product->price }} JOD</h6>


                                <a class="cart-btn" href="{{ route('product.show', $product->id) }}">
                                    Customize Now
                                </a>
                            </div>
                        </div>
                    @empty
                        <!-- Display placeholders if no products are available -->
                        <div class="product-item">
                            <a href="#"><img src="{{ asset('images/product_placeholder.jpg') }}"
                                    alt="Product Placeholder"></a>
                            <div class="down-content">
                                <a href="#">
                                    <h4>Product Coming Soon</h4>
                                </a>

                                <div class="stars-rating">
                                    <ul class="stars">
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                    <span class="review-count">(0)</span>
                                </div>

                                <h6>0.00 JOD</h6>

                                <button class="cart-btn disabled">
                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Category Carousel Section -->
    <div class="category-showcase">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Browse Our Categories</h2>
                        <p>Discover the perfect canvas for your custom designs</p>
                    </div>
                </div>
            </div>

            <div class="position-relative">
                <div class="category-carousel owl-carousel">
                    <!-- Dynamically display categories from the controller -->
                    @foreach ($categories as $category)
                        <div class="category-item">
                            <div class="category-image bg-white">
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                @else
                                    <!-- Display a placeholder if no image is available -->
                                    <div class="category-placeholder">
                                        <span>{{ substr($category->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="hover-content">
                                    <a href="{{ route('shop', ['category' => $category->id]) }}"
                                        class="category-btn">Explore {{ $category->name }}</a>
                                </div>
                            </div>
                            <div class="category-title">
                                <h4><a href="{{ route('shop', ['category' => $category->id]) }}"
                                        class="category-title-link">{{ $category->name }}</a></h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Our Services Section -->
    <div class="our-services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading text-center">
                        <h2>Why Choose Nakshah</h2>
                        <p>Your vision, our craftsmanship. Perfect for every occasion.</p>
                    </div>
                </div>
            </div>
            <div class="row services-row gy-3">
                <div class="col-md-4">
                    <div class="service-item py-2">
                        <div class="service-icon">
                            <i class="fa fa-paint-brush"></i>
                        </div>
                        <h4>Custom Designs</h4>
                        <p>Upload your own artwork or use our design tools to create personalized products that reflect
                            your unique style. Express yourself through custom text, images, or patterns.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-item py-2">
                        <div class="service-icon">
                            <i class="fa fa-certificate"></i>
                        </div>
                        <h4>Premium Quality</h4>
                        <p>We use only high-quality materials and advanced printing technologies to ensure your designs
                            look vibrant and last for years. From fabric to print, quality is our promise.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-item py-2">
                        <div class="service-icon">
                            <i class="fa fa-truck"></i>
                        </div>
                        <h4>Fast Shipping</h4>
                        <p>Your custom creations are carefully packaged and shipped to your doorstep with reliable
                            tracking. We ensure your items arrive safely and on time, every time.</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-8 offset-md-2 text-center">
                    <div class="cta-content">
                        <h3>Ready to create something amazing?</h3>
                        <p>Start designing your personalized products today and bring your creative ideas to life.</p>
                        <a href="{{ route('shop') }}" class="filled-button">Start Now!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize the category carousel
                var categoryCarousel = $('.category-carousel').owlCarousel({
                    loop: true,
                    margin: 15,
                    nav: false,
                    dots: true,
                    dotsEach: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    responsive: {
                        0: {
                            items: 3,
                            margin: 10
                        },
                        576: {
                            items: 3
                        },
                        992: {
                            items: 3
                        },
                        1200: {
                            items: 4
                        }
                    }
                });

                // Initialize the products carousel
                var productsCarousel = $('.products-carousel').owlCarousel({
                    loop: true,
                    margin: 15,
                    nav: false,
                    dots: true,
                    dotsEach: true,
                    autoplay: false,
                    autoplayTimeout: 3000,
                    responsive: {
                        0: {
                            items: 2,
                            margin: 15
                        },
                        576: {
                            items: 3
                        },
                        768: {
                            items: 3,
                            margin: 8
                        },
                        992: {
                            items: 4
                        },
                        1200: {
                            items: 4
                        }
                    }
                });


            });

            $(document).ready(function() {
                $(".owl-carousel").owlCarousel({
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    nav: false,
                    dots: false, 
                    margin: 50,
                    center: true,
                    items: 3,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        1000: {
                            items: 2
                        }
                    } 

                });
            });
        </script>
    @endpush
</x-app-layout>
