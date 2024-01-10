<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GroupByAndOrderByRelatedColumnEloquentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\GroupByAndOrderRelatedColumnControllerWithEloquent
     * @return void
     */
    public function test_group_by_and_order_by_related_column_eloquent(): void
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
        ]);
        $order2->products()->attach($product2->id, ['quantity' => 10]);
        $order2->products()->attach($product3->id, ['quantity' => 10]);

        $order3 = Order::factory()->create([
            'user_id' => User::where(['name' => 'User 2'])->first()->id,
            'total' => 50,
        ]);
        $order3->products()->attach($product2->id, ['quantity' => 10]);

        $data = Order::selectRaw(
            'users.name as user_name, sum(orders.total) as order_total, sum(order_p.total) as total_products'
        )
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join(
                DB::raw('(select order_id, count(*) as total
                     from `order_product`
                     group by order_id) as order_p'),
                'order_p.order_id', '=', 'orders.id',
            )
            ->groupBy('user_name')
            ->orderBy('total_products', 'desc')
            ->get()
            ->toArray();

        // User 2 has 2 orders with 3 products in total
        // Order 1: has 2 products, total 150. Order 2: has 1 product, total 50

        // User 1 has 1 order with 1 product in total
        $expected = [
            [
                'user_name' => 'User 2',
                'order_total' => 200_00,
                'total_products' => 3,
            ],
            [
                'user_name' => 'User 1',
                'order_total' => 100_00,
                'total_products' => 1,
            ],
        ];

        $this->assertEquals($expected, $data);
    }

}
