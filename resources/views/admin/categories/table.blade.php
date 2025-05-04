<table class="table table-striped table-hover usersTable">
    <thead>
        <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Image
            </th>
            <th scope="col">Category Name
                <input type="text" class="form-control form-control-sm table-filter" data-filter="search"
                    placeholder="Search Category" aria-label="Search Category">
            </th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody class="dynamic-table-body">
        @if ($categories->count())
            @foreach ($categories as $category)
                <tr>
                    <th scope="row">
                        {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                    </th>
                    <td>
                        <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/fallback.jpg') }}"
                            alt="{{ $category->name }}" class="img-fluid" width="50px">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <span class="badge bg-{{ $category->isActive ? 'success' : 'danger' }}">
                            {{ $category->isActive ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="drop-border buttonUI" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item edit-category-link" href="#"
                                        data-id="{{ $category->id }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger delete-action"
                                        data-id="{{ $category->id }}" data-type="categories" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
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
                <td colspan="5" class="text-center py-2">No Categories Found</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <div id="paginationLinks">
        {{ $categories->links('vendor.pagination.bootstrap-4') }}
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
                Are you sure you want to delete this category?
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

<div id="ajaxEditModalCategory"></div>
@include('admin.categories.edit')
