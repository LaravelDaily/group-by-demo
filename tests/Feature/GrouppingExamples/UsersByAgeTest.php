<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersByAgeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\UsersController
     * @return void
     */
    public function test_users_by_age(): void
    {
        User::factory()->count(2)->create(['age' => 20]);
        User::factory()->count(1)->create(['age' => 21]);
        User::factory()->count(5)->create(['age' => 22]);

        $data = User::query()
            ->get()
            ->countBy('age')
            ->sortKeys()
            ->toArray();

        $expected = [
            '20' => 2,
            '21' => 1,
            '22' => 5,
        ];

        $this->assertEquals($expected, $data);
    }
}
