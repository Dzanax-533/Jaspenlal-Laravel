<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - IHATEC Halal System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .sidebar { min-height: 100vh; width: 250px; background: #2c3e50; color: white; position: fixed; }
        .content { margin-left: 250px; padding: 20px; background: #f8f9fa; min-height: 100vh; }
        .nav-link { color: #bdc3c7; margin-bottom: 5px; }
        .nav-link:hover, .nav-link.active { background: #34495e; color: white; border-radius: 5px; }
        .nav-header { font-size: 0.75rem; text-transform: uppercase; color: #7f8c8d; font-weight: bold; padding: 10px 15px; }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column p-3">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4 fw-bold">IHATEC</span>
        </a>
        <hr>

        <ul class="nav nav-pills flex-column mb-auto">
            @include('layouts.partials.sidebar_menu')
        </ul>

        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <strong>{{ auth()->user()->name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Sign out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <main class="content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
