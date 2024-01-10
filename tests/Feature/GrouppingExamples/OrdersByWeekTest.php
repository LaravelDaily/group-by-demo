<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrdersByWeekTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\OrdersByWeekController
     * @return void
     */
    public function test_orders_grouped_by_week_collection(): void
    {
        $order1 = Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 1'])->id,
            'total' => 100,
            'order_time' => now()->startOfWeek(),
            'tax' => 88
        ]);
        $order2 = Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 1'])->id,
            'total' => 100,
            'order_time' => now()->startOfWeek()->addDay(1),
            'tax' => 121
        ]);
        $order3 = Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 1'])->id,
            'total' => 100,
            'order_time' => now()->addWeek()->startOfWeek()->addDay(),
            'tax' => 100
        ]);

        $data = Order::query()
            ->with(['products'])
            ->get()
            ->groupBy(function (Order $order) {
                return Carbon::parse($order->order_time)->startOfWeek()->format('Y-m-d');
            })
            ->sortKeysDesc()
            ->toArray();

        $expected = [
            now()->addWeek()->startOfWeek()->format('Y-m-d') => [
                [
                    'user_id' => $order3->user_id,
                    'status' => $order3->status->value,
                    'order_time' => $order3->order_time->format('Y-m-d H:i:s'),
                    'delivery_time' => $order3->delivery_time->format('Y-m-d H:i:s'),
                    'pre_tax' => $order3->pre_tax,
                    'tax' => number_format($order3->tax, 2),
                    'total' => $order3->total,
                    'created_at' => $order3->created_at->toISOString(),
                    'updated_at' => $order3->updated_at->toISOString(),
                    'id' => $order3->id,
                    'products' => []
                ]
            ],
            now()->startOfWeek()->format('Y-m-d') => [
                [
                    'user_id' => $order1->user_id,
                    'status' => $order1->status->value,
                    'order_time' => $order1->order_time->format('Y-m-d H:i:s'),
                    'delivery_time' => $order1->delivery_time->format('Y-m-d H:i:s'),
                    'pre_tax' => $order1->pre_tax,
                    'tax' => number_format($order1->tax, 2),
                    'total' => $order1->total,
                    'created_at' => $order1->created_at->toISOString(),
                    'updated_at' => $order1->updated_at->toISOString(),
                    'id' => $order1->id,
                    'products' => []
                ],
                [
                    'user_id' => $order2->user_id,
                    'status' => $order2->status->value,
                    'order_time' => $order2->order_time->format('Y-m-d H:i:s'),
                    'delivery_time' => $order2->delivery_time->format('Y-m-d H:i:s'),
                    'pre_tax' => $order2->pre_tax,
                    'tax' => number_format($order2->tax, 2),
                    'total' => $order2->total,
                    'created_at' => $order2->created_at->toISOString(),
                    'updated_at' => $order2->updated_at->toISOString(),
                    'id' => $order2->id,
                    'products' => []
                ]
            ]
        ];

        $this->assertEquals($expected, $data);

    }
}
