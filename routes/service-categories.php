<?php

use App\Http\Controllers\ServiceCategoryController;
use Illuminate\Support\Facades\Route;



Route::prefix('service-categories')->name('service-categories.')->controller(ServiceCategoryController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{serviceCategory}/edit', 'edit')->name('edit');
        Route::put('{serviceCategory}', 'update')->name('update');
        Route::delete('{serviceCategory}', 'destroy')->name('destroy');
    });