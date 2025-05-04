<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Set modal to large -->
        <div class="modal-content">
            @if (isset($product))
                <form id="editProductForm" action="{{ route('admin.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil"></i> Edit Product - {{ $product->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3"> <!-- Bootstrap grid system applied -->


                            <div class="col-12 col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="{{ $product->category_id }}" selected>{{ $product->category->name }}
                                    </option>
                                    @foreach ($categories as $category)
                                        @if ($category->id != $product->category_id)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status & Featured -->
                            <div class="col-12 col-md-3">
                                <label class="form-label">Status</label>
                                <select name="isActive" class="form-select" required>
                                    <option value="1" {{ $product->isActive ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$product->isActive ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label">Featured</label>
                                <select name="isFeatured" class="form-select" required>
                                    <option value="1" {{ $product->isFeatured ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$product->isFeatured ? 'selected' : '' }}>No</option>
                                </select>
                            </div>


                            <div class="col-12 col-md-6">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="name" required
                                    value="{{ $product->name }}">
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label">Color</label>
                                <input type="text" class="form-control" name="color" required
                                    value="{{ $product->color }}">
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label">Price (JOD)</label>
                                <input type="number" class="form-control" name="price" step="any" required
                                    value="{{ $product->price }}">
                            </div>




                            <!-- Product Sizes -->
                            <div class=" col-8">
                                <label class="form-label">Product Sizes</label>
                                <div id="sizesContainer"    >
                                    @foreach ($productSizes as $size)
                                        <div class="input-group">
                                            <input type="text" name="sizes[{{ $loop->index }}][size]"
                                                class="form-control mb-2" value="{{ $size->size }}" required>
                                            <input type="number" name="sizes[{{ $loop->index }}][stock]"
                                                class="form-control mb-2" value="{{ $size->stock }}" required>
                                            <button type="button" class="btn btn-danger remove-size mb-2">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-secondary add-size">Add Size</button>
                            </div>

                            <div class="col-12 col-md-4 align-self-stretch">
                                <label class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" name="quantity" required
                                    value="{{ $product->quantity }}">
                            </div>

                            <!-- Images -->
                            <div class="col-12 col-md-4">
                                <label class="form-label">Thumbnail Image</label>
                                <input type="file" class="form-control" name="thumbnail" accept=".jpeg,.jpg,.png">
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label">Product Image 1</label>
                                <input type="file" class="form-control" name="image1" accept=".jpeg,.jpg,.png">
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label">Product Image 2</label>
                                <input type="file" class="form-control" name="image2" accept=".jpeg,.jpg,.png">
                            </div>

                        </div> <!-- End of row -->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            @else
                <p class="text-center">No Products available to edit.</p>
            @endif
        </div>
    </div>
</div>
