<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
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

// Route::prefix('roles')->name('roles.')->middleware(['auth'])->controller(RoleController::class)->group(function () {
//     Route::get('/', 'index')->name('index');
//     Route::post('/', 'store')->name('store');

//     Route::get('{role}', 'show')->name('show');
//     Route::put('{role}', 'update')->name('update');
//     Route::delete('{role}', 'destroy')->name('destroy');

//     Route::get('{role}/permissions', 'permissions')->name('permissions');
//     Route::put('{role}/permissions', 'updatePermissions')->name('permissions.update');
// });

// Route::resource('users', UserController::class);

Route::prefix('users')->name('users.')->middleware(['auth'])->controller(UserController::class)->group(function () {

    Route::get('/', 'index')->middleware('can:users.view')->name('index');
    Route::post('/', 'store')->middleware('can:users.create')->name('store');
    Route::get('{user}/edit', 'edit')->middleware('can:users.edit')->name('edit');
    Route::put('{user}', 'update')->middleware('can:users.edit')->name('update');
    Route::delete('{user}', 'destroy')->middleware('can:users.delete')->name('destroy');
});

Route::prefix('category')->name('category.')->middleware(['auth'])->controller(CategoryController::class)->group(function () {

    Route::get('/', 'index')->name('index');
});

Route::prefix('service-categories')->name('service-categories.')->middleware(['auth'])->controller(ServiceCategoryController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{serviceCategory}/edit', 'edit')->name('edit');
        Route::put('{serviceCategory}', 'update')->name('update');
        Route::delete('{serviceCategory}', 'destroy')->name('destroy');
    });

Route::prefix('product-categories')->name('product-categories.')->middleware(['auth'])->controller(ProductCategoryController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{productCategory}/edit', 'edit')->name('edit');
        Route::put('{productCategory}', 'update')->name('update');
        Route::delete('{productCategory}', 'destroy')->name('destroy');
    });

Route::prefix('services')->name('services.')->middleware(['auth'])->controller(ServiceController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{service}/edit', 'edit')->name('edit');
        Route::put('{service}', 'update')->name('update');
        Route::delete('{service}', 'destroy')->name('destroy');
    });

Route::prefix('products')->name('products.')->middleware(['auth'])->controller(ProductController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{product}/edit', 'edit')->name('edit');
        Route::put('{product}', 'update')->name('update');
        Route::delete('{product}', 'destroy')->name('destroy');
    });



require __DIR__ . '/auth.php';
