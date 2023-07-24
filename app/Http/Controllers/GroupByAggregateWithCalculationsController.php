<?php

namespace App\Http\Controllers;

use App\Models\Product;
use DB;

class GroupByAggregateWithCalculationsController extends Controller
{
    public function __invoke()
    {
        $products = Product::query()
            ->select('*')
            ->addSelect(DB::raw('sum(price*stock_quantity) as stock_value'))
            ->groupBy('id')
            ->get();

        return view('examples.groupByAggregateWithCalculations', [
            'products' => $products
        ]);
    }
}
