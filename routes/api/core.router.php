<?php

use App\Http\Controllers\Api\Area\AreaController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Core\ContactUsController;
use App\Http\Controllers\Api\Core\CoreController;
use App\Http\Controllers\Api\Core\HomeController;
use App\Http\Controllers\Api\Intro\IntroController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\Product\Operations\ProductOperationsController;
use App\Http\Controllers\Api\SinglePages\ProductController;
use App\Http\Controllers\Api\SinglePages\SettingsController;
use App\Http\Controllers\Api\SinglePages\StoreController;

Route::prefix('home')->group(function (){
    Route::get('/', [HomeController::class, 'index']);
    Route::post('/filter', [HomeController::class, 'filter']);
    Route::post('/search', [HomeController::class, 'search']);
    Route::post('/contact', [HomeController::class, 'ContactUs']);
});
Route::prefix('post')->group(function (){
    Route::get('/{id}', [PostController::class, 'show']);
});

Route::prefix('post')->middleware('auth:sanctum')->group(function (){
    Route::post('/comment', [PostController::class, 'addComment']);
    Route::post('/add', [PostController::class, 'addPost']);
});
Route::get('/faqs', [CoreController::class, 'getFaqs']);
Route::get('/page', [CoreController::class, 'getPage']);

Route::get('/area', [AreaController::class, 'getArea']);
Route::get('/area/{id}', [AreaController::class, 'getChildren']);

Route::get('/categories', [CategoryController::class, 'getcategory']);

