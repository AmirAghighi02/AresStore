<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\User;
use App\Models\Wallet;

class WalletPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Wallet $wallet): bool
    {
        if ($user->hasPermissionTo(Permissions::WALLET_VIEW)) {
            return true;
        }

        return $wallet->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::WALLET_VIEW);
    }

    public function chargeSelf(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::WALLET_SELF_CHARGE);
    }

    public function withdrawSelf(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::WALLET_SELF_WITHDRAW);
    }
}
