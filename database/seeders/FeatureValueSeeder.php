<?php

namespace Database\Seeders;

use App\Models\FeatureValue;
use Illuminate\Database\Seeder;

class FeatureValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeatureValue::factory(DatabaseSeeder::$count * 3)->createMany();
    }
}
