<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-box-seam"></i> Add New Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3"> <!-- Bootstrap row for flexible columns -->

                        <div class="col-12 col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" name="category_id" required>
                                <option value="" disabled selected>-- Select a Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-12 col-md-3">
                            <label for="isActive" class="form-label">Status</label>
                            <select name="isActive" class="form-select" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="isFeatured" class="form-label">Featured</label>
                            <select name="isFeatured" class="form-select" required>
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                        </div>


                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" required
                                placeholder="Enter product name" value="{{ old('name') }}">
                        </div>


                        <div class="col-12 col-md-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" name="color" required
                                placeholder="Enter product color" value="{{ old('color') }}">
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="price" class="form-label">Price (JOD)</label>
                            <input type="number" class="form-control" name="price" step="any" required
                                placeholder="Enter product price" value="{{ old('price') }}">
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="2">{{ old('description') }}</textarea>
                        </div>



                        <!-- Product Sizes -->
                        <div class=" col-12 col-md-6">
                            <label for="sizes" class="form-label">Product Sizes</label>
                            <div id="sizesContainer">
                                <div class="input-group mb-2">
                                    <input type="text" name="sizes[0][size]" class="form-control"
                                        placeholder="Size (e.g., S, M, L)" required>
                                    <input type="number" name="sizes[0][stock]" class="form-control"
                                        placeholder="Stock" required>
                                    <button type="button" class="btn btn-danger remove-size">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary add-size">Add Size</button>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="quantity" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" name="quantity" required
                                placeholder="Enter quantity" value="{{ old('quantity') }}">
                        </div>

                        <!-- Images -->
                        <div class="col-12 col-md-4">
                            <label for="thumbnail" class="form-label">Thumbnail Image</label>
                            <input type="file" class="form-control" name="thumbnail" accept=".jpeg,.jpg,.png">
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="image1" class="form-label">Product Image 1</label>
                            <input type="file" class="form-control" name="image1" accept=".jpeg,.jpg,.png">
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="image2" class="form-label">Product Image 2</label>
                            <input type="file" class="form-control" name="image2" accept=".jpeg,.jpg,.png">
                        </div>

                    </div> <!-- End of row -->

                    <div class="d-flex gap-2 justify-content-end align-items-center mt-3">
                        <button type="submit" class="btn btn-primary">Create Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("sizesContainer");
        document.querySelector(".add-size").addEventListener("click", function() {
            const index = container.children.length;
            const newSize =
                `<div class="input-group mb-2"><input type="text" name="sizes[${index}][size]" class="form-control" placeholder="Size (e.g., S, M, L)" required><input type="number" name="sizes[${index}][stock]" class="form-control" placeholder="Stock" required><button type="button" class="btn btn-danger remove-size">Remove</button></div>`;
            container.insertAdjacentHTML("beforeend", newSize);
        });
        container.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-size")) {
                event.target.parentElement.remove();
            }
        });
    });
</script>
