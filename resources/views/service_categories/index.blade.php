@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Service Categories</h4>
        <button class="btn btn-primary" id="createServiceCategory">
            <i class="bi bi-plus"></i> Add Service Category
        </button>
    </div>

    <table class="table table-bordered align-middle" id="serviceCategoryTable">
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

    @include('service_categories.modal')
@endsection

@section('script')
    @vite(['resources/js/service-category.js'])
@endsection