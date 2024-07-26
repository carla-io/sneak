<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SalesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Products CRUD

Route::get('products', [ProductController::class, 'index']);
Route::post('create-product', [ProductController::class, 'create']);
Route::post('update-product', [ProductController::class, 'update']);
Route::delete('delete-product', [ProductController::class, 'delete']);
Route::get('products/{id}', [ProductController::class, 'show']);

//category CRUD

Route::get('category', [CategoryController::class, 'index']);
Route::post('create-category', [CategoryController::class, 'create']);
Route::post('update-category', [CategoryController::class, 'update']);
Route::delete('delete-category', [CategoryController::class, 'delete']);

Route::post('checkout', [OrderController::class, 'checkout'])->middleware('auth:sanctum');

Route::get('search', [SearchController::class, 'search']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/update-role/{userId}', [AdminController::class, 'updateRole']);
    Route::post('/admin/deactivate-user/{userId}', [AdminController::class, 'deactivateUser']);
    
    Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart', [CartController::class, 'getCart']);
Route::post('/cart/checkout', [CartController::class, 'checkout']);
Route::post('/cart/remove', [CartController::class, 'remove']);

    
});

Route::middleware('auth:sanctum')->get('orders', [OrderController::class, 'index']);
Route::middleware('auth:sanctum')->post('create-orders', [OrderController::class, 'store']);

Route::middleware('auth:sanctum')->get('sales', [SalesController::class, 'index']);
