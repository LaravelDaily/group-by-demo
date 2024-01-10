<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class GroupByRawMonthWithEloquent extends Controller
{
    public function __invoke()
    {
        $orders = Order::selectRaw(
            'month(orders.order_time) as month, sum(order_p.quantity) as total_quantity, sum(orders.total) as order_total, count(distinct id) as total_orders'
        )
            ->join(
                DB::raw('(select order_id, sum(quantity) as quantity
                     from `order_product`
                     group by order_id) as order_p'),
                'order_p.order_id', '=', 'orders.id',
            )
            ->groupByRaw('month(orders.order_time)')
            ->orderBy('month')
            ->orderBy('total_orders', 'desc')
            ->get();

        return view('examples.groupByRawMonthWithEloquent', [
            'orders' => $orders
        ]);
    }
}
