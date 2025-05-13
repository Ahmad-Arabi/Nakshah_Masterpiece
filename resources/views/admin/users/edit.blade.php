<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- ✅ Enlarged modal for better layout -->
        <div class="modal-content">
            @if(isset($user))
            <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editUserLabel">
                        <i class="bi bi-pencil"></i> Edit {{ $user->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Role Selection -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="edit_role" class="form-select">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Name & Email -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required value="{{ $user->email }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- City & Phone -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="edit_address" name="address" value="{{ $user->address ?? '' }}" placeholder="Enter Address">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="edit_phone" name="phone" value="{{ $user->phone ?? '' }}" placeholder="Enter Phone Number">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Password & Confirmation -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Leave empty to keep current password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Repeat new password" autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Profile Picture -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="edit_profile_picture" name="profile_picture" accept=".jpeg, .jpg, .png, .gif">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
            @else
                <p class="text-center">No users available to edit.</p>
            @endif
        </div>
    </div>
</div>