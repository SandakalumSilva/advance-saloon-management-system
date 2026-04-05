<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;


Route::prefix('services')->name('services.')->controller(ServiceController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{service}/edit', 'edit')->name('edit');
        Route::put('{service}', 'update')->name('update');
        Route::delete('{service}', 'destroy')->name('destroy');
    });