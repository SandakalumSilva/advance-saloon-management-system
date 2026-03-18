@extends('layouts.app')

@section('content')
    <h4>Permissions for: {{ $role->name }}</h4>

    <form method="POST" action="{{ route('roles.permissions.update', $role->id) }}">
        @csrf

        <div class="row">
            @foreach ($permissions as $permission)
                <div class="col-md-3">
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input"
                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                        <label class="form-check-label">
                            {{ $permission->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary mt-3">Save Permissions</button>
    </form>
@endsection
