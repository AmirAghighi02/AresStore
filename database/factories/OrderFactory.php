<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tax' => $this->faker->randomNumber(4, true),
            'shipping_cost' => $this->faker->randomNumber(5, true),
            'total_price' => $this->faker->randomNumber(7, true),
            'status' => Arr::random(OrderStatus::values()),
            'payment_id' => Payment::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'address' => Address::inRandomOrder()->first()->id,
        ];
    }
}
