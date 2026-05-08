<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Admin\ReservationAdminController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [MenuController::class, 'index'])->name('index');

// Auth Routes
Route::get('/login', [LoginAdminController::class, 'loginForm'])->name('login.form');
Route::post('/login', [LoginAdminController::class, 'login'])->name('login');
Route::get('/logout', [LoginAdminController::class, 'logout'])->name('logout');

// User & Product Browsing
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product', [ProductController::class, 'viewMenu'])->name('menu');
Route::get('/products/search', [ProductController::class, 'search']);

Route::get('/user/menu', [UserController::class, 'index'])->name('viewmenu');
Route::get('/reserved', [UserController::class, 'createreserved'])->name('reserved');

// Reservation & Tracking
Route::post('/reservation', [ReservationController::class, 'makeReservation'])->name('reservation.store');
Route::get('/queue-data', [ReservationController::class, 'queueData']);
Route::get('/reservation/{id}', [ReservationController::class, 'detailReservation'])->name('reservation.detail');
Route::get('/invoice/{id}', [ReservationController::class, 'downloadInvoice'])->name('invoice.download');

Route::view('/trace', 'user.trace')->name('trace');
Route::get('/trace-order', function () { return view('user.trace-form'); })->name('trace.order');
Route::post('/trace-confirm', [ReservationController::class, 'traceOrder'])->name('trace.confirm');

Route::post('/orders', [ReservationController::class, 'store'])->name('orders.store');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by Auth & Admin Middleware)
|--------------------------------------------------------------------------
*/

   
    // Dashboard
    Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboardadmin', function () {
            return view('admin.dashboardadmin');
        })->name('dashboardadmin');

        // Product Management

        Route::get('/products/add', [ProductController::class, 'add'])->name('products.add');
        Route::get('/products/view', [ProductController::class, 'index'])->name('products.view');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        

        // Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{id}', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::post('/users/update/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // orders
         Route::get('/orders', [ReservationAdminController::class, 'index'])  ->name('admin.orders.index');
        Route::get('/orders/{id}', [ReservationAdminController::class, 'show'])->name('orders.detail');
  Route::patch('/orders/{id}', [ReservationAdminController::class, 'updateStatus'])->name('orders.updateStatus');

Route::post('/orders/{id}/status', [ReservationAdminController::class, 'updateStatusAjax']) ->name('admin.orders.updateStatusAjax');
    Route::get('/report/pdf', [ReservationAdminController::class, 'exportPdf'])->name('admin.report.pdf');
    Route::get('/admin/report', [ReservationAdminController::class, 'report'])->name('admin.report');
});