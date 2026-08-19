<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| Nonaktifkan registrasi publik dan reset password melalui email.
|
*/

Route::middleware('guest')->group(function () {

    Route::get('login', [
        AuthenticatedSessionController::class,
        'create',
    ])->name('login');

    Route::post('login', [
        AuthenticatedSessionController::class,
        'store',
    ]);

});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Confirm Password
    |--------------------------------------------------------------------------
    */

    Route::get('confirm-password', [
        ConfirmablePasswordController::class,
        'show',
    ])->name('password.confirm');

    Route::post('confirm-password', [
        ConfirmablePasswordController::class,
        'store',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Change Own Password
    |--------------------------------------------------------------------------
    |
    | halaman untuk mengganti password akun oleh user.
    |
    */

    Route::put('password', [
        PasswordController::class,
        'update',
    ])->name('password.update');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('logout', [
        AuthenticatedSessionController::class,
        'destroy',
    ])->name('logout');

});