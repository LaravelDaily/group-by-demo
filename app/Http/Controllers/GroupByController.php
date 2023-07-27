<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DB;

class GroupByController extends Controller
{
    public function __invoke()
    {
        $orders = Order::query()
            ->select('user_id')
            ->with('user:name,id')
            ->groupBy('user_id')
            ->get();

        return view('examples.groupBy', [
            'orders' => $orders
        ]);
    }
}
