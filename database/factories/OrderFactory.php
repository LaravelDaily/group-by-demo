<?php

namespace Database\Factories;

use App\Enum\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $pre_tax = $this->faker->randomFloat(2, 5, 10_000);
        $tax = $pre_tax * 0.21;
        return [
            'user_id' => User::factory(),
            'status' => collect(OrderStatus::getValues())->random(),
            'order_time' => fake()->dateTime(),
            'delivery_time' => fake()->dateTime(now()->addMonth()),
            'pre_tax' => $pre_tax,
            'tax' => $tax,
            'total' => $pre_tax + $tax,
        ];
    }
}
