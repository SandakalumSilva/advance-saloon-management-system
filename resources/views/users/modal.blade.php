<div class="modal fade" id="userModal">
    <div class="modal-dialog">
        <form id="userForm">
            @csrf
            <input type="hidden" id="user_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" name="name" class="form-control mb-2" placeholder="Name">
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email">
                    <input type="number" name="phone" class="form-control mb-2" placeholder="Phone No.">
                    {{-- ROLE --}}
                    <select name="role" class="form-control mb-2">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    {{-- BRANCH --}}
                    <select name="branch_id" class="form-control">
                        <option value="">Select Branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>

        </form>
    </div>
</div>
