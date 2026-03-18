@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Roles</h4>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add Role
        </a>
    </div>

    <table class="table" id="rolesTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
@endsection

@section('script')
    <script>
        $(function() {
            $('#rolesTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('roles.index') }}",
                    dataSrc: '' // ✅ must be inside ajax
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                        <a href="/roles/${data.id}/permissions" class="btn btn-sm btn-warning">
                            Permissions
                        </a>
                    `;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
