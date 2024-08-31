<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersControllers;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('admin/products', ProductController::class);
//     Route::resource('admin/orders', OrderController::class);
//     Route::resource('admin/users', UserController::class);
// });
// Auth Routes
Auth::routes();
Auth::routes();

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('signin');
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Admin Routes (protected by 'auth' and 'role:admin' middleware)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrdersControllers::class);
        Route::get('admin/orders/{order}', [OrdersControllers::class, 'show'])->name('admin.orders.show');
        Route::get('orders/export', [OrdersControllers::class, 'export'])->name('orders.export'); // Rute ekspor
        Route::resource('users', UserController::class);
    });

    // User Routes (protected by 'auth' middleware)
    Route::resource('orders', OrderController::class)->only(['create', 'store', 'index']);
});
