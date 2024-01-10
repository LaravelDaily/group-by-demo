<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class GroupByRawDayWithEloquent extends Controller
{
    public function __invoke()
    {
        $orders = Order::selectRaw(
            'day(orders.order_time) as day, sum(order_p.quantity) as total_quantity, sum(orders.total) as order_total, count(distinct id) as total_orders'
        )
            ->join(
                DB::raw('(select order_id, sum(quantity) as quantity
                     from `order_product`
                     group by order_id) as order_p'),
                'order_p.order_id', '=', 'orders.id',
            )
            ->groupByRaw('day(orders.order_time)')
            ->orderBy('day')
            ->orderBy('total_orders', 'desc')
            ->get();

        return view('examples.groupByRawDayWithEloquent', [
            'orders' => $orders
        ]);
    }
}
