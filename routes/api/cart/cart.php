<?php

use App\Http\Controllers\Costumer\CartController;
use Illuminate\Support\Facades\Route;

Route::controller(CartController::class)
    ->middleware('auth:sanctum')
    ->prefix('cart')
    ->group(function () {
        Route::post('/add', 'store')
            ->can('');
        Route::post('/remove', 'destroy')
            ->can('');
    });
