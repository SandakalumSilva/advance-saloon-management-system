@extends('layouts.app')

@section('content')
    <h4>Create Role</h4>

    <form method="POST" action="{{ route('roles.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
@endsection
