<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static int $count = 20;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AddressSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            AssignRolePermissionsToUsers::class,
            ProductSeeder::class,
            CategorySeeder::class,
            FeatureSeeder::class,
            FeatureValueSeeder::class,
            PaymentSeeder::class,
            WalletSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
