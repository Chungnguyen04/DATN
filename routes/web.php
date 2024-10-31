<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\WeightController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\VoucherController;
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

Route::get('/', function () {
    return view('Client.checkout');
});

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

    Route::controller(ProductController::class)
        ->name('products.')
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
        ->prefix('orders')
        ->group(function () {
            Route::get('/', 'index')
                ->name('index');

            Route::post('/update-order-status/{id}', 'updateOrderStatus')
                ->name('updateOrderStatus');

            Route::delete('/delete/{id}', 'delete')
                ->name('delete');
        });


});

       // Quản lí user
       Route::get('users', [UserController::class, 'listUser'])->name('Admin.pages.users.list_user'); 
       Route::get('add', [UserController::class, 'addUser'])->name('Admin.pages.users.add_user'); 
       Route::post('users/post', [UserController::class, 'addPost'])->name('addPost'); 
       Route::delete('delete/{id}', [UserController::class, 'deleteUser'])->name('deleteUser'); 
       
       Route::get('/admin/users/edit/{id}', [UserController::class, 'edit'])->name('Admin.pages.users.edit_user');
       Route::post('/admin/users/edit/{id}', [UserController::class, 'editPost'])->name('editPost');
       
       Route::controller(VoucherController::class)
       ->name('vouchers.')
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
       });
