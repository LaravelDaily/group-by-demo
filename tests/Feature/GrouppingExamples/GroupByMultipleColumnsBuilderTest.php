<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupByMultipleColumnsBuilderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\GroupByMultipleColumnsBuilder
     * @return void
     */
    public function test_group_by_multiple_columns_builder(): void
    {
        $product = Product::factory()->create([
            'name' => 'Projector - 920'
        ]);
        $order = Order::factory()
            ->create([
                'total' => 150,
                'order_time' => now()->setMonth(3)
            ]);
        $order->products()->attach($product->id, ['quantity' => 10]);


        $product2 = Product::factory()->create([
            'name' => 'Computer - 920'
        ]);
        $product3 = Product::factory()->create([
            'name' => 'Phone - 920'
        ]);
        $order2 = Order::factory()
            ->create([
                'total' => 400,
                'order_time' => now()->setMonth(5)
            ]);
        $order2->products()->attach($product2->id, ['quantity' => 5]);
        $order2->products()->attach($product3->id, ['quantity' => 15]);

        $order3 = Order::factory()
            ->create([
                'total' => 300,
                'order_time' => now()->setMonth(5)
            ]);
        $order3->products()->attach($product->id, ['quantity' => 10]);

        $data = Order::selectRaw(
            'month(orders.order_time) as month, sum(order_product.quantity) as total_quantity, sum(orders.total) as order_total, count(*) as total_orders, products.name as product_name'
        )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->groupByRaw('month(orders.order_time), product_name')
            ->orderBy('month')
            ->orderBy('total_orders', 'desc')
            ->get()
            ->toArray();

        $expected = [
            [
                "month" => 3,
                "total_quantity" => "10",
                "order_total" => "15000",
                "total_orders" => 1,
                "product_name" => "Projector - 920"
            ],
            [
                "month" => 5,
                "total_quantity" => "5",
                "order_total" => "40000",
                "total_orders" => 1,
                "product_name" => "Computer - 920"
            ],
            [
                "month" => 5,
                "total_quantity" => "15",
                "order_total" => "40000",
                "total_orders" => 1,
                "product_name" => "Phone - 920"
            ],
            [
                "month" => 5,
                "total_quantity" => "10",
                "order_total" => "30000",
                "total_orders" => 1,
                "product_name" => "Projector - 920"
            ],
        ];

        $this->assertEquals($expected, $data);
    }
}
