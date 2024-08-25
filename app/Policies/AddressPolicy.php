<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Address;
use App\Models\User;

class AddressPolicy
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
        return $user->hasPermissionTo(Permissions::ADDRESS_CREATE);
    }

    public function update(User $user, Address $address): bool
    {
        if ($user->hasPermissionTo(Permissions::ADDRESS_EDIT)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::ADDRESS_SELF_EDIT)
            && $address->user_id === $user->id;
    }

    public function delete(User $user, Address $address): bool
    {
        if ($user->hasPermissionTo(Permissions::ADDRESS_DELETE)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::ADDRESS_SELF_DELETE)
            && $address->user_id === $user->id;
    }

    public function view(User $user, Address $address): bool
    {
        if ($user->hasPermissionTo(Permissions::ADDRESS_VIEW)) {
            return true;
        }

        return $address->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::ADDRESS_VIEW);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::ADDRESS_DELETE);
    }
}
