<?php


use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Dashboard\Setting\SettingController;

Route::get('/user', [AuthController::class, 'user']);
Route::post('/edit/profile', [AuthController::class, 'edit_profile']);
Route::post('/change/password', [AuthController::class, 'change_password']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/delete_acc', [AuthController::class, 'delete_acc']);
Route::get('delete_acc_button', [AuthController::class, 'delete_acc_button'])->name('delete_acc_button');



