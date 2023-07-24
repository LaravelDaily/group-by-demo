<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $names = collect([
            'Computer',
            'Laptop',
            'Phone',
            'Tablet',
            'Watch',
            'TV',
            'Camera',
            'Headphones',
            'Keyboard',
            'Mouse',
            'Monitor',
            'Printer',
            'Speaker',
            'Projector',
            'Router',
            'Modem',
            'Server',
            'Microwave',
            'Refrigerator',
            'Oven',
            'Dishwasher',
        ]);
        return [
            'name' => $names->random() . ' - ' . random_int(1, 1000),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock_quantity' => random_int(1, 3000),
        ];
    }
}
