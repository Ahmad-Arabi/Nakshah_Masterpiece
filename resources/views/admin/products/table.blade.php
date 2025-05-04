<table class="table table-striped table-hover usersTable">
    <thead>
        <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Thumbnail</th>
            <th scope="col">
                Product Name
                <input type="text" class="form-control form-control-sm table-filter" data-filter="search" placeholder="Search product">
            </th>
            <th scope="col">
                Category
                <select class="form-select form-select-sm table-filter" data-filter="category">
                    <option value="">All</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </th>
            <th scope="col">Color</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">
                Featured
                <select class="form-select form-select-sm table-filter" data-filter="featured">
                    <option value="">All</option>
                    <option value="1">Featured</option>
                    <option value="0">Not Featured</option>
                </select>
            </th>
            <th scope="col">
                Stock Status
                <select class="form-select form-select-sm table-filter" data-filter="stock_status">
                    <option value="">All</option>
                    <option value="1">In Stock</option>
                    <option value="0">Out of Stock</option>
                </select>
            </th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody class="dynamic-table-body"> 
        @if ($products->count())
            @foreach ($products as $product)
                <tr>
                    <th scope="row">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                    </th>
                    <td>
                        <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : asset('images/fallback.jpg') }}" alt="Product Thumbnail"
                            class="img-fluid rounded" style="width: 50px; height: 50px;">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->color }}</td>
                    <td>{{ number_format($product->price, 2) }} JOD</td>
                    <td>{{ $product->quantity }}</td>

                    <!-- Featured Column -->
                    <td>
                        @if ($product->isFeatured == 1)
                            <span class="badge bg-success">Featured</span>
                        @else
                            <span class="badge bg-secondary">Regular</span>
                        @endif
                    </td>

                    <!-- Stock Status Column -->
                    <td>
                        @if ($product->isActive > 0)
                            <span class="badge bg-primary">In Stock</span>
                        @else
                            <span class="badge bg-danger">Out of Stock</span>
                        @endif
                    </td>

                    <td>
                        <div class="dropdown">
                            <button class="drop-border buttonUI" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item show-product-link"
                                        href="{{ route('admin.products.show', $product->id) }}">
                                        <i class="bi bi-eye"></i> Show
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item edit-product-link" href="#"
                                        data-id="{{ $product->id }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger delete-action"
                                        data-id="{{ $product->id }}" data-type="products"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="10" class="text-center py-2">No Products Found</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <div id="paginationLinks">
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?<br>
                <small style="color:red">
                    <i class="bi bi-exclamation-triangle"></i>
                    Deleting this product will remove all associated sizes.
                </small>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="ajaxEditModalProduct"></div>
@include('admin.products.edit')
