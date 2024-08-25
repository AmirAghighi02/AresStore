<?php

namespace App\Policies;

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
        return true;
    }

    public function update(User $user, Address $address) {}
}
