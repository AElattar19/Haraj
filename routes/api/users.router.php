<?php


use App\Http\Controllers\Api\User\FavouriteController;
use App\Http\Controllers\Api\User\UserProfileController;

Route::prefix('user')->group(function (){
    Route::get('favourites', [FavouriteController::class, 'favourites']);
    Route::get('/profile', [UserProfileController::class, 'UserProfile']);
    Route::post('add_to_fav', [FavouriteController::class, 'add_to_fav']);
});
