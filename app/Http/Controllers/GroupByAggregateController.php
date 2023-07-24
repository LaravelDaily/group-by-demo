<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DB;

class GroupByAggregateController extends Controller
{
    public function __invoke()
    {
        $orders = Order::query()
            ->select('user_id', DB::raw('sum(total) as total'))
            ->with('user:name,id')
            ->groupBy('user_id')
            ->get();

        return view('examples.groupByAggregate', [
            'orders' => $orders
        ]);
    }
}
