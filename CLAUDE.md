# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Restaurant reservation and menu management system ("Warung Muslim Lia") built with Laravel 13, PHP 8.3, Tailwind CSS 4, and Vite 8. The app has a public-facing menu/ordering/reservation flow and an admin panel for managing products and admin users.

## Commands

```bash
# Development (runs server + queue + logs + vite concurrently)
composer dev

# Build frontend assets
npm run build

# Run all tests
composer test

# Run a single test
php artisan test --filter=TestName

# Format code with Laravel Pint
vendor/bin/pint

# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Tinker REPL
php artisan tinker

# Log viewer
php artisan pail
```

## Architecture

### Authentication

- Login uses the `name` field as the primary credential (not email).
- `App\Models\User` has `role` (e.g., `'admin'`) and `is_active` columns.
- Session-based auth via the `web` guard.
- Custom `AdminMiddleware` checks `Auth::user()->role === 'admin'`; registered as `'admin'` alias in `bootstrap/app.php`.

### Models & Relationships

- **Category** (`categories`): `hasMany` Menu, `hasMany` Product. Fields: `name`, `icon` (FontAwesome class), `subtitle`.
- **Menu** (`menus`): `belongsTo` Category. Static menu items displayed on the landing page (not involved in reservations).
- **Product** (`products`): `belongsTo` Category, `hasMany` ReservationItem. This is what customers actually order. Uses eager loading (`$with = ['category']`).
- **Reservation** (`reservations`): `hasMany` ReservationItem. Tracks `invoice`, `reservation_date`, `total_price`, `queue_number`, `status` (pending/waiting).
- **ReservationItem** (`reservation_items`): `belongsTo` Reservation, `belongsTo` Product. Pivot for reservation line items with `quantity` and `price`.

### Queue System

- Each day starts at queue number 1. The next queue number is derived from `MAX(queue_number)` for today's date.
- Queue numbers are formatted as `A001`, `A002`, etc.
- Estimated wait time = `queue_number * 5` minutes.
- Invoice format: `INV-YYYYMMDD-NNN`.

### Key Business Logic

- **Reservation flow**: `makeReservation()` in `ReservationController` validates input, filters products with qty > 0, wraps everything in a DB transaction, calculates total price from product prices, and returns queue info for display via SweetAlert.
- **Order tracking**: `traceOrder()` looks up reservations by invoice number and email.
- **Invoice PDF**: Generated via `barryvdh/laravel-dompdf` using the `user.invoice_pdf` Blade view.

### Routes Structure

| Prefix | Middleware | Purpose |
|--------|-----------|---------|
| `/` | none | Landing page, menu, reservation form, tracking |
| `/admin/dashboardadmin` | `auth` | Admin dashboard |
| `/products` | none | Product CRUD (admin menu management) |
| `/admin/users` | `auth` + `admin` | Admin user management CRUD |

### Database

- Default connection is SQLite (`.env.example` sets `DB_CONNECTION=sqlite`).
- `db_warungmuslimlia.sql` is a MySQL dump containing the full schema and seed data (categories, menus, products, sample users).
- Tests use SQLite in-memory (`:memory:`).
- Default users in the dump: `admin1`, `admin2`, `admin3` (passwords are bcrypt hashes).

### Frontend

- Tailwind CSS 4 via the Vite plugin (`@tailwindcss/vite`).
- Layouts: `layouts/welcome.blade.php` (public pages), `layouts/app.blade.php` (admin).
- Laravel Vite plugin with auto-refresh enabled.
- `resources/js/app.js` and `resources/css/app.css` are the Vite entry points.

### Docker & Deploy

```bash
# Build image locally
docker build -f deploy/Dockerfile -t warung-restolaravcel .

# Start full stack (app + MariaDB + Redis)
docker compose -f deploy/docker-compose.yaml up -d
```

- `deploy/Dockerfile` — multi-stage: composer install → npm build → PHP-FPM + Nginx runtime on Alpine
- `deploy/docker-compose.yaml` — app, MariaDB 11, Redis 7 with healthchecks
- `deploy/deploy.sh` — pull image from GHCR, restart, run migrations + seeders, cleanup
- `.github/workflows/deploy.yml` — builds on push to `master`, pushes to `ghcr.io/andreejait/warung-restolaravcel`, deploys via cloudflared SSH

### Notable Details

- `app/Http/Controllers/Bootstrap.php` exists but appears to be a misnamed file.
- Product `store()` route is registered twice (once as `addmenu`, once as `createProducts`).
- Product edit submits via AJAX (JSON response), while create uses redirect with flash message.
- Seeders: `CategorySeeder` runs before `MenuSeeder`. MenuSeeder uses `firstOrCreate` to avoid duplicate categories.
