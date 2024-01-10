<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GroupByAggregateWithCalculationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\GroupByAggregateWithCalculationsController
     * @return void
     */
    public function test_group_by_aggregate_with_calculations_example(): void
    {
        Product::factory()
            ->create([
                'name' => 'Product 1',
                'stock_quantity' => 10,
            ]);
        Product::factory()
            ->create([
                'name' => 'Product 2',
                'stock_quantity' => 20,
            ]);

        $order = Order::factory()->create();
        $order->products()->attach(1, ['quantity' => 5]);

        $order2 = Order::factory()->create();
        $order2->products()->attach(2, ['quantity' => 10]);

        $data = Product::query()
            ->select(['name', 'stock_quantity'])
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->addSelect(DB::raw('SUM(order_product.quantity) + products.stock_quantity as total_quantity'))
            ->groupBy('products.id')
            ->get()
            ->toArray();

        $expected = [
            [
                'name' => 'Product 1',
                'stock_quantity' => 10,
                'total_quantity' => 15,
            ],
            [
                'name' => 'Product 2',
                'stock_quantity' => 20,
                'total_quantity' => 30,
            ],
        ];

        $this->assertEquals($expected, $data);
    }

}
