<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="userForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="user_id" name="user_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="userModalLabel" class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Phone No.">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if(auth()->user()->isSuperAdmin())
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Branch</label>
                                <select name="branch_id" class="form-control">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Join Date</label>
                            <input type="date" name="join_date" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Basic Salary</label>
                            <input type="number" step="0.01" name="basic_salary" class="form-control" placeholder="Basic Salary">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Address"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>