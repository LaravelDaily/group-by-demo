<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GroupByRawMonthEloquentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\GroupByRawMonthWithEloquent
     * @return void
     */
    public function test_group_by_raw_month_eloquent(): void
    {
        $product = Product::factory()
            ->create([
                'name' => 'Product 1',
                'stock_quantity' => 10,
                'price' => 10
            ]);
        $order1 = Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 1'])->id,
            'total' => 100,
            'order_time' => now()->setMonth(1)
        ]);
        $order1->products()->attach($product->id, ['quantity' => 10]);
        $order1 = Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 1'])->id,
            'total' => 10,
            'order_time' => now()->setMonth(1)
        ]);
        $order1->products()->attach($product->id, ['quantity' => 10]);
        [$product2, $product3] = [
        Product::factory()
            ->create([
                'name' => 'Product 2',
                'stock_quantity' => 100,
                'price' => 15
            ]),
        Product::factory()
            ->create([
                'name' => 'Product 3',
                'stock_quantity' => 1000,
                'price' => 12
            ])
            ];

        $order2 = Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 2'])->id,
            'total' => 150,
            'order_time' => now()->setMonth(2)
        ]);
        $order2->products()->attach($product2->id, ['quantity' => 15]);
        $order2->products()->attach($product3->id, ['quantity' => 15]);

        $data = Order::selectRaw(
            'month(orders.order_time) as month, sum(order_p.quantity) as total_quantity, sum(orders.total) as order_total, count(distinct id) as total_orders'
        )
            ->join(
                DB::raw('(select order_id, sum(quantity) as quantity
                     from `order_product`
                     group by order_id) as order_p'),
                'order_p.order_id', '=', 'orders.id',
            )
            ->groupByRaw('month(orders.order_time)')
            ->orderBy('month')
            ->orderBy('total_orders', 'desc')
            ->get()
            ->toArray();

        // Month 1 has 2 orders with 1 product in each order
        // Month 2 has 1 order with 2 products
        $expected = [
            [
                'month' => 1,
                'total_quantity' => '20',
                'order_total' => '11000',
                'total_orders' => 2,
            ],
            [
                'month' => 2,
                'total_quantity' => '30',
                'order_total' => '15000',
                'total_orders' => 1,
            ],
        ];

        $this->assertEquals($expected, $data);
    }

}
