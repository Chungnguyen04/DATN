<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('product')
    ->name('product.')
    ->controller(ProductController::class)
    ->group(function () {

        // api
        Route::get('/product-list', 'index')
            ->name('index');
        // end api

        // api
        Route::get('/top5ProductNew', 'top5ProductNew')
            ->name('top5ProductNew');
        // end api

        // api
        Route::get('/product-detail/{id}', 'show')
            ->name('show');
        // end api

        // api
        Route::get('/category/{id}', 'getProductsByCategory')
            ->name('getProductsByCategory');
        // end api

        // api
        Route::get('/filterProducts', 'filterProducts')
            ->name('filterProducts');
        // end api

    });


Route::prefix('categories')
    ->name('categories.')
    ->controller(CategoryController::class)
    ->group(function () {

        // api
        Route::get('/list-category', 'getAllCategory')
            ->name('getAllCategory');
        // end api

    });


Route::prefix('carts')
    ->name('carts.')
    ->controller(CartController::class)
    ->group(function () {

        // api
        Route::get('/cart-list/{userId}', 'cartByUserId')
            ->name('cartByUserId');
        // end api

        // api
        Route::post('/addToCart', 'addToCart')
            ->name('addToCart');
        // end api

        // api
        Route::post('/update-quantity', 'updateQuantity')
            ->name('updateQuantity');
        // end api

    });
