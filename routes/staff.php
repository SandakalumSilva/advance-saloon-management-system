<?php

use App\Http\Controllers\StaffLeaveController;
use Illuminate\Support\Facades\Route;

Route::prefix('staff')
    ->name('staff.')
    ->middleware(['auth'])
    ->controller(StaffLeaveController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });