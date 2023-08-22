<?php

use App\Http\Controllers\Dashboard\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dashboard\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Dashboard\Auth\NewPasswordController;
use App\Http\Controllers\Dashboard\Auth\PasswordResetLinkController;

Route::get('/login', [AuthenticatedSessionController::class, 'loginForm'])
    ->middleware('guest:dashboard')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'doLogin'])
    ->middleware('guest:dashboard');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest:dashboard')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest:dashboard')
    ->name('password.email');



Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest:dashboard')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest:dashboard')
    ->name('password.update');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth:dashboard')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth:dashboard');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:dashboard')
    ->name('logout');
