<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('products.index');
    Route::get('users/{user}', [UserController::class, 'show'])->name('products.show');
    Route::post('users', [UserController::class, 'store'])->name('products.store');
    Route::post('login', 'login')->name('login');
});
