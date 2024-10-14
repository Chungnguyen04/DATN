<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::controller(CategoryController::class)
        ->name('categories.')
        ->prefix('categories')
        ->group(function () {
            Route::get('/', 'listCategories')
                ->name('listCategories');

            Route::get('/create', 'createCategories')
                ->name('createCategories');

            Route::post('/store', 'storeCategories')
                ->name('storeCategories');

            Route::get('/edit/{id}', 'editCategories')
                ->name('editCategories');

            Route::post('/update/{id}', 'updateCategories')
                ->name('updateCategories');

            Route::post('/delete/{id}', 'deleteCategories')
                ->name('deleteCategories');
        });

});
