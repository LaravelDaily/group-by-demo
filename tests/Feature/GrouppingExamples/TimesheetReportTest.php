<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Employee;
use App\Models\EmployeeTimesheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TimesheetReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\EmployeeTimesheetController
     * @return void
     */
    public function test_employee_timesheet_report(): void
    {
        $employee1 = Employee::factory()->create();
        $timesheet1 = EmployeeTimesheet::factory()
            ->create([
                'employee_id' => $employee1->id,
                'start' => now()->subDays(5)->setHour(8)->setMinute(55)->setSecond(15),
                'end' => now()->subDays(5)->setHour(13)->setMinute(8)->setSecond(26),
            ]);

        $employee2 = Employee::factory()->create();
        $timesheet3 = EmployeeTimesheet::factory()
            ->create([
                'employee_id' => $employee2->id,
                'start' => now()->subDays(3)->setHour(2)->setMinute(9)->setSecond(46),
                'end' => now()->subDays(3)->setHour(7)->setMinute(8)->setSecond(52),
            ]);
        $timesheet4 = EmployeeTimesheet::factory()
            ->create([
                'employee_id' => $employee2->id,
                'start' => now()->subDays(2)->setHour(2)->setMinute(9)->setSecond(46),
                'end' => now()->subDays(2)->setHour(7)->setMinute(8)->setSecond(52),
            ]);

        $data = EmployeeTimesheet::query()
            ->select('employee_id')
            ->addSelect(
                DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end, start)))) as `total_hours`'),
            )
            ->addSelect(
                DB::raw('min(start) as `min_start`'),
            )
            ->addSelect(
                DB::raw('max(end) as `max_end`'),
            )
            ->addSelect(
                DB::raw('count(distinct(start)) as `total_days`')
            )
            ->where('start', '>=', now()->startOfMonth())
            ->where('end', '<=', now()->endOfMonth())
            ->with(['employee'])
            ->groupBy('employee_id')
            ->orderBy('total_hours', 'desc')
            ->get()
            ->toArray();

        $expected = [
            [
                "employee_id" => $employee2->id,
                "total_hours" => "09:58:12",
                "min_start" => $timesheet3->start->format('Y-m-d H:i:s'),
                "max_end" => $timesheet4->end->format('Y-m-d H:i:s'),
                "total_days" => 2,
                "employee" => [
                    "id" => $employee2->id,
                    "name" => $employee2->name,
                    "created_at" => $employee2->created_at->toISOString(),
                    "updated_at" => $employee2->updated_at->toISOString(),
                ]
            ],
            [
                "employee_id" => $employee1->id,
                "total_hours" => "04:13:11",
                "min_start" => $timesheet1->start->format('Y-m-d H:i:s'),
                "max_end" => $timesheet1->end->format('Y-m-d H:i:s'),
                "total_days" => 1,
                "employee" => [
                    "id" => $employee1->id,
                    "name" => $employee1->name,
                    "created_at" => $employee1->created_at->toISOString(),
                    "updated_at" => $employee1->updated_at->toISOString(),
                ]
            ],
        ];

        $this->assertEquals($expected, $data);
    }
}
