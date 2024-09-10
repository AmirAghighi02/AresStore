<?php

use App\Enums\Permissions;
use App\Http\Controllers\Costumer\CartController;
use Illuminate\Support\Facades\Route;

Route::controller(CartController::class)
    ->middleware('auth:sanctum')
    ->prefix('cart')
    ->group(function () {
        Route::post('/add', 'store')
            ->permission(Permissions::CART_ADD_ITEM_SELF->value)
            ->name('cart.store');
        Route::delete('/remove', 'destroy')
            ->permission(Permissions::CART_DELETE_ITEM_SELF->value)
            ->name('cart.destroy');
        Route::post('/pay', 'pay')
            ->permission(Permissions::CART_PAY_SELF->value)
            ->name('cart.pay');
    });
