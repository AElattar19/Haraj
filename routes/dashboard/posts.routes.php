<?php

use App\Http\Controllers\Dashboard\Post\PostController;

route_group('post', function () {

    Route::resources([
        'posts' => 'PostController',
    ]);
    Route::get('load/areas', [PostController::class, 'loadAreas'])->name('loadAreas');
    Route::get('load/cats', [PostController::class, 'loadCats'])->name('loadCats');
});
