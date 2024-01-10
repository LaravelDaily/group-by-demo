<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimpleGroupByTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\GroupByController
     * @return void
     */
    public function test_group_by_example(): void
    {
        Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 1'])->id,
        ]);
        Order::factory()->create([
            'user_id' => User::factory()->create(['name' => 'User 2'])->id,
        ]);

        $list = Order::query()
            ->select('user_id')
            ->with('user:name,id')
            ->groupBy('user_id')
            ->get()
            ->toArray();

        $user1 = User::where('name', 'User 1')->first();
        $user2 = User::where('name', 'User 2')->first();
        $expect = [
            [
                'user_id' => $user1->id,
                'user' => [
                    'id' => $user1->id,
                    'name' => 'User 1'
                ],
            ],
            [
                'user_id' => $user2->id,
                'user' => [
                    'id' => $user2->id,
                    'name' => 'User 2'
                ],
            ]
        ];

        $this->assertEquals($expect, $list);
    }
}
