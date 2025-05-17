<table class="table  usersTable">
    <thead>
        <tr class="table-dark">
            <th scope="col" class="d-none d-md-table-cell">#</th>
            <th scope="col" colspan="3">
                <input type="text" class="form-control form-control-sm table-filter" data-filter="search"
                    placeholder="Search for name, email or subject">
            </th>
            <th scope="col">
                Status
                <select class="form-select form-select-sm table-filter" data-filter="status">
                    <option value="">All</option>
                    <option value="resolved">Resolved</option>
                    <option value="pending">Pending</option>
                </select>
            </th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody class="dynamic-table-body">
        @if ($messages->count())
            @foreach ($messages as $message)
                <tr
                    class="{{ $message->status === 'resolved' ? 'table-success' : ($message->status === 'pending' ? 'table' : '') }}">
                    <th scope="row" class="d-none d-md-table-cell">
                        {{ ($messages->currentPage() - 1) * $messages->perPage() + $loop->iteration }}
                    </th>
                    <td>{{ $message->name ?? 'No Name Assigned' }}</td>
                    <td>{{ $message->email ?? 'No Email Assigned' }}</td>
                    <td>{{ $message->subject ?? 'No Subject Assigned' }}</td>
                    <td>
                        @if ($message->status === 'resolved')
                            <small class="text-success">Resolved</small>
                        @elseif($message->status === 'pending')
                            <small class="text-secondary">Pending</small>
                        @endif
                    </td>
                    <td>
                        <div id='contactButtons' class="review_actions d-flex justify-content-center align-items-center gap-2 my-2">
                            <a href="{{ route('admin.contact-us.show', $message->id) }}" class="dropdown-item view-action text-primary p-0"
                                title="View message details">
                                <i class="bi bi-eye-fill fs-4"></i>
                            </a>
                            @if ($message->status === 'pending')
                                <button type="button" class="dropdown-item text-success resolve-action p-0"
                                    title="Resolve this case" data-id="{{ $message->id }}" data-info="resolve"
                                    data-type="messages" data-bs-toggle="modal" data-bs-target="#actionModal">
                                    <i class="bi bi-check-circle-fill fs-4"></i>
                                </button>
                            @endif
                            <button type="button" class="dropdown-item text-danger delete-action p-0"
                                data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $message->id }}"
                                data-type="messages">
                                <i class="bi bi-trash-fill fs-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center py-2">No Messages Found</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <div id="paginationLinks">
        {{ $messages->links('vendor.pagination.bootstrap-4') }}
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
                Are you sure you want to delete this message from the website?
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

@include('admin.contact_us.approve')
