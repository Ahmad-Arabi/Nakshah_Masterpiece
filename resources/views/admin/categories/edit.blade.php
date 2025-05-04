<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @if (isset($category))
                <form id="editCategoryForm" action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil"></i> Edit "{{ $category->name }}"
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="name" required
                                placeholder="Enter category name" value="{{ $category->name }}">
                        </div>

                        <div class="mb-3">
                            <label for="isActive" class="form-label">Status</label>
                            <select name="isActive" class="form-select" required>
                                <option value="1" {{ $category->isActive ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$category->isActive ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Category Image</label>
                            <input type="file" class="form-control" name="image" accept=".jpeg,.jpg,.png">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            @else
                <p class="text-center">No categories available to edit.</p>
            @endif
        </div>
    </div>
</div>
