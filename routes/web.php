<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::prefix('admin')->name('admin.')->group(function() {

});
