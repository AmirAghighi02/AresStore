<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignRolePermissionsToUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::findByName(Roles::ADMIN->value)->givePermissionTo(Permissions::adminPermissions());
        Role::findByName(Roles::SUPER_ADMIN->value)->givePermissionTo(Permissions::superAdminPermissions());
        Role::findByName(Roles::SELLER->value)->givePermissionTo(Permissions::sellerPermissions());
        Role::findByName(Roles::COSTUMER->value)->givePermissionTo(Permissions::costumerPermissions());

        User::where('name', 'admin')->first()->assignRole(Roles::ADMIN);
        User::where('name', 'super_admin')->first()->assignRole(Roles::SUPER_ADMIN);
        User::where('name', 'seller')->first()->assignRole(Roles::SELLER);
        User::where('name', 'costumer')->first()->assignRole(Roles::COSTUMER);
    }
}
