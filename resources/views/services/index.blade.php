@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Services</h4>
        <button class="btn btn-primary" id="createService">
            <i class="bi bi-plus"></i> Add Service
        </button>
    </div>

    <table class="table table-bordered align-middle" id="serviceTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Code</th>
                <th>Branch</th>
                <th>Category</th>
                <th>Duration</th>
                <th>Price</th>
                <th>Commission</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>
    </table>

    @include('services.modal')
@endsection

@section('script')
    @vite(['resources/js/service.js'])
@endsection