<?php

use App\Enums\Permissions;
use App\Http\Controllers\Costumer\CartController;
use Illuminate\Support\Facades\Route;

Route::controller(CartController::class)
    ->middleware('auth:sanctum')
    ->prefix('cart')
    ->group(function () {
        Route::post('/add-item', 'storeItem')
            ->permission(Permissions::CART_ADD_ITEM_SELF->value)
            ->name('cart.item.store');
        Route::delete('/remove-item', 'destroyItem')
            ->permission(Permissions::CART_DELETE_ITEM_SELF->value)
            ->name('cart.item.destroy');
        Route::post('/pay', 'pay')
            ->permission(Permissions::CART_PAY_SELF->value)
            ->name('cart.pay');
        Route::delete('/', 'destroy')
            ->permission(Permissions::CART_DELETE_ITEM_SELF->value)
            ->name('cart.destroy');
    });
