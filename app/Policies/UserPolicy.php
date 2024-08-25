<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, User $targetUser): bool
    {
        if ($user->hasPermissionTo(Permissions::USER_EDIT)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::USER_SELF_EDIT)
            && $targetUser->id === $user->id;
    }

    public function delete(User $user, User $targetUser): bool
    {
        if ($user->hasPermissionTo(Permissions::USER_DELETE)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::USER_SELF_DELETE)
            && $targetUser->id === $user->id;
    }

    public function view(User $user, User $targetUser): bool
    {
        if ($user->hasPermissionTo(Permissions::USER_VIEW)) {
            return true;
        }

        return $targetUser->id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::USER_VIEW);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::USER_DELETE);
    }
}
