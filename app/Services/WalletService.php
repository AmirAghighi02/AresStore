<?php

namespace App\Services;

use App\Enums\WalletTransactionType;
use App\Exceptions\Wallet\UserWalletException;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletService
{
    protected Wallet $wallet;

    public function __construct(public User $user)
    {
        $this->wallet = $this->user->wallet()->firstOrCreate();
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function charge(int $amount): WalletTransaction
    {
        return $this->wallet->walletTransactions()->create([
            'amount' => $amount,
            'type' => WalletTransactionType::MANUAL_CHARGE,
        ]);
    }

    public function withdraw(int $amount): WalletTransaction
    {
        if ($this->wallet->balance < $amount) {
            throw new UserWalletException('user.wallet.low_balance');
        }

        return $this->wallet->walletTransactions()->create([
            'amount' => abs($amount) * (-1),
            'type' => WalletTransactionType::WITHDRAW,
        ]);
    }
}
