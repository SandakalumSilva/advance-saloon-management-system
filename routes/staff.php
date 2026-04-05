<?php

use App\Http\Controllers\StaffLeaveController;
use Illuminate\Support\Facades\Route;

Route::prefix('staff')->name('staff.')->controller(StaffLeaveController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add-leave','addLeave')->name('add.leave');
    });
