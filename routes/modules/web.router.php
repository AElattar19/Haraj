<?php

// Load Dashboard Routes

use App\Http\Controllers\Dashboard\Core\FileController;

Route::group(['middleware' => ['auth:dashboard']], static function () {
    $dashboard_route_glob = glob(app_path().'/Modules/**/routes/dashboard.php');
    foreach ($dashboard_route_glob as $file) {
        $str = explode('/', strtolower(substr($file, strpos($file, 'Modules'))));
        Route::group(['as' => "$str[1].dashboard.", 'prefix' => "$str[1]/dashboard/"],
            function () use ($file) {
                file_exists($file) ? include "$file" : '';
            }
        );
    }
});

// Load frontend Routes
$frontend_route_glob = glob(app_path().'/Modules/**/routes/frontend.php');
foreach ($frontend_route_glob as $file) {
    $str = explode('/', strtolower(substr($file, strpos($file, 'Modules'))));
    Route::group(['as' => "$str[1].frontend.", 'prefix' => "$str[1].frontend."],
        function () use ($file) {
            file_exists($file) ? include "$file" : '';
        }
    );
}

//general
Route::any('/upload-file', [FileController::class, 'uploadFile'])->name('upload.file');
Route::any('/delete-file', [FileController::class, 'deleteFile'])->name('delete.file');
Route::any('/delete-file-by-id', [FileController::class, 'deleteFileById'])->name('delete.file.by.id');
