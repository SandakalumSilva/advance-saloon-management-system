<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="serviceForm">
            @csrf
            <input type="hidden" id="service_id" name="id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Add Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch</label>
                        <select name="branch_id" id="branch_id" class="form-control">
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="service_category_id" id="service_category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Service Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" id="code" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Duration (Minutes)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cost</label>
                        <input type="number" step="0.01" name="cost" id="cost" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Commission Type</label>
                        <select name="commission_type" id="commission_type" class="form-control">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Commission Value</label>
                        <input type="number" step="0.01" name="commission_value" id="commission_value" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveServiceBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>