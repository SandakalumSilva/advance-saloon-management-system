<?php

use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('product-categories')->name('product-categories.')->controller(ProductCategoryController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{productCategory}/edit', 'edit')->name('edit');
        Route::put('{productCategory}', 'update')->name('update');
        Route::delete('{productCategory}', 'destroy')->name('destroy');
    });
