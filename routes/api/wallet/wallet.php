<?php

use App\Http\Controllers\general\WalletController;
use App\Models\Wallet;
use Illuminate\Support\Facades\Route;

Route::controller(WalletController::class)
    ->middleware('auth:sanctum')
    ->prefix('wallet')
    ->group(function () {
        Route::get('/', 'index')
            ->can('viewAny', Wallet::class)
            ->name('wallet.index');

        Route::get('/balance', 'balance')
            ->name('wallet.balance');

        Route::get('/show/{?wallet}', 'show')
            ->can('view', 'wallet')
            ->name('wallet.show');

        Route::post('/charge', 'charge')
            ->can('chargeSelf', Wallet::class)
            ->name('wallet.charge');

        Route::post('/withdraw', 'withdraw')
            ->can('withdrawSelf', Wallet::class)
            ->name('wallet.withdraw');
    });
