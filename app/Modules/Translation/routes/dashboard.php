<?php

use Illuminate\Support\Facades\Route;
use Modules\Translation\Http\Controllers\Dashboard\TranslationController;

// ============= Users Ajax Route ==============

Route::get('/', [TranslationController::class, 'index'])->name('index');
Route::post('/add', [TranslationController::class, 'add'])->name('add');
Route::get('/listData', [TranslationController::class, 'listData'])->name('data');
Route::post('/update', [TranslationController::class, 'update'])->name('update');
Route::GET('/delete/{id}', [TranslationController::class, 'destroy'])->name('delete');
Route::GET('/generate-lang-files', [TranslationController::class, 'generateLangFiles'])->name('generateLangFiles');
Route::GET('/create-trans-table', [TranslationController::class, 'createTranslationTable'])->name('create.translation.table');
