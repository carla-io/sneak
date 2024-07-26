<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ShipperController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

// Handle login form submission
Route::post('/api/login', [AuthController::class, 'login']);

// Display the registration form
Route::get('/register', function () {
    return view('register');
})->name('register');

// Handle registration form submission
Route::post('/api/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->get('/api/check-auth', function () {
    return response()->json(['authenticated' => Auth::check(), 'user' => Auth::user()]);
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
});



//Admin Routes
Route::prefix('admin')->name('admin.')->group(function() {
    Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function() {
        
        Route::controller(DashboardController::class)->group(function(){
            Route::get('/dashboard', 'index')->name('home');
        });

        Route::controller(UserController::class)->group(function(){
            Route::get('/customers', 'index')->name('customers');
        });

        Route::controller(ProductController::class)->group(function(){
            Route::get('/product', 'index')->name('product');
            // Route::post('/product/import', 'import')->name('product.import');
        });

        Route::controller(CategoryController::class)->group(function(){
            Route::get('/category', 'index')->name('category');
        });

        Route::controller(OrderController::class)->group(function(){
            Route::get('/order', 'index')->name('order');
        });

        Route::controller(SupplierController::class)->group(function(){
            Route::get('/supplier', 'index')->name('supplier');
        });

        Route::controller(ShipperController::class)->group(function(){
            Route::get('/shipper', 'index')->name('shipper');
        });

    });
});
