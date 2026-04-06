<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffLeaveController;
use Illuminate\Support\Facades\Route;

Route::get('/get', function () {
    return view('index');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('roles', RoleController::class);
Route::get('roles/{role}/permissions', [RoleController::class, 'permissions'])->name('roles.permissions');
Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

Route::prefix('users')->name('users.')->middleware(['auth'])->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:users.view')->name('index');
    Route::post('/', 'store')->middleware('can:users.create')->name('store');
    Route::get('{user}/edit', 'edit')->middleware('can:users.edit')->name('edit');
    Route::put('{user}', 'update')->middleware('can:users.edit')->name('update');
    Route::delete('{user}', 'destroy')->middleware('can:users.delete')->name('destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    require __DIR__ . '/categories.php';
    require __DIR__ . '/service-categories.php';
    require __DIR__ . '/product-categories.php';
    require __DIR__ . '/services.php';
    require __DIR__ . '/products.php';
    require __DIR__ . '/customers.php';
    require __DIR__ . '/staff.php';
    require __DIR__ . '/settings.php';
});
