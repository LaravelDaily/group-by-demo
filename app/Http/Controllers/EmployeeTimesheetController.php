<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTimesheet;
use DB;

class EmployeeTimesheetController extends Controller
{
    public function __invoke()
    {
        $timesheet = EmployeeTimesheet::query()
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
            ->get();

        return view('employee.timesheet', ['timesheet' => $timesheet]);
    }
}
