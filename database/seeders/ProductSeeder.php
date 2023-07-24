<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = Product::factory()
            ->count(500)
            ->create()
            ->pluck('id');

        foreach (Order::get() as $order) {
            for ($i = 1; $i < random_int(1, 5); $i++) {
                $order->products()->attach($products->random(), [
                    'quantity' => random_int(1, 5),
                ]);
            }
        }
    }
}
