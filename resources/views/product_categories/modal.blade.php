<div class="modal fade" id="productCategoryModal" tabindex="-1" aria-labelledby="productCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form id="productCategoryForm">
            @csrf
            <input type="hidden" id="product_category_id" name="id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productCategoryModalLabel">Add Product Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="product_branch_id" class="form-label">Branch</label>
                        <select name="branch_id" id="product_branch_id" class="form-control">
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger branch_id_error"></small>
                    </div>

                    <div class="mb-3">
                        <label for="product_name" class="form-label">Category Name</label>
                        <input type="text" name="name" id="product_name" class="form-control">
                        <small class="text-danger name_error"></small>
                    </div>

                    <div class="mb-3">
                        <label for="product_description" class="form-label">Description</label>
                        <textarea name="description" id="product_description" class="form-control" rows="3"></textarea>
                        <small class="text-danger description_error"></small>
                    </div>

                    <div class="mb-3">
                        <label for="product_status" class="form-label">Status</label>
                        <select name="status" id="product_status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <small class="text-danger status_error"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveProductCategoryBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
