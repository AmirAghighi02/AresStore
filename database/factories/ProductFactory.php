<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'price' => $this->faker->numberBetween(10000, 900000),
            'quantity' => $this->faker->numberBetween(0, 10),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
