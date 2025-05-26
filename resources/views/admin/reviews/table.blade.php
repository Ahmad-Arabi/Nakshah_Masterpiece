<table class="table table-striped table-hover usersTable">
    <thead>
        <tr class="table-dark">
            <th scope="col" class="table-cell">#</th>
            <th scope="col">
                Customer Email
                <input type="text" class="form-control form-control-sm table-filter" data-filter="search"
                    placeholder="Search by email">
            </th>
            <th scope="col">
                Product
                <input type="text" class="form-control form-control-sm table-filter" data-filter="product"
                    placeholder="Search">
            </th>
            <th scope="col" class="table-cell">
                Rating
                <select class="form-select form-select-sm table-filter" data-filter="rating">
                    <option value="">All</option>
                    <option value="5">★★★★★</option>
                    <option value="4">★★★★☆</option>
                    <option value="3">★★★☆☆</option>
                    <option value="2">★★☆☆☆</option>
                    <option value="1">★☆☆☆☆</option>
                </select>
            </th>
            <th scope="col">Review</th>
            <th scope="col">
                Status
                <select class="form-select form-select-sm table-filter" data-filter="is_approved">
                    <option value="">All</option>
                    <option value="null">Pending</option>
                    <option value="1">Approved</option>
                    <option value="0">Rejected</option>
                </select>
            </th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody class="dynamic-table-body">
        @if ($reviews->count())
            @foreach ($reviews as $review)
                <tr
                    class="{{ $review->is_approved === 1 ? 'table-success' : ($review->is_approved === 0 ? 'table-danger' : '') }}">
                    <th scope="row" class="table-cell">
                        {{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}
                    </th>
                    <td>{{ $review->user->email ?? 'No Customer Assigned' }}</td>
                    <td>{{ $review->product->name ?? 'No Product Assigned' }}</td>
                    <td class="start-text table-cell">
                        {{ str_repeat('⭐️', $review->rating) }}
                    </td>
                    <td>{{ $review->review }}</td>
                    <td>
                        @if ($review->is_approved === 1)
                            <small class="text-success">Approved</small>
                        @elseif($review->is_approved === 0)
                            <small class="text-danger">Rejected</small>
                        @else
                            <small>Pending Approval</small>
                        @endif
                    </td>
                    <td>
                        <div class="review_actions d-flex justify-content-center align-items-center gap-2 my-2">
                            @if ($review->is_approved === null)
                                <button type="button" class="dropdown-item text-success approve-action p-0"
                                    title="Approve this review" data-id="{{ $review->id }}" data-info="approve"
                                    data-type="reviews" data-bs-toggle="modal" data-bs-target="#actionModal">
                                    <i class="bi bi-check-circle-fill fs-4"></i>
                                </button>

                                <button type="button" class="dropdown-item text-secondary reject-action p-0"
                                    title="Reject this review" data-id="{{ $review->id }}" data-info="reject"
                                    data-type="reviews" data-bs-toggle="modal" data-bs-target="#actionModal">
                                    <i class="bi bi-x-circle-fill fs-4"></i>
                                </button>
                            @elseif ($review->is_approved === 1)
                                <button type="button" class="dropdown-item text-secondary reject-action p-0"
                                    title="Reject this review" data-id="{{ $review->id }}" data-info="reject"
                                    data-type="reviews" data-bs-toggle="modal" data-bs-target="#actionModal">
                                    <i class="bi bi-x-circle-fill fs-4"></i>
                                </button>
                            @elseif ($review->is_approved === 0)
                                <button type="button" class="dropdown-item text-success approve-action p-0"
                                    title="Approve this review" data-id="{{ $review->id }}" data-info="approve"
                                    data-type="reviews" data-bs-toggle="modal" data-bs-target="#actionModal">
                                    <i class="bi bi-check-circle-fill fs-4"></i>
                                </button>
                            @endif
                            <button type="button" class="dropdown-item text-danger delete-action p-0"
                                data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $review->id }}"
                                data-type="reviews">
                                <i class="bi bi-trash-fill fs-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center py-2">No Reviews Found</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <div id="paginationLinks">
        {{ $reviews->links('vendor.pagination.bootstrap-4') }}
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
                Are you sure you want to delete this review from the website?
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

@include('admin.reviews.approve')
