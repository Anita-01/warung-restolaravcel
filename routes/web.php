<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 

// =======================
// USER / PUBLIC
// =======================

Route::get('/', [MenuController::class, 'index'])->name('home');

Route::get('/user/menu', [UserController::class, 'index'])->name('viewmenu');
Route::get('/reserved', [UserController::class, 'createreserved'])->name('reserved');


// =======================
// RESERVATION
// =======================

Route::post('/reservation', [ReservationController::class, 'makeReservation'])
    ->name('reservation.store');

Route::get('/queue-data', [ReservationController::class, 'queueData'])
    ->name('queue.data');

Route::get('/reservation/{id}', [ReservationController::class, 'detailReservation'])
    ->name('reservation.detail');

Route::get('/invoice/{id}', [ReservationController::class, 'downloadInvoice'])
    ->name('invoice.download');

Route::post('/trace/confirm', [ReservationController::class, 'traceConfirm'])
    ->name('trace.confirm');

Route::get('/trace/{id}', [ReservationController::class, 'traceOrder'])
    ->name('trace.order');


// =======================
// ADMIN AUTH
// =======================

Route::get('/admin/loginadmin', [LoginAdminController::class, 'loginForm'])
    ->name('login');

Route::post('/login', [LoginAdminController::class, 'login'])
    ->name('login.process');

Route::get('/logout', [LoginAdminController::class, 'logout'])
    ->name('logout');


// =======================
// ADMIN DASHBOARD
// =======================

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboardadmin', function () {
        return view('admin.dashboardadmin');
    })->name('dashboardadmin');
});


// =======================
// PRODUCT / MENU CRUD
// =======================

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/add', [ProductController::class, 'add'])
    ->name('products.add');

Route::post('/products', [ProductController::class, 'store'])
    ->name('createProducts');

Route::post('/products/addmenu', [ProductController::class, 'store'])
    ->name('addmenu');

Route::get('/editmenu/{id}', [ProductController::class, 'edit'])
    ->name('editmenu');

Route::post('/products/updateProduct', [ProductController::class, 'updateProduct'])
    ->name('products.update');

Route::delete('/products/{id}', [ProductController::class, 'destroy'])
    ->name('products.destroy');

Route::get('/products/search', [ProductController::class, 'search'])
    ->name('products.search');

    Route::post('/orders', [UserOrderController::class, 'store'])->name('orders.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::put('/orders/{id}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
    Route::put('/orders/{id}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::put('/orders/{id}/done', [AdminOrderController::class, 'done'])->name('orders.done');
});