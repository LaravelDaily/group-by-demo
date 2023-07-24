<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $users = User::factory()->count(100)->create()->pluck('id');
        for ($i = 0; $i < 1_000; $i++) {
            Order::factory()
                ->create([
                    'user_id' => $users->random()
                ]);
        }
    }
}
