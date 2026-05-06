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
                        <a class="nav-link" href="#">
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
                        <a class="nav-link" href="#">
                            <i class="bi bi-graph-up me-2"></i> Reports
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-puzzle me-2"></i> Integrations
                        </a>
                    </li>
                </ul>

                <h6 class="text-muted px-3 mt-4 mb-1">SAVED REPORTS</h6>

                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-file-earmark-text me-2"></i> Current month
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-file-earmark-text me-2"></i> Last quarter
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-file-earmark-text me-2"></i> Social engagement
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-file-earmark-text me-2"></i> Year-end sale
                        </a>
                    </li>
                </ul>

                <hr>

                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear me-2"></i> Settings
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#">
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
        </main>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>