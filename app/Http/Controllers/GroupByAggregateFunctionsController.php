<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupByAggregateFunctionsController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::query();

        switch ($request->input('value')) {
            case 'sum':
            default:
                $orders = $orders->select('user_id', DB::raw('sum(total) as value'));
                break;
            case 'avg':
                $orders = $orders->select('user_id', DB::raw('avg(total) as value'));
                break;
            case 'min':
                $orders = $orders->select('user_id', DB::raw('min(total) as value'));
                break;
            case 'max':
                $orders = $orders->select('user_id', DB::raw('max(total) as value'));
                break;
            case 'count':
                $orders = $orders->select('user_id', DB::raw('count(total) as value'));
                break;
        }

        $orders = $orders->with('user:name,id')
            ->groupBy('user_id')
            ->get();

        return view('examples.groupByAggregateFunctions', [
            'orders' => $orders
        ]);
    }
}
