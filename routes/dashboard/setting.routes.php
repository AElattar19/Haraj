<?php

use App\Http\Controllers\Dashboard\Setting\SettingController;

route_group('setting', function () {

    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('info', [SettingController::class, 'infoSubmit'])->name('info_submit');
    Route::post('emails', [SettingController::class, 'emailsSubmit'])->name('emails_submit');
    Route::post('api-keys', [SettingController::class, 'apiKeysSubmit'])->name('api_keys_submit');
    Route::post('free-package', [SettingController::class, 'freePackageSubmit'])->name('free_package_submit');
    Route::post('style-submit', [SettingController::class, 'styleSubmit'])->name('style_submit');
    Route::post('deductions', [SettingController::class, 'deductions'])->name('deductions');
    Route::post('certificate', [SettingController::class, 'certificate'])->name('certificate');

});
