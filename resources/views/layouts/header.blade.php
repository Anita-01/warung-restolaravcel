<div class="container-xxl bg-white p-0">
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar & Hero Start -->
    <div class="container-xxl position-relative p-0">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">

            <!-- Logo -->
            <a href="{{ route('index') }}" class="navbar-brand p-0">
                <h1 class="text-primary m-0">
                    <i class="fa fa-utensils me-3"></i>Restoran
                </h1>
            </a>

            <!-- Toggle Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarCollapse">

                <div class="navbar-nav ms-auto py-0 pe-4">

                    <a href="{{ route('index') }}"
                        class="nav-item nav-link {{ request()->routeIs('index') ? 'active' : '' }}">
                        Home
                    </a>

                    <a href="{{ route('about') }}"
                        class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                        About
                    </a>

                    <a href="{{ route('service') }}"
                        class="nav-item nav-link {{ request()->routeIs('service') ? 'active' : '' }}">
                        Service
                    </a>

                    <a href="{{ route('menu') }}"
                        class="nav-item nav-link {{ request()->routeIs('menu') ? 'active' : '' }}">
                        Menu
                    </a>

                    <!-- Dropdown (INTERAKTIF) -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            Pages
                        </a>
                        <div class="dropdown-menu m-0">
                            <a href="{{ route('trace.order') }}" class="dropdown-item">Tracking Order</a>
                            <a href="{{ route('login') }}" class="dropdown-item">Login</a>
                        </div>
                    </div>

                </div>

                <!-- CTA BUTTON -->
                <a href="{{ route('reserved') }}" class="btn btn-primary py-2 px-4">
                    Book A Table
                </a>

            </div>
        </nav>
    </div>