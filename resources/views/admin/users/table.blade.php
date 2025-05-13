<table class="table table-striped table-hover">
    <thead>
        <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Profile Picture</th>
            <th scope="col">Name
                <input type="text" class="form-control form-control-sm table-filter" data-filter="search" placeholder="Search name">
            </th>
            <th scope="col" class="d-none d-lg-table-cell">Email
                <input type="text" class="form-control form-control-sm table-filter" data-filter="email" placeholder="Search email">
            </th>
            <th scope="col">Role
                <select class="form-select form-select-sm table-filter" data-filter="role">
                    <option value="">All</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </th>
            <th scope="col">Adress</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody class="dynamic-table-body">
    @if ($users->count())
      @foreach ($users as $user)
        <tr>
          <th scope="row">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</th>
          <td><img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default.png') }}" alt="User Image" class="img-fluid" width="50px"></td>
          <td>{{ $user->name }}</td>
          <td class="d-none d-lg-table-cell">{{ $user->email }}</td>
          <td>{{ ucfirst($user->role) }}</td>
          <td> {{ $user->address ? $user->address : 'N/A'}}</td>
          <td>
            <div class="dropdown">
              <button class="drop-border buttonUI" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">
                  <i class="bi bi-basket"></i> Order History</a></li>
                <li>
                  <a class="dropdown-item edit-user-link" href="#" data-id="{{ $user->id }}">
                  <i class="bi bi-pencil"></i> Edit
                </a></li>
                <li>
                  <button type="button" class="dropdown-item text-danger delete-action"
                  data-id="{{ $user->id }}" 
                  data-type="users"
                  data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash3"></i> Delete
                  </button>
                </li>
              </ul>
            </div>
          </td>
        </tr>
      @endforeach
  </tbody>
</table>
@else
  <tr>
    <td colspan="6" class="text-center">No users found.</td>
  </tr>
@endif

<div class="d-flex justify-content-center">
  <div id="paginationLinks">
      {{ $users->links('vendor.pagination.bootstrap-4') }}
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteLabel">Confirm Deletion</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              Are you sure you want to delete this user?
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

<div id="ajaxEditModalContainer"></div>
@include('admin.users.edit')