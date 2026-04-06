<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->name('settings.')->controller(SettingsController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });