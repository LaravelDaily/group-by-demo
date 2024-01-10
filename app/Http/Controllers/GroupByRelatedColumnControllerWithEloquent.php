<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class GroupByRelatedColumnControllerWithEloquent extends Controller
{
    public function __invoke()
    {
        $orders = Order::selectRaw(
            'users.name as user_name, sum(orders.total) as order_total, sum(order_p.total) as total_products'
        )
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join(
                DB::raw('(select order_id, count(*) as total
                     from `order_product`
                     group by order_id) as order_p'),
                'order_p.order_id', '=', 'orders.id',
            )
            ->groupBy('user_name')
            ->get();

        return view('examples.groupByRelatedColumnEloquent', [
            'orders' => $orders
        ]);
    }
}
