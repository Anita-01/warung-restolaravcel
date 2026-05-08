<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminUserController;


Route::get('/', [MenuController::class, 'index'])->name('index');





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
Route::post('/products/updateProduct', [ProductController::class, 'updateProduct'])->name('updateProduct');
Route::get('/products/search', [ProductController::class, 'search']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/user/menu', [UserController::class, 'index'])->name('viewmenu');
Route::get('/reserved', [UserController::class, 'createreserved'])->name('reserved');
Route::post('/reservation', [ReservationController::class, 'makeReservation'])->name('reservation.store');
Route::get('/queue-data', [ReservationController::class, 'queueData']);
Route::get('/reservation/{id}', [ReservationController::class, 'detailReservation'])->name('reservation.detail');
Route::get('/invoice/{id}', [ReservationController::class, 'downloadInvoice'])->name('invoice.download');
Route::view('/trace', 'user.trace')->name('trace');
Route::get('/trace-order', function () {return view('user.trace-form');})->name('trace.order');
Route::post('/trace-confirm',[ReservationController::class, 'traceOrder'])->name('trace.confirm');
Route::get('/product', [ProductController::class, 'viewMenu']) ->name('menu');


Route::get('/products/add', [ProductController::class, 'add'])->name('products.add');
Route::post('/products', [ProductController::class, 'store'])->name('createProducts');

Route::get('/login', [LoginAdminController::class, 'loginForm']);
Route::post('/login', [LoginAdminController::class, 'login']);
Route::get('/logout', [LoginAdminController::class, 'logout'])->name('logout');




/// routeadmin

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');

    Route::get('/admin/users/create', [AdminUserController::class, 'create']);
    Route::post('/admin/users/store', [AdminUserController::class, 'store']);

    Route::get('/admin/users/edit/{id}', [AdminUserController::class, 'edit']);
    Route::post('/admin/users/update/{id}', [AdminUserController::class, 'update']);

    Route::delete('/admin/users/delete/{id}', [AdminUserController::class, 'destroy']);

});