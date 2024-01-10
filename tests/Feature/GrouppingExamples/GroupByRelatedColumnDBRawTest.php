<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GroupByRelatedColumnDBRawTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\GroupByRelatedColumnController
     * @return void
     */
    public function test_group_by_related_column_db_raw(): void
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

        $data = DB::table('orders')
            ->selectRaw(
                'users.name as user_name, sum(orders.total) as total, sum(order_p.total) as total_products'
            )
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join(
                DB::raw('(select order_id, count(*) as total
                     from `order_product`
                     group by order_id) as order_p'),
                'order_p.order_id', '=', 'orders.id',
            )
            ->groupBy('user_name')
            ->get()
            ->map(function ($item) {
                return [
                    'user_name' => $item->user_name,
                    'total' => $item->total,
                    'total_products' => $item->total_products,
                ];
            })
            ->toArray();

        $expected = [
            [
                'user_name' => 'User 1',
                'total' => 100_00,
                'total_products' => 1,
            ],
            [
                'user_name' => 'User 2',
                'total' => 150_00,
                'total_products' => 2,
            ],
        ];

        $this->assertEquals($expected, $data);
    }

}
