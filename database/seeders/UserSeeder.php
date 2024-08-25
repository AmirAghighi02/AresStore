<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create(['name' => 'admin']);
        User::factory()->create(['name' => 'super_admin']);
        User::factory()->create(['name' => 'seller']);
        User::factory()->create(['name' => 'costumer']);

        User::factory(DatabaseSeeder::$count)->create();
    }
}
