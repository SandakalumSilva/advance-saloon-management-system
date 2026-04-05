<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('category')->name('category.')->middleware(['auth'])->controller(CategoryController::class)->group(function () {

    Route::get('/', 'index')->name('index');
});
