<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Salon Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

    <style>
        :root {
            --sidebar-width: 240px;
            --topbar-h: 56px;
        }

        .sidebar {
            width: var(--sidebar-width);
        }
    </style>

</head>

<body>

    <input type="checkbox" id="menuToggle" />

    {{-- HEADER --}}
    @include('layouts.header')

    <label for="menuToggle" class="overlay d-lg-none"></label>

    <div class="container-fluid">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('layouts.sidebar')

            {{-- MAIN CONTENT --}}
            <main class="col-lg-10 p-4">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- FOOTER --}}
    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-..." crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/lineSpinner.js"></script>

    @yield('script')

</body>

</html>
