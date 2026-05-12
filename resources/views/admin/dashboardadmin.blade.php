<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-size: 14px;
        }

        .sidebar {
            height: 100vh;
        }

        .nav-link {
            color: #0d6efd;
        }

        .nav-link.active {
            font-weight: bold;
        }

            .dashboard-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 12px;
    }

    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        background-color: #f8f9fa;
    }

    .dashboard-card:hover i {
        transform: scale(1.2);
        transition: 0.3s;
    }

    .dashboard-card i {
        transition: 0.3s;
    }

    </style>
</head>

<body>

{{-- Navbar --}}
<header class="navbar navbar-dark sticky-top bg-dark shadow">
    <a class="navbar-brand px-3" href="#">Warung Muslim Lia</a>
</header>

<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="pt-3 px-2">

                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-house me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            <i class="bi bi-file-earmark me-2"></i> Orders
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="bi bi-cart me-2"></i> Products
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users') }}">
                            <i class="bi bi-people me-2"></i> Data Admin
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('report') }}" class="nav-link">
                            <i class="bi bi-graph-up me-2"></i> Reports
                        </a>
                    </li>

                   

                    <li class="nav-item">
                        <a class="nav-link text-danger" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right me-2"></i> Sign out
                        </a>
                    </li>
                </ul>

            </div>
        </nav>

        {{-- Main Content --}}
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="pt-4">
                <h1>Dashboard</h1>
                <p>Welcome to admin dashboard 👋</p>
            </div>
            <div class="row mt-4 g-3">

<div class="col-md-3">
    <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-file-earmark fs-3 text-primary"></i>
                <h6 class="mt-2">Orders</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-cart fs-3 text-primary"></i>
                <h6 class="mt-2">Products</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="{{ route('admin.users') }}" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-people fs-3 text-primary"></i>
                <h6 class="mt-2">Data Admin</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="{{ route('report') }}" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-graph-up fs-3 text-primary"></i>
                <h6 class="mt-2">Reports</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="#" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-puzzle fs-3 text-primary"></i>
                <h6 class="mt-2">Integrations</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="#" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-file-earmark-text fs-3 text-primary"></i>
                <h6 class="mt-2">Current month</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="#" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-file-earmark-text fs-3 text-primary"></i>
                <h6 class="mt-2">Last quarter</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="#" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-file-earmark-text fs-3 text-primary"></i>
                <h6 class="mt-2">Social engagement</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="#" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-file-earmark-text fs-3 text-primary"></i>
                <h6 class="mt-2">Year-end sale</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="#" class="text-decoration-none text-dark">
        <div class="card shadow-sm dashboard-card">
            <div class="card-body">
                <i class="bi bi-gear fs-3 text-primary"></i>
                <h6 class="mt-2">Settings</h6>
            </div>
        </div>
    </a>
</div>

<div class="col-md-3">
    <form action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="card card shadow-sm dashboard-card border-0 w-100 bg-white text-start">
            <div class="card-body">
                <i class="bi bi-box-arrow-right fs-3 text-danger"></i>
                <h6 class="mt-2 text-dark">Sign out</h6>
            </div>
        </button>
    </form>
</div>

</div>
        </main>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>