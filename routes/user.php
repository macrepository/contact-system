<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAuthController;

Route::middleware('guest')->group(function () {
    Route::get('/user/register', [UserAuthController::class, 'createRegister'])
        ->name('register');

    Route::post('/user/register', [UserAuthController::class, 'create']);

    Route::get('/user/login', [UserAuthController::class, 'createLogin'])
        ->name('login');

    Route::post('/user/login', [UserAuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/user/logout', [UserAuthController::class, 'logout'])
        ->name('logout');

    Route::get('/user/registered', function () {
        return view('pages.auth.new-registered');
    })->name('userRegistered');
});
