<?php

namespace App\Http\Controllers;

use App\Models\Order;

class GroupByMultipleColumnsErrorEloquent extends Controller
{
    public function __invoke()
    {
        // !!! This will throw an error
        $orders = Order::selectRaw(
            'month(orders.order_time) as month, sum(order_product.quantity) as total_quantity, sum(orders.total) as order_total, count(*) as total_orders, products.name as product_name'
        )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->groupByRaw('month(orders.order_time)')
            ->orderBy('month')
            ->orderBy('total_orders', 'desc')
            ->get();

        return view('examples.groupByMultipleColumnsEloquent', [
            'orders' => $orders
        ]);
    }
}
