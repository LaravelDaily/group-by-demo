<?php

namespace App\Http\Controllers;

use App\Models\Order;

class GroupByAndOrderRelatedColumnControllerWithEloquent extends Controller
{
    public function __invoke()
    {
        $orders = Order::selectRaw(
            'users.name as user_name, sum(orders.total) as order_total, count(order_product.product_id) as total_products'
        )
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->groupBy('user_name')
            ->orderBy('total_products', 'desc')
            ->get();

        return view('examples.groupByRelatedColumnEloquent', [
            'orders' => $orders
        ]);
    }
}
