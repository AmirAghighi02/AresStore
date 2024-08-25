<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::ORDER_CREATE);
    }

    public function update(User $user, Order $order): bool
    {
        if ($user->hasPermissionTo(Permissions::ORDER_EDIT)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::ORDER_SELF_EDIT)
            && $order->user_id === $user->id;
    }

    public function delete(User $user, Order $order): bool
    {
        if ($user->hasPermissionTo(Permissions::ORDER_DELETE)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::ORDER_SELF_DELETE)
            && $order->user_id === $user->id;
    }

    public function view(User $user, Order $order): bool
    {
        if ($user->hasPermissionTo(Permissions::ORDER_VIEW)) {
            return true;
        }

        return $order->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::ORDER_VIEW);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::ORDER_DELETE);
    }

    public function cancel(User $user, Order $order): bool
    {
        if ($user->hasPermissionTo(Permissions::ORDER_CANCEL)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::ORDER_SELF_CANCEL)
            && $order->user_id === $user->id;
    }
}
