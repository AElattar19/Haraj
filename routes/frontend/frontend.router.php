<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SocialController;
use App\Support\Actions\ChangeLocalizationAction;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ============= Social Login ================

Route::get('auth/social/{driver}', [SocialController::class, 'socialRedirect'])
     ->name('auth.social');

Route::get('auth/social/{driver}/callback', [SocialController::class, 'loginWithSocial'])
     ->name('auth.social.callback');

Route::get('/', 'HomeController@index')->name('home');
Route::post('/contact_us', 'HomeController@contact_us')->name('contactUs');
Route::get('change_locale/{locale}', [HomeController::class, 'change_local'])->name('change_locale');
