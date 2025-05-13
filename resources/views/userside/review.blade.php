<x-app-layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card review-card shadow-sm">
                    <div class="card-header d-flex align-items-center">
                        <h2 class="mb-0 title">Write a Review</h2>
                        <span class="ms-auto">for <strong>{{ $product->name }}</strong></span>
                    </div>
                    
                    <div class="card-body">
                        <div class="product-preview mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/' . ($product->thumbnail ?? 'images/fallback.jpg')) }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-fluid rounded">
                                </div>
                                <div class="col-md-9">
                                    <h4>{{ $product->name }}</h4>
                                    <p class="text-muted">{{ Str::limit($product->description, 100) }}</p>
                                    <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-outline-secondary">View Product</a>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('product.review.store', $product) }}" class="review-form">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label">Rating</label>
                                <div class="star-rating">
                                    <div class="rating-group">
                                        <input disabled checked class="rating__input rating__input--none" name="rating" id="rating-none" value="0" type="radio">
                                        
                                        <label aria-label="1 star" class="rating__label" for="rating-1">
                                            <i class="rating__icon rating__icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating__input" name="rating" id="rating-1" value="1" type="radio">
                                        
                                        <label aria-label="2 stars" class="rating__label" for="rating-2">
                                            <i class="rating__icon rating__icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating__input" name="rating" id="rating-2" value="2" type="radio">
                                        
                                        <label aria-label="3 stars" class="rating__label" for="rating-3">
                                            <i class="rating__icon rating__icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating__input" name="rating" id="rating-3" value="3" type="radio">
                                        
                                        <label aria-label="4 stars" class="rating__label" for="rating-4">
                                            <i class="rating__icon rating__icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating__input" name="rating" id="rating-4" value="4" type="radio">
                                        
                                        <label aria-label="5 stars" class="rating__label" for="rating-5">
                                            <i class="rating__icon rating__icon--star fa fa-star"></i>
                                        </label>
                                        <input class="rating__input" name="rating" id="rating-5" value="5" type="radio">
                                    </div>
                                </div>
                                @error('rating')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="review" class="form-label">Your Review</label>
                                <textarea class="form-control" id="review" name="review" rows="5" placeholder="What did you like or dislike? What did you use this product for?">{{ old('review') }}</textarea>
                                <div class="form-text">Min 10 characters, max 500 characters.</div>
                                @error('review')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('product.show', $product) }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>