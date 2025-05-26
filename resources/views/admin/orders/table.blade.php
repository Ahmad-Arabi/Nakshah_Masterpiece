<table class="table table-striped table-hover ordersTable">
    <thead>
        <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">
                User Name
                <input type="text" class="form-control form-control-sm table-filter" data-filter="search" placeholder="Search by user">
            </th>
            <th scope="col">Total Price</th>
            <th scope="col">
                Status
                <select class="form-select form-select-sm table-filter" data-filter="status">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="canceled">Canceled</option>
                </select>
            </th>
            <th scope="col">Discount Applied</th>
            <th scope="col">Coupon Code</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody class="dynamic-table-body">
      @if ($orders->count())
          @foreach ($orders as $order)
              <tr>
                  <th scope="row">{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</th>
                  <td>{{ $order->user->name }}</td>
                  <td>{{ number_format($order->total_price, 2) }} JOD</td>

                  <!-- Order Status -->
                  <td>
                      <span class="badge 
                          {{ $order->status === 'pending' ? 'bg-danger' : 
                             ($order->status === 'processing' ? 'bg-primary' : 
                             ($order->status === 'shipped' ? 'bg-warning text-dark' : 
                             ($order->status === 'delivered' ? 'bg-success' : 'bg-secondary'))) }}">
                          {{ ucfirst($order->status) }}
                      </span>
                  </td>

                  <td>{{ number_format($order->discount_applied, 2) }} JOD</td>
                  <td>{{ $order->coupon ? $order->coupon->code : 'No Coupon' }}</td>

                  <!-- Actions -->
                  <td class="position-relative z-index-1">
                      <div class="dropdown">
                          <button class="drop-border buttonUI" type="button" data-bs-toggle="dropdown">
                              <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu">
                              <li>
                                  <a class="dropdown-item show-order-link"
                                      href="{{ route('admin.orders.show', $order->id) }}">
                                      <i class="bi bi-eye"></i> Show
                                  </a>
                              </li>
                              <li>
                                  <a class="dropdown-item edit-order-link" href="#" data-id="{{ $order->id }}">
                                      <i class="bi bi-pencil"></i> Edit
                                  </a>
                              </li>
                              <li>
                                  <button type="button" class="dropdown-item text-danger delete-action"
                                      data-id="{{ $order->id }}" data-type="orders"
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
              <td colspan="7" class="text-center py-2">No Orders Found</td>
          </tr>
      @endif
  </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center">
  <div id="paginationLinks">
      {{ $orders->links('vendor.pagination.bootstrap-4') }}
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
              Are you sure you want to delete this order?<br>
              <small style="color:red">
                  <i class="bi bi-exclamation-triangle"></i>
                  Deleting this order will remove all associated items.
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

<!-- AJAX Edit Modal -->
<div id="ajaxEditModalOrder"></div>
@include('admin.orders.edit')

