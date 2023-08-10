<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;

class OrdersByWeekController extends Controller
{
    public function __invoke()
    {
        $orders = Order::query()
            ->with(['products', 'user'])
            ->get();

        $orders = $orders
            ->groupBy(function (Order $order) {
                return Carbon::parse($order->order_time)->startOfWeek()->format('Y-m-d');
            })
            ->sortKeysDesc();

        return view('orders.by-week', [
            'orders' => $orders,
        ]);
    }
}
