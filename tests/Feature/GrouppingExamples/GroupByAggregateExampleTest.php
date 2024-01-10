<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GroupByAggregateExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\GroupByAggregateController
     * @return void
     */
    public function test_group_by_aggregate_example(): void
    {
        Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 1'])->id,
        ]);
        Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 2'])->id,
        ]);

        $data = Order::query()
            ->select(['user_id', DB::raw('count(*) as total_orders')])
            ->withAggregate('user', 'name')
            ->groupBy('user_id')
            ->get()
            ->toArray();

        $expect = [
            [
                'user_id' => User::where(['name' => 'User 1'])->first()->id,
                'total_orders' => 1,
                'user_name' => 'User 1'
            ],
            [
                'user_id' => User::where(['name' => 'User 2'])->first()->id,
                'total_orders' => 1,
                'user_name' => 'User 2'
            ]
        ];

        $this->assertEquals($expect, $data);

        Order::factory()->create([
            'user_id' => User::where(['name' => 'User 1'])->first()->id,
        ]);
        Order::factory()->create([
            'user_id' => User::where(['name' => 'User 1'])->first()->id,
        ]);

        $data = Order::query()
            ->select(['user_id', DB::raw('count(*) as total_orders')])
            ->withAggregate('user', 'name')
            ->groupBy('user_id')
            ->get()
            ->toArray();

        $expect = [
            [
                'user_id' => User::where(['name' => 'User 1'])->first()->id,
                'total_orders' => 3,
                'user_name' => 'User 1'
            ],
            [
                'user_id' => User::where(['name' => 'User 2'])->first()->id,
                'total_orders' => 1,
                'user_name' => 'User 2'
            ]
        ];

        $this->assertEquals($expect, $data);
    }

}
