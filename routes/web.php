<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Admin\ReservationAdminController;


// ===============================
// HOME
// ===============================

Route::get('/', [MenuController::class, 'index'])->name('index');


// ===============================
// ABOUT & SERVICE
// ===============================

Route::get('/about', [ProductController::class, 'about'])->name('about');

Route::get('/service', [ProductController::class, 'service'])->name('service');


// ===============================
// PRODUCT
// ===============================

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/editmenu/{id}', [ProductController::class, 'edit'])->name('editmenu');

Route::post('/products/addmenu', [ProductController::class, 'store'])->name('addmenu');

Route::post('/products/updateProduct', [ProductController::class, 'updateProduct'])->name('updateProduct');

Route::get('/products/search', [ProductController::class, 'search'])->name('search');

Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('destroy');

Route::get('/products/add', [ProductController::class, 'add'])->name('products.add');

Route::post('/products', [ProductController::class, 'store'])->name('createProducts');

Route::get('/product', [ProductController::class, 'viewMenu'])->name('menu');

Route::get('/menu/{id}', [ProductController::class, 'show'])->name('menu.detail');


// ===============================
// USER MENU
// ===============================

Route::get('/user/menu', [UserController::class, 'index'])->name('viewmenu');


// ===============================
// RESERVATION
// ===============================

Route::get('/reserved', [UserController::class, 'createreserved'])->name('reserved');

Route::post('/reservation', [ReservationController::class, 'makeReservation'])->name('reservation.store');

Route::get('/queue-data', [ReservationController::class, 'queueData']);

Route::get('/reservation/{id}', [ReservationController::class, 'detailReservation'])->name('reservation.detail');

Route::get('/invoice/{id}', [ReservationController::class, 'downloadInvoice'])->name('invoice.download');

Route::get('/api/reservation-status/{invoice}', function ($invoice) {

    $reservation = App\Models\Reservation::where('invoice', $invoice)->first();

    return response()->json([
        'status' => $reservation->status
    ]);

});


// ===============================
// TRACE ORDER
// ===============================

Route::view('/trace', 'user.trace')->name('trace');

Route::get('/trace-order', function () {
    return view('user.trace-form'); 
})->name('trace.order');

Route::post('/trace-confirm', [ReservationController::class, 'traceOrder'])->name('trace.confirm');


// ===============================
// AUTHENTICATION
// ===============================

Route::get('/login', [LoginAdminController::class, 'loginForm'])->name('login');

Route::post('/login', [LoginAdminController::class, 'login']);

Route::get('/logout', [LoginAdminController::class, 'logout'])->name('logout');


// ===============================
// ADMIN DASHBOARD
// ===============================

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboardadmin', [ReservationAdminController::class, 'dashboard'])->name('dashboardadmin');
});


// ===============================
// ADMIN
// ===============================

Route::middleware(['auth', 'admin'])->group(function () {


    // ===============================
    // ADMIN USER
    // ===============================

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');

    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.create');

    Route::post('/admin/users/store', [AdminUserController::class, 'store'])->name('admin.store');

    Route::get('/admin/users/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.edit');

    Route::post('/admin/users/update/{id}', [AdminUserController::class, 'update'])->name('admin.update');

    Route::delete('/admin/users/delete/{id}', [AdminUserController::class, 'destroy'])->name('admin.delete');


    // ===============================
    // ADMIN ORDERS / RESERVATION
    // ===============================

    Route::get('/admin/orders/search', [ReservationAdminController::class, 'search'])
        ->name('orders.search');

    Route::get('/admin/orders', [ReservationAdminController::class, 'index'])
        ->name('orders.index');


    Route::get('/admin/orders/{id}', [ReservationAdminController::class, 'show'])
        ->name('orders.show');


    Route::post('/admin/orders/{id}/status', [ReservationAdminController::class, 'updateStatusAjax'])
        ->name('orders.updateStatusAjax');


    // ===============================
    // REPORT
    // ===============================

    Route::get('/admin/report', [ReservationAdminController::class, 'report'])
        ->name('report');


    Route::get('/admin/report/pdf', [ReservationAdminController::class, 'exportPdf'])
        ->name('report.pdf');


    // commit ke master


});