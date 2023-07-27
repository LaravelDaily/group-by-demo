<?php

namespace App\Http\Controllers;

use DB;

class GroupByRelatedColumnController extends Controller
{
    public function __invoke()
    {
        $orders = DB::table('orders')
            ->selectRaw(
                'users.name as user_name, sum(orders.total) as total, count(order_product.product_id) as total_products'
            )
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->groupBy('user_name')
            ->get();

        return view('examples.groupByRelatedColumn', [
            'orders' => $orders
        ]);
    }
}
