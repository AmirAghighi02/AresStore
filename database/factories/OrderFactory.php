<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
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
        $payment_id = Payment::doesntHave('order')
            ->where('status', PaymentStatus::SUCCESS->value)
            ->inRandomOrder()
            ->first()->id ?? 1;
        $user = User::has('addresses')->inRandomOrder()->first();

        return [
            'tax' => $this->faker->randomNumber(4, true),
            'shipping_cost' => $this->faker->randomNumber(5, true),
            'total_price' => $this->faker->randomNumber(7, true),
            'status' => Arr::random(OrderStatus::values()),
            'payment_id' => $payment_id,
            'user_id' => $user->id,
            'address_id' => $user->addresses->first->id,
        ];
    }
}
