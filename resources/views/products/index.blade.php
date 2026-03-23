@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Products</h4>
        <button class="btn btn-primary" id="createProduct">
            <i class="bi bi-plus"></i> Add Product
        </button>
    </div>

    <table class="table table-bordered align-middle" id="productTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>SKU</th>
                <th>Branch</th>
                <th>Category</th>
                <th>Selling Price</th>
                <th>Cost Price</th>
                <th>Stock Qty</th>
                <th>Commission</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>
    </table>

    @include('products.modal')
@endsection

@section('script')
    @vite(['resources/js/product.js'])
@endsection