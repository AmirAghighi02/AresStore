<?php

namespace Database\Factories;

use App\Models\Feature;
use App\Models\FeatureValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureValueFactory extends Factory
{
    protected $model = FeatureValue::class;

    public function definition(): array
    {
        return [
            'feature_id' => Feature::inRandomOrder()->first()->id,
            'value' => $this->faker->colorName(),
        ];
    }
}
