<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ActiveAndInactiveUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\ActiveAndInactiveUsersController
     * @return void
     */
    public function test_active_and_inactive_users_count(): void
    {
        User::factory()->count(5)->create(['active' => true]);
        User::factory()->count(10)->create(['active' => false]);
        $data = User::query()
            ->addSelect(DB::raw('count(*) as count'))
            ->groupBy('active')
            ->get()
            ->toArray();
        $expected = [
            ['count' => 5],
            ['count' => 10],
        ];

        $this->assertEquals($expected, $data);
    }
}
