<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard — Warung Muslim Lia</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Fonts: Fraunces for display, Plus Jakarta Sans for body/UI --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --ink-indigo: #1E2A4A;
            --ink-indigo-soft: #2A3A63;
            --turmeric: #D9A441;
            --turmeric-soft: #F3E3C1;
            --ivory: #FBF7EF;
            --charcoal: #2B2B2B;
            --clove: #6B4226;
            --leaf: #4F7942;
            --chili: #B23A2E;
            --teal: #2E6E6E;
            --card-radius: 14px;
        }

        * {
            font-variant-numeric: tabular-nums;
        }

        html,
        body {
            background: var(--ivory);
            color: var(--charcoal);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-size: 14px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .display-font {
            font-family: 'Fraunces', Georgia, serif;
            letter-spacing: -0.01em;
        }

        a {
            text-decoration: none;
        }

        /* ---------- Topbar ---------- */
        .topbar {
            background: var(--ink-indigo);
            color: var(--ivory);
        }

        .topbar .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--turmeric);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-indigo);
            font-size: 1.05rem;
        }

        .topbar .brand-name {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--ivory);
        }

        .topbar .brand-name small {
            display: block;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 400;
            font-size: 0.68rem;
            color: rgba(251, 247, 239, 0.65);
            letter-spacing: 0.04em;
        }

        /* ---------- Sidebar ---------- */
        .sidebar {
            min-height: calc(100vh - 56px);
            background: var(--ink-indigo);
            position: relative;
            overflow: hidden;
        }

        /* subtle parang-inspired diagonal wave texture, purely decorative */
        .sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0.06;
            pointer-events: none;
            background-image: repeating-linear-gradient(45deg,
                    var(--turmeric) 0px,
                    var(--turmeric) 2px,
                    transparent 2px,
                    transparent 34px);
        }

        .sidebar .nav {
            position: relative;
            z-index: 1;
        }

        .sidebar .nav-link {
            color: rgba(251, 247, 239, 0.75);
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            margin-bottom: 2px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: background-color 0.15s ease, color 0.15s ease;
        }

        .sidebar .nav-link i {
            width: 1.3rem;
        }

        .sidebar .nav-link:hover {
            background: rgba(217, 164, 65, 0.12);
            color: var(--ivory);
        }

        .sidebar .nav-link.active {
            background: rgba(217, 164, 65, 0.16);
            color: var(--turmeric);
            border-left-color: var(--turmeric);
            font-weight: 700;
        }

        .sidebar .nav-link.text-danger {
            color: #E8998D !important;
        }

        .sidebar .nav-link.text-danger:hover {
            background: rgba(178, 58, 46, 0.18);
            color: #fff !important;
        }

        .sidebar-heading {
            color: rgba(251, 247, 239, 0.45);
            font-size: 0.7rem;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            font-weight: 700;
        }

        /* ---------- Stat cards ---------- */
        .stat-card {
            border: none;
            border-radius: var(--card-radius);
            background: #fff;
            box-shadow: 0 1px 3px rgba(30, 42, 74, 0.06);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }

        .stat-value {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.65rem;
            line-height: 1.1;
        }

        .stat-delta.up {
            color: var(--leaf);
        }

        .stat-delta.down {
            color: var(--chili);
        }

        /* ---------- Quick access cards ---------- */
        .quick-card {
            border: none;
            border-radius: var(--card-radius);
            background: #fff;
            box-shadow: 0 1px 3px rgba(30, 42, 74, 0.06);
            cursor: pointer;
        }

        @media (prefers-reduced-motion: no-preference) {
            .quick-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .quick-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 24px rgba(30, 42, 74, 0.12);
            }
        }

        .quick-card .icon-badge {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.6rem;
        }

        .quick-card h6 {
            font-weight: 700;
            color: var(--charcoal);
            margin-bottom: 0.15rem;
        }

        .quick-card p {
            font-size: 0.78rem;
            color: #7a7a7a;
            margin-bottom: 0;
        }

        .badge-gold {
            background: rgba(217, 164, 65, 0.16);
            color: #A5771F;
        }

        .badge-leaf {
            background: rgba(79, 121, 66, 0.14);
            color: var(--leaf);
        }

        .badge-indigo {
            background: rgba(30, 42, 74, 0.10);
            color: var(--ink-indigo);
        }

        .badge-clove {
            background: rgba(107, 66, 38, 0.14);
            color: var(--clove);
        }

        .badge-teal {
            background: rgba(46, 110, 110, 0.14);
            color: var(--teal);
        }

        .badge-chili {
            background: rgba(178, 58, 46, 0.12);
            color: var(--chili);
        }

        /* ---------- Weekly bar chart (pure CSS) ---------- */
        .mini-chart {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            height: 130px;
            padding-top: 0.5rem;
        }

        .mini-chart .bar-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .mini-chart .bar {
            width: 100%;
            max-width: 26px;
            border-radius: 6px 6px 3px 3px;
            background: var(--turmeric-soft);
        }

        .mini-chart .bar-col.is-today .bar {
            background: var(--turmeric);
        }

        .mini-chart .bar-label {
            font-size: 0.68rem;
            color: #9a9a9a;
        }

        .mini-chart .bar-col.is-today .bar-label {
            color: var(--ink-indigo);
            font-weight: 700;
        }

        /* ---------- Menu list ---------- */
        .menu-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.55rem 0;
            border-bottom: 1px dashed #ece5d6;
        }

        .menu-row:last-child {
            border-bottom: none;
        }

        .menu-rank {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--turmeric-soft);
            color: #A5771F;
            font-weight: 700;
            font-size: 0.72rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* ---------- Focus visibility ---------- */
        a:focus-visible,
        button:focus-visible,
        .nav-link:focus-visible {
            outline: 2px solid var(--turmeric);
            outline-offset: 2px;
        }

        .section-eyebrow {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--clove);
        }
    </style>
</head>

<body>

    {{-- Topbar --}}
    <header class="topbar navbar sticky-top shadow-sm px-3">
        <div class="d-flex align-items-center gap-2">
            <button class="navbar-toggler border-0 text-white d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarNav" aria-label="Buka menu">
                <i class="bi bi-list fs-4 text-white"></i>
            </button>
            <span class="brand-mark"><i class="bi bi-egg-fried"></i></span>
            <span class="brand-name">
                Warung Muslim Lia
                <small>Panel Admin</small>
            </span>
        </div>

        <div class="d-none d-md-flex align-items-center flex-grow-1 mx-4" style="max-width: 420px;">
            <div class="input-group">
                <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control border-0" placeholder="Cari pesanan, menu, atau pelanggan…">
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 ms-auto">
            <button class="btn btn-link text-white p-0 position-relative" aria-label="Notifikasi">
                <i class="bi bi-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle"></span>
            </button>
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width:34px;height:34px;background:var(--turmeric-soft);color:#A5771F;font-weight:700;">
                    A
                </div>
                <span class="d-none d-lg-inline text-white-50 small">Admin</span>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar --}}
            <nav id="sidebarNav" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="pt-4 px-2">

                    <div class="sidebar-heading px-2 mb-2">Menu Utama</div>
                    <ul class="nav flex-column mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="bi bi-house me-2"></i> Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="bi bi-receipt me-2"></i> Pesanan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="bi bi-basket me-2"></i> Produk / Menu
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users') }}">
                                <i class="bi bi-people me-2"></i> Data Admin
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('report') }}" class="nav-link">
                                <i class="bi bi-graph-up me-2"></i> Laporan
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-heading px-2 mb-2">Lainnya</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-gear me-2"></i> Pengaturan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                            </a>
                        </li>
                    </ul>

                </div>
            </nav>

            {{-- Main Content --}}
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-5">
                <div class="pt-4 pb-2">
                    <span class="section-eyebrow">Assalamu'alaikum</span>
                    <h1 class="mb-1">Selamat datang kembali 👋</h1>
                    <p class="text-muted mb-0" id="todayDate">Berikut ringkasan warung Anda hari ini.</p>
                </div>

                {{-- Stat cards --}}
                <div class="row mt-3 g-3">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 h-100">
                            <span class="stat-icon badge-gold mb-2"><i class="bi bi-receipt-cutoff"></i></span>
                            <div class="stat-value">{{ $totalAll }}</div>
                            <div class="small text-muted">Pesanan hari ini</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 h-100">
                            <span class="stat-icon badge-leaf mb-2"><i class="bi bi-wallet2"></i></span>
                            <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                            <div class="small text-muted">Pendapatan hari ini</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 h-100">
                            <span class="stat-icon badge-chili mb-2"><i class="bi bi-hourglass-split"></i></span>
                            <div class="stat-value">{{ $totalPending }}</div>
                            <div class="small text-muted">Pesanan menunggu</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 h-100">
                            <span class="stat-icon badge-indigo mb-2"><i class="bi bi-basket2"></i></span>
                            <div class="stat-value">{{ $totalCompleted }}</div>
                            <div class="small text-muted">Menu aktif</div>
                        </div>
                    </div>
                </div>

                {{-- Chart + popular menu --}}
                <div class="row mt-4 g-3">
                    <div class="col-lg-7">
                        <div class="card stat-card p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="section-eyebrow">Minggu ini</span>
                                    <h6 class="mb-0 mt-1">Tren Penjualan</h6>
                                </div>
                            </div>
                            <canvas id="dashboardChart" height="120"></canvas>
                            <p class="small text-muted mt-2 mb-0">Grafik pendapatan berdasarkan pesanan yang telah selesai.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card stat-card p-3 h-100">
                            <span class="section-eyebrow">Terlaris</span>
                            <h6 class="mb-2 mt-1">Menu Paling Diminati</h6>
                            <div>
                                @forelse($productSales as $index => $product)

                                    <div class="menu-row">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="menu-rank">
                                                {{ $index + 1 }}
                                            </span>
                                            <span>
                                                {{ $product->name }}
                                            </span>
                                        </div>

                                        <span class="fw-semibold">
                                            {{ $product->total }} porsi
                                        </span>
                                    </div>

                                @empty
                                    <div class="text-center text-muted py-3">
                                        Belum ada data penjualan.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick access --}}
                <div class="mt-4 mb-2">
                    <span class="section-eyebrow">Akses Cepat</span>
                    <h6 class="mt-1">Kelola Warung</h6>
                </div>
                <div class="row g-3">

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">
                            <div class="card quick-card p-3 h-100">
                                <span class="icon-badge badge-gold"><i class="bi bi-receipt"></i></span>
                                <h6>Pesanan</h6>
                                <p>Kelola pesanan masuk</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">
                            <div class="card quick-card p-3 h-100">
                                <span class="icon-badge badge-leaf"><i class="bi bi-basket"></i></span>
                                <h6>Produk</h6>
                                <p>Atur menu &amp; stok</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('admin.users') }}" class="text-decoration-none text-dark">
                            <div class="card quick-card p-3 h-100">
                                <span class="icon-badge badge-indigo"><i class="bi bi-people"></i></span>
                                <h6>Data Admin</h6>
                                <p>Kelola akses pengguna</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('report') }}" class="text-decoration-none text-dark">
                            <div class="card quick-card p-3 h-100">
                                <span class="icon-badge badge-clove"><i class="bi bi-graph-up"></i></span>
                                <h6>Laporan</h6>
                                <p>Lihat performa penjualan</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card quick-card p-3 h-100">
                                <span class="icon-badge badge-teal"><i class="bi bi-puzzle"></i></span>
                                <h6>Integrasi</h6>
                                <p>Sambungkan layanan lain</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card quick-card p-3 h-100">
                                <span class="icon-badge badge-gold"><i class="bi bi-calendar-week"></i></span>
                                <h6>Bulan Ini</h6>
                                <p>Ringkasan bulan berjalan</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card quick-card p-3 h-100">
                                <span class="icon-badge badge-chili"><i class="bi bi-megaphone"></i></span>
                                <h6>Promo</h6>
                                <p>Kelola diskon &amp; promosi</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card quick-card p-3 h-100">
                                <span class="icon-badge badge-indigo"><i class="bi bi-gear"></i></span>
                                <h6>Pengaturan</h6>
                                <p>Preferensi warung</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <form action="{{ route('logout') }}" method="POST" class="h-100">
                            @csrf
                            <button type="submit" class="card quick-card border-0 w-100 h-100 bg-white text-start p-3">
                                <span class="icon-badge badge-chili"><i class="bi bi-box-arrow-right"></i></span>
                                <h6>Keluar</h6>
                                <p>Akhiri sesi admin</p>
                            </button>
                        </form>
                    </div>

                </div>
            </main>

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Show today's date in the greeting subtitle
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById('todayDate');
            if (el) {
                var formatted = new Date().toLocaleDateString('id-ID', {
                    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                });
                el.textContent = 'Berikut ringkasan warung Anda pada ' + formatted + '.';
            }
        });
    </script>

    <script>
        const labels = @json($dailySales->pluck('date'));
        const totals = @json($dailySales->pluck('total'));
        new Chart(document.getElementById('dashboardChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: totals,
                    borderColor: '#1E2A4A',
                    backgroundColor: 'rgba(30,42,74,.15)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>