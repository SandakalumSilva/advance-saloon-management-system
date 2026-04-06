<aside class="col-lg-2 border-end min-vh-100 sidebar p-3 d-none d-lg-block">
    <nav class="nav flex-column gap-1">
        @can('dashboard.view')
            <a class="nav-link" href="#">Dashboard</a>
        @endcan

        @can('calendar.view')
            <a class="nav-link" href="#">Calendar</a>
        @endcan

        @can('appointments.view')
            <a class="nav-link" href="#">Appointments</a>
        @endcan

        @can('customers.view')
            <a class="nav-link" href="{{ route('customers.index') }}">Customers</a>
        @endcan
        <a class="nav-link" href="{{ route('category.index') }}">Category</a>
        @can('services.view')
            <a class="nav-link" href="{{ route('services.index') }}">Services</a>
        @endcan
        @can('services.view')
            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
        @endcan

        @can('staff.view')
            <a class="nav-link" href="#">Staff</a>
        @endcan

        @can('staff_leave.view')
            <a class="nav-link" href="{{ route('staff.index') }}">Staff Leave</a>
        @endcan

        @can('pos.view')
            <a class="nav-link" href="#">POS</a>
        @endcan

        @can('online_booking.view')
            <a class="nav-link" href="#">Online Booking</a>
        @endcan

        @can('reports.view')
            <a class="nav-link" href="#">Reports</a>
        @endcan

        @can('users.view')
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="bi bi-people me-2"></i> User Management
            </a>
        @endcan

        @can('roles.view')
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="bi bi-shield-lock me-2"></i> Roles & Permissions
            </a>
        @endcan

        @can('settings.view')
            <a class="nav-link" href="{{ route('settings.index') }}">Settings</a>
        @endcan
    </nav>
</aside>
