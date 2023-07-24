<?php

namespace App\Http\Controllers;

use App\Models\Order;

class GroupByRawDayWithEloquent extends Controller
{
    public function __invoke()
    {
        $orders = Order::selectRaw(
            'day(orders.order_time) as day, sum(order_product.quantity) as total_quantity, sum(orders.total) as order_total, count(*) as total_orders'
        )
            ->join('order_product', 'order_id', '=', 'orders.id')
            ->groupByRaw('day(orders.order_time)')
            ->orderBy('day')
            ->orderBy('total_orders', 'desc')
            ->get();

        return view('examples.groupByRawDayWithEloquent', [
            'orders' => $orders
        ]);
    }
}
