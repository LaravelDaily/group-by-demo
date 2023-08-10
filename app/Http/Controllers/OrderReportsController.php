<?php

namespace App\Http\Controllers;

use App\Enum\OrderStatus;
use App\Models\Order;
use Carbon\CarbonPeriod;

class OrderReportsController extends Controller
{
    public function __invoke()
    {
        $orders = collect([]);

        $periodInformation = CarbonPeriod::create(now()->subMonths(6)->startOfWeek(), '1 week', now()->endOfWeek());

        foreach ($periodInformation as $period) {
            $weekStart = $period->format('Y-m-d');
            $weekEnd = $period->copy()->endOfWeek()->format('Y-m-d');

            $orders->push([
                'week' => $weekStart . ' - ' . $weekEnd,
                'orders' => Order::query()
                    ->whereBetween('order_time', [$weekStart, $weekEnd])
                    ->withCount('products')
                    ->with(['user'])
                    ->where('status', '!=', OrderStatus::CANCELLED->value)
                    ->orderBy('status')
                    ->get()
            ]);
        }

        $orders = $orders->filter(function ($order) {
            return $order['orders']->count() > 0;
        });

        return view('orders.reports', [
            'orders' => $orders
        ]);
    }
}
