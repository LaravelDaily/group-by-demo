<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeTimesheet;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Employee::factory()
            ->count(10)
            ->has(EmployeeTimesheet::factory()->count(14))
            ->create();
    }
}
