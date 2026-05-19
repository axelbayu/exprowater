<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');

})->name('auth.login');

Route::resource('orders', OrderController::class)->except(['show']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
