<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->name('products.')->controller(ProductController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{product}/edit', 'edit')->name('edit');
        Route::put('{product}', 'update')->name('update');
        Route::delete('{product}', 'destroy')->name('destroy');
    });