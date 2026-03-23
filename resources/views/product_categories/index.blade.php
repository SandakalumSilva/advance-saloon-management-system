@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Product Categories</h4>
        <button class="btn btn-primary" id="createProductCategory">
            <i class="bi bi-plus"></i> Add Product Category
        </button>
    </div>

    <table class="table table-bordered align-middle" id="productCategoryTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Branch</th>
                <th>Description</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>
    </table>

    @include('product_categories.modal')
@endsection

@section('script')
    @vite(['resources/js/product-category.js'])
@endsection
