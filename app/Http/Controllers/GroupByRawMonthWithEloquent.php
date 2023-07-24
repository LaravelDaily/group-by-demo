<?php

namespace App\Http\Controllers;

use App\Models\Order;

class GroupByRawMonthWithEloquent extends Controller
{
    public function __invoke()
    {
        $orders = Order::selectRaw(
            'month(orders.order_time) as month, sum(order_product.quantity) as total_quantity, sum(orders.total) as order_total, count(*) as total_orders'
        )
            ->join('order_product', 'order_id', '=', 'orders.id')
            ->groupByRaw('month(orders.order_time)')
            ->orderBy('month')
            ->orderBy('total_orders', 'desc')
            ->get();

        return view('examples.groupByRawMonthWithEloquent', [
            'orders' => $orders
        ]);
    }
}
