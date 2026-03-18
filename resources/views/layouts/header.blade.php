<header class="navbar border-bottom bg-body">
    <div class="container-fluid">
        <!-- Mobile menu button (label toggles the checkbox) -->
        <label for="menuToggle" class="btn btn-outline-secondary d-lg-none me-2 mb-0">
            <i class="bi bi-list"></i>
            <span class="visually-hidden">Toggle menu</span>
        </label>

        <a class="navbar-brand fw-semibold" href="#">
            <i class="bi bi-scissors me-2"></i>Salon Manager
        </a>


        <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center gap-2 nav-link dropdown-toggle p-0"
                data-bs-toggle="dropdown" aria-expanded="false">

                <span class="text-body-secondary fw-bold small d-none d-sm-inline">
                    {{ Auth::user()->name }}
                </span>
                <i class="bi bi-person-circle fs-5"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li class="px-3 py-2 text-muted small">
                    Signed in as <strong>{{ Auth::user()->name }}</strong>
                    @if (Auth::user()->email)
                        <div class="text-break">{{ Auth::user()->email }}</div>
                    @endif
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-person-gear me-2"></i> Profile
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</header>
