<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function (Request $request) {
    //session()->put('test', 'asd');

    return \App\Support\Api\ApiResponse::apiResponse(200, '', session()->all());
});

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/forget-password', [AuthController::class, 'forget']);
Route::post('/change-password-outside', [AuthController::class, 'forget_outside']);

require __DIR__ . '/core.router.php';

//Route::post('/payment-callback/{type?}',[CheckoutController::class,'callbackPayment']);

Route::middleware('auth:sanctum')->group(function () {

    require __DIR__ . '/auth.router.php';
    require __DIR__ . '/users.router.php';


});
