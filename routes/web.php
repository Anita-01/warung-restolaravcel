<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;

Route::get('/', [MenuController::class, 'index']);





Route::get('/admin/loginadmin', function () {
    return view('admin.loginadmin');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboardadmin', function () {
        return view('admin.dashboardadmin');
    })->name('dashboardadmin');
});


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/editmenu/{id}', [ProductController::class, 'edit'])->name('editmenu');
Route::post('/products/addmenu', [ProductController::class, 'store'])->name('addmenu');
Route::post('/products/updateProduct', [ProductController::class, 'updateProduct']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/user/menu', [UserController::class, 'index'])->name('viewmenu');
Route::get('/reserved', [UserController::class, 'createreserved'])->name('reserved');
Route::post('/reservation', [ReservationController::class, 'makeReservation'])->name('reservation.store');
Route::get('/queue-data', [ReservationController::class, 'queueData']);
Route::get('/reservation/{id}', [ReservationController::class, 'detailReservation'])->name('reservation.detail');
Route::get('/invoice/{id}', [ReservationController::class, 'downloadInvoice'])->name('invoice.download');
Route::get('/trace/{id}', [ReservationController::class, 'traceOrder'])->name('trace.order');


Route::get('/products/add', [ProductController::class, 'add'])->name('products.add');
Route::post('/products', [ProductController::class, 'store'])->name('createProducts');

Route::get('/login', [LoginAdminController::class, 'loginForm']);
Route::post('/login', [LoginAdminController::class, 'login']);
Route::get('/logout', [LoginAdminController::class, 'logout']);