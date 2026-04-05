<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;


Route::prefix('customers')->name('customers.')->controller(CustomerController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{customer}/edit', 'edit')->name('edit');
        Route::put('{customer}', 'update')->name('update');
        Route::delete('{customer}', 'destroy')->name('destroy');
    });