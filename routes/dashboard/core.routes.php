<?php

use App\Http\Controllers\Dashboard\Core\FileController;

route_group('core', function () {

    route_group('administration', function () {
        Route::resources([
            'admins' => 'AdminController',
            'roles' => 'RoleController',
            'profile' => 'AdminProfileController',
        ]);
    });

    Route::resources([
        'areas' => 'AreaController',
        'pages' => 'PageController',
        'faqs' => 'FaqsController',
        'galleries' => 'GalleryController',
        'contacts' => 'ContactUsController',
        'categories' => 'CategoryController',
    ]);
    Route::any('/upload-file', [FileController::class, 'uploadFile'])->name('upload.file');
    Route::any('/delete-file', [FileController::class, 'deleteFile'])->name('delete.file');
    Route::any('/delete-file-by-id', [FileController::class, 'deleteFileById'])->name('delete.file.by.id');
});
