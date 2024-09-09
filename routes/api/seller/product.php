<?php

use App\Http\Controllers\Seller\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::prefix('seller/product')
    ->middleware(['auth:sanctum'])
    ->controller(ProductController::class)
    ->group(static function () {
        Route::get('/index', 'index')
            ->can('viewAnySelf', Product::class)
            ->name('seller.product.index');

        Route::get('/show/{product}', 'show')
            ->can('view', 'product')
            ->name('seller.product.show');

        Route::post('/store', 'store')
            ->can('store', Product::class)
            ->name('seller.product.store');

        Route::post('/update/{product}', 'update')
            ->can('update', 'product')
            ->name('seller.product.update');
    });
