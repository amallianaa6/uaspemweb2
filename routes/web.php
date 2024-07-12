<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopsisController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', [HomeController::class, 'showregisterForm'])->name('register');
Route::post('/register', [HomeController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/topsis', [TopsisController::class, 'index'])->middleware('auth');
