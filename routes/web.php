<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', [MenuController::class, 'index']);


Route::get('/user/reserved', function () {
    return view('user.reserved');
})->name('reserved');


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


Route::get('/products/add', [ProductController::class, 'add'])->name('products.add');
Route::post('/products', [ProductController::class, 'store'])->name('createProducts');

Route::get('/login', [LoginAdminController::class, 'loginForm']);
Route::post('/login', [LoginAdminController::class, 'login']);
Route::get('/logout', [LoginAdminController::class, 'logout']);