<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;

class ActiveAndInactiveUsersController extends Controller
{
    public function __invoke()
    {
        $statusCount = User::query()
            ->addSelect(DB::raw('count(*) as count'))
            ->groupBy('active')
            ->get();

        return view('users.active-count', ['statusCount' => $statusCount]);
    }
}
