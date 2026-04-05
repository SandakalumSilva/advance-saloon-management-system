@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Customers</h4>
        <button class="btn btn-primary" id="createCustomer">
            <i class="bi bi-plus"></i> Add Customer
        </button>
    </div>

    <table class="table table-bordered align-middle" id="customerTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Code</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>
    </table>

    @include('customers.modal')
@endsection

@section('script')
    @vite(['resources/js/customer.js'])
@endsection