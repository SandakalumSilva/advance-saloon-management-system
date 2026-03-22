<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Salon Manager • Login</title>
    <!-- Bootstrap 5 (CSS only) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #fdfdfd, #f4f7fb);
        }

        .max-w-420 {
            max-width: 420px;
        }

        .brand-badge {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: grid;
            place-items: center;
        }

        .card {
            border-radius: 1rem;
        }

        .form-floating>label {
            color: var(--bs-secondary-color);
        }

        .separator {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0.75rem 0;
        }

        .separator::before,
        .separator::after {
            content: "";
            height: 1px;
            background: var(--bs-border-color);
            flex: 1;
        }

        .footer-links a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <main class="container d-flex align-items-center justify-content-center py-5">
        <div class="w-100 max-w-420">
            <div class="text-center mb-4">
                <div class="brand-badge bg-primary-subtle text-primary mx-auto mb-2">
                    <i class="bi bi-scissors" style="font-size: 1.5rem"></i>
                </div>
                <h1 class="h4 mb-0">Salon Manager</h1>
                <small class="text-body-secondary">Sign in to continue</small>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <!-- Adjust action to your app route (e.g., /login in Laravel) -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="name@example.com" value="{{ old('email') }}" />
                            <label for="email">Email address</label>
                            @if ($errors->has('email'))
                                <div class="text-danger mt-1">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" />
                            <label for="password">Password</label>
                            @if ($errors->has('password'))
                                <div class="text-danger mt-1">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>


                        <button class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign in
                        </button>

                    </form>
                </div>
            </div>


            <p class="text-center text-body-secondary small mt-3 mb-0">
                © @php
                    echo date('Y') . '-' . 'Salon Manager.';
                @endphp
            </p>
        </div>
    </main>
</body>

</html>
