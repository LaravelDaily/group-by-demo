<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function __invoke()
    {
        $orders = Order::query()
            ->with('user')
            ->get();

        return view('orders.dashboard', [
            'orders' => $orders
        ]);
    }
}
