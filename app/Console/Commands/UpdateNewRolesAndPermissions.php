<?php

namespace App\Console\Commands;

use App\Enums\Permissions;
use App\Enums\Roles;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateNewRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role-permission:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create new roles and permissions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->rolesUpdate();
        $this->permissionsUpdate();
    }

    public function rolesUpdate(): void
    {
        $permissions = Permissions::values();
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }
        $this->comment('Permissions updated successfully');
    }

    public function permissionsUpdate(): void
    {
        $roles = Roles::values();
        foreach ($roles as $role) {
            Role::findOrCreate($role);
        }
        $this->comment('Roles updated successfully');
    }
}
