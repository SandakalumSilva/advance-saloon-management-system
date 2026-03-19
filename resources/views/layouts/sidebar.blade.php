<aside class="col-lg-2 border-end min-vh-100 sidebar p-3 d-none d-lg-block">
    <nav class="nav flex-column gap-1">
        <a class="nav-link" href="#">Dashboard</a>
        <a class="nav-link" href="#">Calendar</a>
        <a class="nav-link" href="#">Appointments</a>
        <a class="nav-link" href="#">Customers</a>
        <a class="nav-link" href="#">Services</a>
        <a class="nav-link" href="#">Staff</a>
        <a class="nav-link" href="#">POS</a>
        <a class="nav-link" href="#">Staff Leave</a>
        <a class="nav-link" href="#">Online Booking</a>
        <a class="nav-link" href="#">Reports</a>
        {{-- @can('users.view') --}}
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="bi bi-people me-2"></i> User Management
        </a>
        {{-- @endcan --}}
        <a class="nav-link" href="{{ route('roles.index') }}">
            <i class="bi bi-shield-lock me-2"></i> Roles & Permissions
        </a>
        <a class="nav-link" href="#">Settings</a>
    </nav>
</aside>
