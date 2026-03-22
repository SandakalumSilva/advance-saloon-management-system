<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Salon Manager • HTML-only MVP + POS</title>
    <!-- Bootstrap 5 (CSS only) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons (CSS only) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <style>
        :root {
            --sidebar-width: 240px;
            --topbar-h: 56px;
            /* default navbar height */
        }

        body {
            overflow-x: hidden;
        }

        /* Topbar sticky so the toggle stays visible */
        header.navbar {
            position: sticky;
            top: 0;
            z-index: 1060;
            min-height: var(--topbar-h);
            background: var(--bs-body-bg);
        }

        .sidebar {
            width: var(--sidebar-width);
        }

        .sidebar .nav-link {
            border-radius: 0.5rem;
        }

        .kpi .icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: grid;
            place-items: center;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.5rem;
            border-radius: 999px;
            font-size: 0.75rem;
        }

        .status-booked {
            background: rgba(13, 110, 253, 0.12);
            color: #0d6efd;
        }

        .status-checkedin {
            background: rgba(25, 135, 84, 0.12);
            color: #198754;
        }

        .status-inservice {
            background: rgba(255, 193, 7, 0.2);
            color: #a07900;
        }

        .status-completed {
            background: rgba(13, 202, 240, 0.2);
            color: #0aa2c0;
        }

        .status-noshow {
            background: rgba(220, 53, 69, 0.12);
            color: #dc3545;
        }

        .status-cancelled {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
        }

        .table-sticky th {
            position: sticky;
            top: 0;
            background: var(--bs-body-bg);
            z-index: 2;
        }

        .scroll-section {
            max-height: 420px;
            overflow: auto;
        }

        .receipt {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas,
                "Liberation Mono", "Courier New", monospace;
            background: var(--bs-tertiary-bg);
            border-radius: 0.5rem;
            padding: 1rem;
        }

        .dashed {
            border-top: 1px dashed var(--bs-border-color);
        }

        /* ===== Mobile sidebar toggle (no JS) ===== */
        /* Hidden checkbox acts as the toggle state */
        #menuToggle {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        /* Overlay doubles as a label so tapping it closes the menu */
        .overlay {
            display: none;
        }

        /* On mobile, convert sidebar into an off-canvas that slides in */
        @media (max-width: 991.98px) {

            /* Force the sidebar to exist (override d-none) and make it off-canvas */
            .sidebar {
                display: block !important;
                position: fixed;
                z-index: 1040;
                top: var(--topbar-h);
                left: 0;
                height: calc(100vh - var(--topbar-h));
                width: var(--sidebar-width);
                background: var(--bs-body-bg);
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                box-shadow: none;
            }

            /* When toggled on, slide sidebar in and show overlay */
            #menuToggle:checked~.container-fluid .sidebar {
                transform: translateX(0);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }

            /* Clickable overlay to close the menu */
            #menuToggle:checked~.overlay {
                display: block;
                position: fixed;
                z-index: 1030;
                top: var(--topbar-h);
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.35);
            }
        }
    </style>
</head>

<body>
    <!-- Hidden checkbox controls the sidebar state -->
    <input type="checkbox" id="menuToggle" />

    <!-- Topbar -->
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

            <form class="d-none d-md-flex ms-2 flex-grow-1" role="search">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input class="form-control" type="search" placeholder="Search (static demo)" />
                </div>
            </form>

            <div class="d-flex align-items-center gap-2 ms-auto">
                <span class="badge text-bg-secondary d-none d-sm-inline">HTML-only demo</span>
                <div class="vr d-none d-sm-block"></div>
                <span class="text-body-secondary small d-none d-sm-inline">Admin</span>
                <i class="bi bi-person-circle fs-5"></i>
            </div>
        </div>
    </header>

    <!-- Click-to-close overlay (label so it toggles the checkbox off) -->
    <label for="menuToggle" class="overlay d-lg-none"></label>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (static on desktop, off-canvas on mobile) -->
            <aside class="col-lg-2 border-end min-vh-100 sidebar p-3 d-none d-lg-block">
                <nav class="nav flex-column gap-1">
                    <a class="nav-link active" href="#dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                    <a class="nav-link" href="#calendar"><i class="bi bi-calendar3 me-2"></i>Calendar</a>
                    <a class="nav-link" href="#appointments"><i class="bi bi-clipboard2-check me-2"></i>Appointments</a>
                    <a class="nav-link" href="#customers"><i class="bi bi-people me-2"></i>Customers</a>
                    <a class="nav-link" href="#services"><i class="bi bi-badge-ad me-2"></i>Services</a>
                    <a class="nav-link" href="#staff"><i class="bi bi-person-badge me-2"></i>Staff</a>
                    <a class="nav-link" href="#reports"><i class="bi bi-graph-up-arrow me-2"></i>Reports</a>
                    <a class="nav-link" href="#booking"><i class="bi bi-plus-lg me-2"></i>New Booking</a>
                    <a class="nav-link" href="#pos"><i class="bi bi-bag-check me-2"></i>POS</a>
                    <a class="nav-link" href="#settings"><i class="bi bi-gear me-2"></i>Settings</a>
                </nav>
            </aside>

            <!-- Main content -->
            <main class="col-lg-10 p-4">
                <!-- DASHBOARD -->
                <section id="dashboard" class="mb-5">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <div>
                            <h2 class="mb-0">Today at a Glance</h2>
                            <small class="text-body-secondary">Friday, Aug 22, 2025 (sample)</small>
                        </div>
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-secondary" href="#booking"><i class="bi bi-plus-lg me-2"></i>New
                                Booking</a>
                            <a class="btn btn-outline-secondary" href="#reports"><i
                                    class="bi bi-graph-up me-2"></i>Reports</a>
                            <a class="btn btn-outline-secondary" href="#pos"><i class="bi bi-bag me-2"></i>Open
                                POS</a>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card kpi h-100">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-body-secondary">Bookings</div>
                                        <div class="h3 mb-0">12</div>
                                    </div>
                                    <div class="icon bg-primary-subtle text-primary">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card kpi h-100">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-body-secondary">Expected Revenue</div>
                                        <div class="h3 mb-0">$640.00</div>
                                    </div>
                                    <div class="icon bg-success-subtle text-success">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card kpi h-100">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-body-secondary">Check-ins</div>
                                        <div class="h3 mb-0">5</div>
                                    </div>
                                    <div class="icon bg-info-subtle text-info">
                                        <i class="bi bi-person-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card kpi h-100">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-body-secondary">No-shows</div>
                                        <div class="h3 mb-0">1</div>
                                    </div>
                                    <div class="icon bg-danger-subtle text-danger">
                                        <i class="bi bi-x-octagon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-12 col-lg-8">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <span class="fw-semibold"><i class="bi bi-collection me-2"></i>Bookings by Status
                                        (Today)</span>
                                    <span class="text-body-secondary small">static table</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span class="status-pill status-booked"><i
                                                                class="bi bi-circle-fill"
                                                                style="font-size: 0.5rem"></i>Booked</span>
                                                    </td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="status-pill status-checkedin"><i
                                                                class="bi bi-circle-fill"
                                                                style="font-size: 0.5rem"></i>Checked-in</span>
                                                    </td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="status-pill status-inservice"><i
                                                                class="bi bi-circle-fill"
                                                                style="font-size: 0.5rem"></i>In service</span>
                                                    </td>
                                                    <td>2</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="status-pill status-completed"><i
                                                                class="bi bi-circle-fill"
                                                                style="font-size: 0.5rem"></i>Completed</span>
                                                    </td>
                                                    <td>2</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="status-pill status-noshow"><i
                                                                class="bi bi-circle-fill"
                                                                style="font-size: 0.5rem"></i>No-show</span>
                                                    </td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="status-pill status-cancelled"><i
                                                                class="bi bi-circle-fill"
                                                                style="font-size: 0.5rem"></i>Cancelled</span>
                                                    </td>
                                                    <td>0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card h-100">
                                <div class="card-header fw-semibold">
                                    <i class="bi bi-briefcase me-2"></i>Staff Utilization
                                    (Today)
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <strong>Maya</strong><span class="text-body-secondary">70%</span>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Maya utilization"
                                            aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 70%"></div>
                                        </div>
                                        <small class="text-body-secondary">5h 36m booked</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <strong>Ravi</strong><span class="text-body-secondary">55%</span>
                                        </div>
                                        <div class="progress" role="progressbar" aria-valuenow="55"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 55%"></div>
                                        </div>
                                        <small class="text-body-secondary">4h 24m booked</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <strong>Liam</strong><span class="text-body-secondary">40%</span>
                                        </div>
                                        <div class="progress" role="progressbar" aria-valuenow="40"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 40%"></div>
                                        </div>
                                        <small class="text-body-secondary">3h 12m booked</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CALENDAR (Day view - static) -->
                <section id="calendar" class="mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="mb-0">Calendar</h2>
                        <div class="d-flex gap-2">
                            <input type="date" class="form-control" value="2025-08-22"
                                aria-label="Date (static)" />
                            <select class="form-select" aria-label="Staff filter (static)">
                                <option>All staff</option>
                                <option selected>Maya</option>
                                <option>Ravi</option>
                                <option>Liam</option>
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="table-responsive scroll-section">
                            <table class="table align-middle table-hover mb-0 table-sticky">
                                <thead>
                                    <tr>
                                        <th style="width: 110px">Time</th>
                                        <th>Staff</th>
                                        <th>Service</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="text-nowrap">09:00</span></td>
                                        <td>Maya</td>
                                        <td>
                                            <div class="fw-semibold">Basic Haircut</div>
                                            <small class="text-body-secondary">30 min • $25</small>
                                        </td>
                                        <td>Alex Johnson</td>
                                        <td>
                                            <span class="status-pill status-booked"><i class="bi bi-circle-fill"
                                                    style="font-size: 0.5rem"></i>Booked</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10:00</td>
                                        <td>Ravi</td>
                                        <td>
                                            <div class="fw-semibold">Classic Facial</div>
                                            <small class="text-body-secondary">45 min • $40</small>
                                        </td>
                                        <td>Priya N.</td>
                                        <td>
                                            <span class="status-pill status-checkedin"><i class="bi bi-circle-fill"
                                                    style="font-size: 0.5rem"></i>Checked-in</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10:30</td>
                                        <td>Liam</td>
                                        <td>
                                            <div class="fw-semibold">Beard Trim</div>
                                            <small class="text-body-secondary">15 min • $12</small>
                                        </td>
                                        <td>Sahan P.</td>
                                        <td>
                                            <span class="status-pill status-inservice"><i class="bi bi-circle-fill"
                                                    style="font-size: 0.5rem"></i>In service</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>11:15</td>
                                        <td>Maya</td>
                                        <td>
                                            <div class="fw-semibold">Hair Color</div>
                                            <small class="text-body-secondary">90 min • $80</small>
                                        </td>
                                        <td>Alex Johnson</td>
                                        <td>
                                            <span class="status-pill status-completed"><i class="bi bi-circle-fill"
                                                    style="font-size: 0.5rem"></i>Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>13:00</td>
                                        <td>Ravi</td>
                                        <td>
                                            <div class="fw-semibold">Back Massage</div>
                                            <small class="text-body-secondary">60 min • $55</small>
                                        </td>
                                        <td>Priya N.</td>
                                        <td>
                                            <span class="status-pill status-booked"><i class="bi bi-circle-fill"
                                                    style="font-size: 0.5rem"></i>Booked</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- APPOINTMENTS (static) -->
                <section id="appointments" class="mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="mb-0">Appointments</h2>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control" placeholder="Search (static)" />
                            <select class="form-select">
                                <option>All statuses</option>
                                <option>Booked</option>
                                <option>Checked-in</option>
                                <option>In service</option>
                                <option>Completed</option>
                                <option>No-show</option>
                                <option>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="table-responsive scroll-section">
                            <table class="table align-middle table-hover mb-0 table-sticky">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>When</th>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Staff</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2025-08-22 09:00</td>
                                        <td>Alex Johnson</td>
                                        <td>Basic Haircut</td>
                                        <td>Maya</td>
                                        <td>$25</td>
                                        <td>
                                            <span class="status-pill status-booked">Booked</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>2025-08-22 10:00</td>
                                        <td>Priya N.</td>
                                        <td>Classic Facial</td>
                                        <td>Ravi</td>
                                        <td>$40</td>
                                        <td>
                                            <span class="status-pill status-checkedin">Checked-in</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>2025-08-22 10:30</td>
                                        <td>Sahan P.</td>
                                        <td>Beard Trim</td>
                                        <td>Liam</td>
                                        <td>$12</td>
                                        <td>
                                            <span class="status-pill status-inservice">In service</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>2025-08-22 11:15</td>
                                        <td>Alex Johnson</td>
                                        <td>Hair Color</td>
                                        <td>Maya</td>
                                        <td>$80</td>
                                        <td>
                                            <span class="status-pill status-completed">Completed</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- NEW BOOKING (static form) -->
                <section id="booking" class="mb-5">
                    <h2 class="mb-3">New Booking</h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="bkCustomer">Customer</label>
                                    <input class="form-control" id="bkCustomer" placeholder="Type customer name" />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="bkService">Service</label>
                                    <select class="form-select" id="bkService">
                                        <option>Basic Haircut • 30m • $25</option>
                                        <option>Hair Color • 90m • $80</option>
                                        <option>Beard Trim • 15m • $12</option>
                                        <option>Classic Facial • 45m • $40</option>
                                        <option>Back Massage • 60m • $55</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="bkStaff">Staff</label>
                                    <select class="form-select" id="bkStaff">
                                        <option>Maya</option>
                                        <option>Ravi</option>
                                        <option>Liam</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label" for="bkDate">Date</label>
                                    <input type="date" class="form-control" id="bkDate" value="2025-08-22" />
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label" for="bkTime">Time</label>
                                    <input type="time" class="form-control" id="bkTime" value="09:00" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="bkNotes">Notes</label>
                                    <textarea id="bkNotes" class="form-control" rows="2" placeholder="Preferences, allergies…"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end gap-2">
                            <button class="btn btn-outline-secondary" type="reset">
                                Clear
                            </button>
                            <button class="btn btn-primary" type="button">
                                Save (static)
                            </button>
                        </div>
                    </div>
                </section>

                <!-- POS (static) -->
                <section id="pos" class="mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="mb-0">Point of Sale</h2>
                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-secondary" href="#services"><i
                                    class="bi bi-list-ul me-2"></i>Services</a>
                            <a class="btn btn-outline-secondary" href="#customers"><i
                                    class="bi bi-people me-2"></i>Customers</a>
                        </div>
                    </div>
                    <div class="row g-3">
                        <!-- Sale composer -->
                        <div class="col-12 col-xl-8">
                            <div class="card h-100">
                                <div class="card-header fw-semibold">
                                    <i class="bi bi-receipt me-2"></i>Sale
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="posCustomer">Customer</label>
                                            <input id="posCustomer" class="form-control"
                                                placeholder="Alex Johnson (static)" />
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="form-label" for="posMethod">Payment method</label>
                                            <select id="posMethod" class="form-select">
                                                <option>Cash</option>
                                                <option selected>Card</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="form-label" for="posRef">Reference</label>
                                            <input id="posRef" class="form-control" placeholder="Last 4 / note" />
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Item</th>
                                                    <th style="width: 120px">Qty</th>
                                                    <th style="width: 140px">Unit</th>
                                                    <th style="width: 140px">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Hair Color</td>
                                                    <td>1</td>
                                                    <td>$80.00</td>
                                                    <td>$80.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Beard Trim</td>
                                                    <td>1</td>
                                                    <td>$12.00</td>
                                                    <td>$12.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label" for="posNotes">Notes</label>
                                        <textarea id="posNotes" class="form-control" rows="2" placeholder="Add receipt note (static)"></textarea>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a class="btn btn-outline-danger" href="#pos"><i
                                            class="bi bi-x-circle me-2"></i>Void (static)</a>
                                    <a class="btn btn-primary" href="#pos"><i
                                            class="bi bi-check2 me-2"></i>Complete Sale
                                        (static)</a>
                                </div>
                            </div>
                        </div>

                        <!-- Summary / receipt -->
                        <div class="col-12 col-xl-4">
                            <div class="card mb-3">
                                <div class="card-header fw-semibold">
                                    <i class="bi bi-list-check me-2"></i>Summary
                                </div>
                                <div class="card-body">
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Subtotal</span><strong>$92.00</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Tax (8%)</span><strong>$7.36</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Discount</span><strong>$0.00</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Total</span><strong class="fs-5">$99.36</strong>
                                        </li>
                                    </ul>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label" for="posTendered">Tendered</label>
                                            <input id="posTendered" class="form-control" value="$100.00" />
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Change</label>
                                            <div class="form-control bg-body-secondary">$0.64</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header fw-semibold">
                                    <i class="bi bi-printer me-2"></i>Receipt (preview)
                                </div>
                                <div class="card-body">
                                    <div class="receipt">
                                        <div class="text-center">
                                            <strong>Green Parrot Salon</strong><br />
                                            123 Main St, Colombo<br />
                                            011-1234567
                                        </div>
                                        <div class="dashed my-2"></div>
                                        <div>Date: 2025-08-22&nbsp;&nbsp;Time: 11:45</div>
                                        <div>Cashier: Admin</div>
                                        <div class="dashed my-2"></div>
                                        <div>Hair Color ................. $80.00</div>
                                        <div>Beard Trim .................. $12.00</div>
                                        <div class="dashed my-2"></div>
                                        <div>Subtotal .................... $92.00</div>
                                        <div>Tax (8%) .................... $7.36</div>
                                        <div>Total ........................ $99.36</div>
                                        <div>Paid (Card) ................. $100.00</div>
                                        <div>Change ...................... $0.64</div>
                                        <div class="dashed my-2"></div>
                                        <div class="text-center">Thank you! ✂️</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CUSTOMERS (static) -->
                <section id="customers" class="mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="mb-0">Customers</h2>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control" placeholder="Search (static)" />
                            <a class="btn btn-outline-secondary" href="#booking"><i
                                    class="bi bi-person-plus me-2"></i>Add & Book</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="table-responsive scroll-section">
                            <table class="table align-middle mb-0 table-sticky">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Visits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Alex Johnson</td>
                                        <td>555-0142</td>
                                        <td>alex@example.com</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Priya N.</td>
                                        <td>555-0199</td>
                                        <td>priya@example.com</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>Sahan P.</td>
                                        <td>077-1234567</td>
                                        <td>sahan@example.com</td>
                                        <td>1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- SERVICES (static) -->
                <section id="services" class="mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="mb-0">Services</h2>
                        <a class="btn btn-outline-secondary" href="#"><i class="bi bi-plus-circle me-2"></i>Add
                            Service (static)</a>
                    </div>
                    <div class="card">
                        <div class="table-responsive scroll-section">
                            <table class="table align-middle mb-0 table-sticky">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Basic Haircut</td>
                                        <td>Hair</td>
                                        <td>30 min</td>
                                        <td>$25</td>
                                    </tr>
                                    <tr>
                                        <td>Hair Color</td>
                                        <td>Hair</td>
                                        <td>90 min</td>
                                        <td>$80</td>
                                    </tr>
                                    <tr>
                                        <td>Beard Trim</td>
                                        <td>Grooming</td>
                                        <td>15 min</td>
                                        <td>$12</td>
                                    </tr>
                                    <tr>
                                        <td>Classic Facial</td>
                                        <td>Spa</td>
                                        <td>45 min</td>
                                        <td>$40</td>
                                    </tr>
                                    <tr>
                                        <td>Back Massage</td>
                                        <td>Spa</td>
                                        <td>60 min</td>
                                        <td>$55</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- STAFF (static) -->
                <section id="staff" class="mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h2 class="mb-0">Staff</h2>
                        <a class="btn btn-outline-secondary" href="#"><i class="bi bi-person-plus me-2"></i>Add
                            Staff (static)</a>
                    </div>
                    <div class="card">
                        <div class="table-responsive scroll-section">
                            <table class="table align-middle mb-0 table-sticky">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Skills</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Maya</td>
                                        <td>Haircut, Color, Blow Dry</td>
                                        <td>555-0101</td>
                                    </tr>
                                    <tr>
                                        <td>Ravi</td>
                                        <td>Massage, Facial</td>
                                        <td>555-0102</td>
                                    </tr>
                                    <tr>
                                        <td>Liam</td>
                                        <td>Haircut, Beard Trim</td>
                                        <td>555-0103</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- REPORTS (static) -->
                <section id="reports" class="mb-5">
                    <h2 class="mb-3">Reports</h2>
                    <div class="row g-3">
                        <div class="col-12 col-xl-6">
                            <div class="card h-100">
                                <div class="card-header fw-semibold">Sales Summary</div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Gross</th>
                                                    <th>Tax</th>
                                                    <th>Net</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Aug 16</td>
                                                    <td>$420</td>
                                                    <td>$33.60</td>
                                                    <td>$386.40</td>
                                                </tr>
                                                <tr>
                                                    <td>Aug 17</td>
                                                    <td>$510</td>
                                                    <td>$40.80</td>
                                                    <td>$469.20</td>
                                                </tr>
                                                <tr>
                                                    <td>Aug 18</td>
                                                    <td>$350</td>
                                                    <td>$28.00</td>
                                                    <td>$322.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Aug 19</td>
                                                    <td>$610</td>
                                                    <td>$48.80</td>
                                                    <td>$561.20</td>
                                                </tr>
                                                <tr>
                                                    <td>Aug 20</td>
                                                    <td>$580</td>
                                                    <td>$46.40</td>
                                                    <td>$533.60</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="card h-100">
                                <div class="card-header fw-semibold">
                                    No-shows & Cancellations
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Month</th>
                                                    <th>No-shows</th>
                                                    <th>Cancelled</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Apr</td>
                                                    <td>5</td>
                                                    <td>2</td>
                                                </tr>
                                                <tr>
                                                    <td>May</td>
                                                    <td>3</td>
                                                    <td>1</td>
                                                </tr>
                                                <tr>
                                                    <td>Jun</td>
                                                    <td>4</td>
                                                    <td>2</td>
                                                </tr>
                                                <tr>
                                                    <td>Jul</td>
                                                    <td>2</td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>Aug</td>
                                                    <td>1</td>
                                                    <td>2</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SETTINGS (static) -->
                <section id="settings" class="mb-5">
                    <h2 class="mb-3">Business Settings</h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label" for="bizName">Business name</label>
                                    <input id="bizName" class="form-control" placeholder="Green Parrot Salon" />
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="currency">Currency</label>
                                    <select id="currency" class="form-select">
                                        <option>USD</option>
                                        <option>LKR</option>
                                        <option>EUR</option>
                                        <option>GBP</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="taxRate">Tax rate (%)</label>
                                    <input id="taxRate" type="number" min="0" step="0.01"
                                        class="form-control" value="8" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="businessContact">Contact email</label>
                                    <input id="businessContact" type="email" class="form-control"
                                        placeholder="hello@greenparrot.example" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end gap-2">
                            <button class="btn btn-outline-secondary" type="reset">
                                Reset
                            </button>
                            <button class="btn btn-primary" type="button">
                                Save (static)
                            </button>
                        </div>
                    </div>
                </section>

                <footer class="text-center text-body-secondary small py-4">
                    © 2025 Salon Manager (Demo). Built with Bootstrap 5. No JavaScript.
                </footer>
            </main>
        </div>
    </div>
</body>

</html>
