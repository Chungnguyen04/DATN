<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\WeightController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Auth\AuthController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')
    ->group(function () {

Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('admin.login.form');

Route::post('/login', [AuthController::class, 'loginAdmin'])
    ->name('admin.login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/', [DashboardController::class, 'index'])
    ->middleware('isAdmin')
    ->name('admin.dashboard');

Route::controller(CategoryController::class)
    ->name('categories.')
    ->middleware('isAdmin')
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

Route::controller(ProductController::class)
    ->name('products.')
    ->middleware('isAdmin')
    ->prefix('products')
    ->group(function () {
        Route::get('/', 'index')
            ->name('index');

        Route::get('/create', 'create')
            ->name('create');

        Route::post('/store', 'store')
            ->name('store');

        Route::get('/edit/{id}', 'edit')
            ->name('edit');

        Route::post('/update/{id}', 'update')
            ->name('update');

        Route::post('/removeImage', 'removeImage')
            ->name('removeImage');

        Route::post('/removeVariant', 'removeVariant')
            ->name('removeVariant');

        Route::post('/delete/{id}', 'delete')
            ->name('delete');
    });

Route::controller(WeightController::class)
    ->name('weights.')
    ->middleware('isAdmin')
    ->prefix('weights')
    ->group(function () {
        Route::get('/', 'index')
            ->name('index');

        Route::get('/create', 'create')
            ->name('create');

        Route::get('/weights', 'weights')
            ->name('weights');

        Route::post('/store', 'store')
            ->name('store');

        Route::get('/edit/{id}', 'edit')
            ->name('edit');

        Route::post('/update/{id}', 'update')
            ->name('update');

        Route::post('/delete/{id}', 'delete')
            ->name('delete');
    });

Route::controller(OrderController::class)
    ->name('orders.')
    ->middleware('isAdmin')
    ->prefix('orders')
    ->group(function () {
        Route::get('/', 'index')
            ->name('index');

        Route::post('/update-order-status/{id}', 'updateOrderStatus')
            ->name('updateOrderStatus');

        Route::delete('/delete/{id}', 'delete')
            ->name('delete');
    });

Route::controller(VoucherController::class)
    ->name('vouchers.')
    ->middleware('isAdmin')
    ->prefix('vouchers')
    ->group(function () {
        Route::get('/', 'index')
            ->name('index');

        Route::get('/create', 'create')
            ->name('create');

        Route::post('/store', 'store')
            ->name('store');

        Route::get('/edit/{id}', 'edit')
            ->name('edit');

        Route::post('/update/{id}', 'update')
            ->name('update');

        Route::delete('/delete/{id}', 'delete')
            ->name('delete');
    });


Route::controller(CommentController::class)
->name('comments.')
->prefix('comments')
->group(function(){
    Route::get('/','index')
    ->name('index');
    Route::get('/edit/{id}','edit')
    ->name('edit');
    Route::put('/update/{comment}','update')
    ->name('update');
});
});