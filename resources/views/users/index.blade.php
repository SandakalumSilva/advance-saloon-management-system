@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Users</h4>
        <button class="btn btn-primary" id="createUser">
            <i class="bi bi-plus"></i> Add User
        </button>
    </div>

    <table class="table" id="userTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Branch</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    @include('users.modal')
@endsection

@section('script')
    @vite(['resources/js/user.js'])
@endsection
