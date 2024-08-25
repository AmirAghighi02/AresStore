<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Product;
use App\Models\User;

class ProductPolicy
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
        return $user->hasPermissionTo(Permissions::PRODUCT_CREATE);
    }

    public function update(User $user, Product $product): bool
    {
        if ($user->hasPermissionTo(Permissions::PRODUCT_EDIT)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::PRODUCT_SELF_EDIT)
            && $product->user_id === $user->id;
    }

    public function delete(User $user, Product $product): bool
    {
        if ($user->hasPermissionTo(Permissions::PRODUCT_DELETE)) {
            return true;
        }

        return $user->hasPermissionTo(Permissions::PRODUCT_SELF_DELETE)
            && $product->user_id === $user->id;
    }

    public function view(User $user, Product $product): bool
    {
        if ($user->hasPermissionTo(Permissions::PRODUCT_VIEW)) {
            return true;
        }

        return $product->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::PRODUCT_VIEW);
    }

    public function forceDelete(User $user): bool
    {
        return $user->hasPermissionTo(Permissions::PRODUCT_DELETE);
    }
}
